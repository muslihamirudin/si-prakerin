<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('peserta_model');
		$this->load->helper('master');
		$this->load->library('form_validation');
		! $this->session->userdata( 'level' ) ? redirect( site_url( 'main' ) ) : null;
	}

	public function index()
	{
        $join = array('tahun_akademik', 'tb_waktu.id_tahun_akademik = tahun_akademik.id_tahun_akademik', 'inner');
		$tahunAkademik = datajoin('tb_waktu', null, 'tahun_akademik.tahun_akademik', $join);
		$level = $this->session->userdata('level');
		switch ($level) {
			case 'admin':
				$data['menus'] = array(
					array(
						'name' => 'Kelola Peserta Seminar',
						'href' => site_url('peserta?m=pesertaseminar'),
						'icon' => 'fas fa-users',
						'desc' => 'Mahasiswa yang berhak menyaksikan Seminar'
                    )  
				);
                break;
            case 'dosen':
				$data['menus'] = array(
					array(
						'name' => 'Verifikasi Peserta Seminar ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('peserta?m=versem'),
						'icon' => 'fas fa-get-pocket',
						'desc' => 'Manajemen dosen Peserta Seminar ' . $tahunAkademik[0]->tahun_akademik
					)
				);
				break;
			//if there are not level except in case, it will throw to error with code 403
			default:
				show_error("Access Denied. You Do Not Have The Permission To Access This Page On This
            Server", 403, "Forbidden, you don't have pemission");
        }
        //get variable
		//sub menu, with crud
		$get = $this->input->get();
		if (isset($get['m'])) {
			switch ($get['m']) {
				case 'pesertaseminar':
					if (isset($get['q']) && $get['q'] == 'i') {
						return $this->create_peserta();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->edit_peserta();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->remove_peserta();
					}
					return $this->index_peserta();
                    break;
                case 'versem':
					return $this->index_versem();
                    break;
                default:
					redirect(site_url('peserta'));
            }
        }
        $this->load->view('admin/peserta', $data);
	}
	
	public function index_peserta()
	{
		$data['pesertas'] = $this->peserta_model->getAll();//need filter only magang
		$this->load->view('admin/peserta_seminar', $data);
	}

	///create Peserta
	public function create()
	{
		$peserta = $this->peserta_model;
		$validation = $this->form_validation;
		$validation->set_rules($peserta->rules());
		if ($validation->run()) {
			if ($peserta->insert()) {
				$this->session->set_flashdata('notif', (object)[
					'message' => 'Data berhasil disimpan',
					'type' => 'success'
				]);
			} else {
				$this->session->set_flashdata('notif', (object)[
					'message' => 'Data gagal disimpan',
					'type' => 'fail'
				]);
			}
			redirect('peserta?m=pesertaseminar');
		}
		$this->load->view('admin/peserta_seminar_tambah');
	}

	public function edit($id = null)
	{
		if (!isset($id)) {
			redirect('peserta?m=pesertaseminar');
		}
		$peserta = $this->peserta_model;
		$validation = $this->form_validation;
		$validation->set_rules($peserta->rules());
		if ($validation->run()) {
			if ($peserta->update()) {
				$this->session->set_flashdata('notif', (object)[
					'message' => 'Data berhasil disimpan',
					'type' => 'success'
				]);
			} else {
				$this->session->set_flashdata('notif', (object)[
					'message' => 'Data gagal disimpan',
					'type' => 'fail'
				]);
			}
			redirect('peserta?m=pesertaseminar');

		}
		$data['peserta'] = $peserta->getById($id);
		if (!$data['peserta']) {
			show_404();
		}
		$this->load->view('admin/peserta_seminar_edit', $data);
	}

	public function remove($id = null)
	{
		if (!isset($id)) {
			show_404();
		}
		if ($this->mahasiswa_model->delete($id)) {
			$this->session->set_flashdata('notif', (object)[
				'message' => 'Data berhasil dihapus',
				'type' => 'success'
			]);
			redirect(site_url('mahasiswa?m=magang'));
		} else {
			$this->session->set_flashdata('notif', (object)['message' => 'Data gagal dihapus', 'type' => 'fail']);
		}
	}
}

