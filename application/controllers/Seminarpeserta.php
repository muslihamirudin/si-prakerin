<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Seminarpeserta extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('seminar_model');
		$this->load->model(array('konsultasi_model', 'pembimbing_model'));
		$this->load->helper(array('notification', 'master'));
		$this->load->helper('master','tanggal_indo');
		$this->load->library('form_validation');
		! $this->session->userdata( 'level' ) ? redirect( site_url( 'main' ) ) : null;
	}

	public function index()
	{	
		$join = array('tahun_akademik', 'tb_waktu.id_tahun_akademik = tahun_akademik.id_tahun_akademik', 'inner');
		$tahunAkademik = datajoin('tb_waktu', null, 'tahun_akademik.tahun_akademik', $join);
		$level = $this->session->userdata('level');
		switch ($level) {
			case 'peserta':
				$data['menus'] = array(
					array(
						'name' => 'Lihat Jadwal Seminar PKL',
						'href' => site_url('seminarpeserta?m=seminarjadwalpes'),
						'icon' => 'fas fa-calendar',
						'desc' => 'Lihat Jadwal Seminar PKL. Anda juga dapat melakukan Gabung dan memilih mengikuti seminar sesuai penyaji yang ingin anda lihat'
					),
				);
				break;
			case 'dosen':
				$data['menus'] = array(
					array(
						'name' => 'Approvement Peserta Seminar',
						'href' => site_url('seminarpeserta?m=approvepes'),
						'icon' => 'fas fa-calendar',
						'desc' => 'Approve Peserta Seminar yang ingin menonton. Sesuai Bimbingan Anda'
					),
				);
				break;
				 default:
				show_error("Access Denied. You Do Not Have The Permission To Access This Page On This
            Server", 403, "Forbidden, you don't have pemission");
        }
        //get variable
		//sub menu, with crud
		$get = $this->input->get();
		if (isset($get['m'])) {
			switch ($get['m']) {
				case 'seminarjadwalpes':
						if (isset($get['q']) && $get['q'] == 'i') {
						return $this->gabung();
					}
					return $this->index_jadwalpeserta();
					break;
				case 'approvepes':
					if (isset($_GET['a']) and $_GET['a'] == 'accept') {
						return $this->acc_approvepes();
					}
					if (isset($_GET['a']) and $_GET['a'] == 'decline') {
						return $this->dec_approvepes();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->updatejamaahacc();
					}
					return $this->index_approvepes();
					break;
                default:
					redirect(site_url('peserta'));
            }
        }
        $this->load->view('user/peserta_menu', $data);
	}

	//lihatjadwalpeserta
	public function index_jadwalpeserta() {
		$date=date('Y-m-d');
		$time=date('H:i');
		$seminar=$this->seminar_model;
		$nimpes = $this->session->userdata('id');
		$data['sempes'] = $seminar->get_jadwal_sempes($date);

		$datetime = new DateTime($date);
		$datetime->modify('+1 day');
		$tomorrow = $datetime->format('Y-m-d');
		$data['besok'] = $seminar->get_jadwal_sempes($tomorrow);
       $this->load->view('user/seminar_peserta', $data);
	}
	
	//gabung seminar
	public function gabung()
	{
		$post = $this->input->post();
		if (isset($post['gabung'])) {
			$gabung = $this->seminar_model;
			if ($gabung->gabung_seminar()) {
				$this->session->set_flashdata('status', array(
					'message' => 'Berhasil. Tunggu Dospem Penyaji Approve!',
					'type' => 'success'
				));
			} else {
				$this->session->set_flashdata('status', array(
					'message' => 'Maaf, Tidak Bisa Lihat Seminar',
					'type' => 'fail'
				));
			}
			redirect(site_url('seminarpeserta?m=seminarjadwalpes'));
		}
		// // $post = $this->input->post();
		// $seminar = $this->seminar_model;
		// $validation = $this->form_validation;
		// $validation->set_rules($seminar->rules());

		// if ($validation->run()) {
		// 	$seminar->gabung_seminar();
		// }
		// $this->load->view('user/seminar_peserta');
	}

	public function index_approvepes()
	{
		// $konsultasi = $this->konsultasi_model;
		$seminar=$this->seminar_model;
		$nip_nik = $this->session->userdata('nip_nik');
		$data['mahasiswas'] = array();
		if (isset($nip_nik)) {
			$data['peserta_app'] = $seminar->get_all_with_pes($nip_nik);
		}
		return $this->load->view('user/peserta_approve', $data);
	}

	function acc_approvepes()
	{
		$seminar = $this->seminar_model;
		if ($seminar->accept()) {
			$this->session->set_flashdata('status', (object)array('status' => 'Success', 'message' => 'Peserta berhasil dikonfirmasi', 'alert' => 'success'));
		} else {
			$this->session->set_flashdata('status', (object)array('status' => 'Error', 'message' => 'Peserta gagal dikonfirmasi', 'alert' => 'danger'));
		}
		redirect(site_url('seminarpeserta?m=approvepes'));

	}

	function dec_approvepes()
	{
		$seminar = $this->seminar_model;
		if ($seminar->decline()) {
			$this->session->set_flashdata('status', (object)array('status' => 'Success', 'message' => 'Peserta berhasil dikonfirmasi', 'alert' => 'success'));
		} else {
			$this->session->set_flashdata('status', (object)array('status' => 'Error', 'message' => 'Peserta gagal dikonfirmasi', 'alert' => 'danger'));
		}
		redirect(site_url('seminarpeserta?m=approvepes'));

	}

	public function updatejamaahacc()
	{
		foreach ($_POST['id_lihat'] as $id) {
			$gundul = $this->seminar_model;
			$gundul->accberjamaah($id);
		}
		return redirect(site_url('seminarpeserta?m=approvepes'));
	}

}