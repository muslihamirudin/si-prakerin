<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sidang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('perusahaan_model', 'pengajuan_model', 'seminar_model', 'penilaian_model'));
		$this->load->helper(array('notification', 'master', 'upload','tanggal_indo'));
		!$this->session->userdata('level') ? redirect(site_url('main')) : null;
		$id = $this->session->userdata('id');
		$mahasiswa = masterdata('tb_mahasiswa', array('nim' => $id), array('alamat_mhs', 'email_mhs', 'jenis_kelamin_mhs'), false);
		if ($mahasiswa) {
			($mahasiswa->alamat_mhs == null || $mahasiswa->email_mhs == null || $mahasiswa->jenis_kelamin_mhs == null) ? redirect(site_url('user/profile')) : null;
		}
		//Do your magic here
	}

	public function index()
	{
		
		$level = $this->session->userdata('level');
		switch ($level) {
			case 'mahasiswa':
				$data['menus'] = array(
					array('name' => 'Pendaftaran Seminar',
						'href' => site_url('sidang?m=pendaftaran'),
						'icon' => 'fas fa-id-badge',
						'desc' => 'Proses pendaftaran sidang dan penguploadan berkas yang diperlukan'),
					array('name' => 'Jadwal Seminar',
						'href' => site_url('sidang?m=jadwal'),
						'icon' => 'fas fa-id-badge',
						'desc' => 'Informasi terkait jadwal seminar peserta prakerin'),
					array('name' => 'Penilaian Seminar',
						'href' => site_url('sidang?m=penilaian'),
						'icon' => 'fas fa-building',
						'desc' => 'Penilaian peserta seminar prakerin'),
				);
				
				break;
			case 'dosen':
				$data['menus'] = array(
					array('name' => 'Jadwal Seminar',
						'href' => site_url('sidang?m=jadwal'),
						'icon' => 'fas fa-id-badge',
						'desc' => 'Informasi terkait jadwal seminar peserta Praktik Kerja Industri'),
					array('name' => 'Penilaian Seminar',
						'href' => site_url('sidang?m=penilaian'),
						'icon' => 'fas fa-id-badge',
						'desc' => 'Penilaian peserta seminar Praktik Kerja Industri')
				);
				break;
			default:
				$data['menus'] = array();
		}
		if (isset($_GET['m'])) {
			switch ($_GET['m']) {
				case 'jadwal':
					if (isset($_GET['a']) and $_GET['a'] == 'accept') {
//						return $this->acc_bimbingan_mhs();
					}
					if (isset($_GET['a']) and $_GET['a'] == 'decline') {
//						return $this->dec_bimbingan_mhs();
					}
					return $this->index_jadwal_seminar();
					break;
				case 'penilaian':
					if (isset($_GET['q']) and $_GET['q'] == 'i') {
						return $this->insert_penilaian();
					}
					if (isset($_GET['q']) and $_GET['q'] == 'u') {
						return $this->update_penilaian();
					}
					if (isset($_GET['q']) and $_GET['q'] == 'fetch_company_val') {
						return $this->fetch_penilaian_perusahaan();
					}
					if (isset($_GET['q']) and $_GET['q'] == 'get_temp_nilai') {
						return $this->get_temp_nilai();
					}
					return $this->index_penilaian_seminar();
					break;
				case 'pendaftaran':
					return $this->index_pendaftaran_seminar();
					break;
				case 'upload_pendaftaran':
					return $this->upload_pendaftaran();
					break;
				default:
					null;
			}
		}
		$data['intro'] = array(array('step_intro' => 1, 'message_intro' => 'Selamat datang di bimbingan, klik tanggal anda ingin mengajukan konsultasi'));
		return $this->load->view('user/sidang', $data);
	}

	public function get_temp_nilai()
	{
		$penilaian = $this->penilaian_model;
		$nilai_sementara = $penilaian->get_penilaian_seminar_sementara();
		echo json_encode($nilai_sementara);
	}

	public function fetch_penilaian_perusahaan()
	{
		$penilaian = $this->penilaian_model;
		$post = $this->input->post();
		$jadwal = masterdata('tb_seminar_jadwal', "id = '$post[id_jadwal]'", 'id_dosen_bimbingan_mhs', true);
		$id = 0;
		if (count($jadwal) > 0) {
			$id = $jadwal[0]->id_dosen_bimbingan_mhs;
		}
		$nilai_perusahaan = $penilaian->get_penilaian_perusahaan(array('id_dosen_bimbingan_mhs' => $id));
		if (count($nilai_perusahaan) > 0) {
			$decode_detail_nilai = json_decode($nilai_perusahaan[0]->detail_nilai_pkl);
			$nilai_perusahaan[0]->detail_nilai_pkl = $decode_detail_nilai;
		}
		echo json_encode($nilai_perusahaan);
	}

	public function index_pendaftaran_seminar()
	{
		$id = $this->session->userdata('id');
		$data = array();
		$seminar = $this->seminar_model;
		$data_seminar = $seminar->get_self_mahasiswa_seminar();
		$data_pendaftaran = $seminar->get_status_pendaftaran();
		$data['pendaftaran'] = $data_pendaftaran;
		$data['allow'] = false;
		$data['ontime'] = false;
		if (count($data_seminar) > 0) {
			if ($data_seminar[0]->status_seminar == 'setuju') {
				$data['allow'] = true;
				$data['data_seminar'] = $data_seminar;
			}
			//check diff date
			$now = new DateTime('now');
			$schedule_date = $data_seminar[0]->tanggal_seminar;
			$schedule_expolode = explode('T', $schedule_date);
			$schedule_only_date = $schedule_expolode[0];
			$scheduled = new DateTime($schedule_only_date);
			$interval = $scheduled->diff($now);
			if ($interval->d >= 1) {
				$data['ontime'] = true;
			}

		}
		$data['jadwalku'] = $this->seminar_model->tampil_tgl($id);
		$this->load->view('user/sidang_pendaftaran', $data);
	}

	public function upload_pendaftaran()
	{
		$response = do_upload_pendaftaran_seminar();
		$seminar = $this->seminar_model;
		if (isset($response['upload_data'])) {
			if ($seminar->save_pendaftaran($response['upload_data'])) {
				$response['status'] = 'success';
			}
		}
		echo json_encode($response);
	}

	public function insert_penilaian()
	{
		$seminar = $this->seminar_model;
		if ($seminar->insert_penilaian()) {
			echo json_encode(array('status' => 'success'));
			return;
		} else {
			echo json_encode(array('status' => 'error'));
			return;
		}
	}

	public function update_penilaian()
	{
		$seminar = $this->seminar_model;
		if ($seminar->update_penilaian()) {
			echo json_encode(array('status' => 'success'));
			return;
		} else {
			echo json_encode(array('status' => 'error'));
			return;
		}
	}

	public function index_penilaian_seminar()
	{
		$data = array();
		$post = $this->input->post();
		$get = $this->input->get();
		$seminar = $this->seminar_model;
		$level = $this->session->userdata('level');
		$dataModalPembimbing = json_decode('[
			{name:"1. Penguasaan teori",percentage:"20%"},
			{name:"2. Kemampuan analisis dan pemecahan masalah",percentage:"25%"},
			{name:"3. Keaktifan bimbingan",percentage:"15%"},
			{name:"4. Kemampuan penulisan laporan",percentage:"20%"},
			{name:"5. Sikap / Etika",percentage:"20%"}
		]');
		$dataModelPenguji = json_decode('[
			{name:"1. Penyajian Presentasi",percentage:"10%"},
			{name:"2. Pemahaman Materi",percentage:"15%"},
			{name:"3. Hasil yang dicapai",percentage:"40%"},
			{name:"4. Objektifitas menganggapi pertanyaan",percentage:"20%"},
			{name:"5. Penulisan laporan",percentage:"15%"}
		]');
		$data['komponen_pembimbing'] = $dataModalPembimbing;
		$data['komponen_penguji'] = $dataModelPenguji;
		switch ($level) {
			case 'mahasiswa':
				$id = $this->session->userdata('id');
				$penilaian = $this->penilaian_model;
				$data['penilaian'] = $penilaian->get_penilaian_seminar($id);
				break;
			case 'dosen':
				$id = $this->session->userdata('nip_nik');
				$date = date('Y-m-d');
				$time = date('H:i');
				if ((isset($get['section']) and $get['section'] == 'history') || (isset($get['section']) and $get['section'] == 'hasil')) {
					//history revisi
					$riwayat_uji = $seminar->get_jadwal_past($id, $date, $time);
					$pegawai = masterdata('tb_pegawai', "nip_nik = '$id'", 'nama_pegawai', false);
					if (count($riwayat_uji) > 0) {
						foreach ($riwayat_uji as $index => $uji) {
							$riwayat_uji[$index]->sebagai = array_search($pegawai->nama_pegawai, (array)$uji);
							$riwayat_uji[$index]->session = $id;
						}
					}
					$data['riwayat_uji'] = $riwayat_uji;
					if (isset($post['req']) and $post['req'] === 'ajax') {
						echo json_encode($riwayat_uji);
						return;
					}
				} else {
					$pegawai = masterdata('tb_pegawai', "nip_nik = '$id'", 'nama_pegawai', false);
					$jadwaluji = $seminar->get_jadwal_today($id, $date);
					if (count($jadwaluji) > 0) {
						foreach ($jadwaluji as $index => $uji) {
							$jadwaluji[$index]->sebagai = array_search($pegawai->nama_pegawai, (array)$uji);
							$jadwaluji[$index]->session = $id;
						}
					}
					$datetime = new DateTime($date);
					$datetime->modify('+1 day');
					$tomorrow = $datetime->format('Y-m-d');
					$jadwaluji_besok = $seminar->get_jadwal_today($id, $tomorrow);
					if (count($jadwaluji_besok) > 0) {
						foreach ($jadwaluji_besok as $index => $uji) {
							$jadwaluji_besok[$index]->sebagai = array_search($pegawai->nama_pegawai, (array)$uji);
							$jadwaluji_besok[$index]->session = $id;
						}
					}
					$data['jadwaluji'] = $jadwaluji;
					$data['besok'] = $jadwaluji_besok;
					if (isset($post['req']) and $post['req'] === 'ajax') {
						echo json_encode($jadwaluji);
						return;
					}
					//penilaian terlewat
					$riwayat_uji_terlewat = $seminar->get_jadwal_past_left($id, $date, $time);
					if (count($riwayat_uji_terlewat) > 0) {
						foreach ($riwayat_uji_terlewat as $index => $uji) {
							$riwayat_uji_terlewat[$index]->sebagai = array_search($pegawai->nama_pegawai, (array)$uji);
							$riwayat_uji_terlewat[$index]->session = $id;
						}
					}
					//untuk request ajax, tanpa perlu filter nilai seminar == null
					if (isset($post['req']) and $post['req'] === 'ajax_left') {
						echo json_encode($riwayat_uji_terlewat);
						return;
					}
					//data riwayat_terlewat yang sudah di filter nilai_seminarnya == null;
					$data['riwayat_uji_terlewat'] = $riwayat_uji_terlewat;
				}
				break;
			default:
				return 0;
				break;
		}

		$this->load->view('user/sidang_penilaian', $data);
	}

	public function index_jadwal_seminar()
	{
		$data = array();
		$id = $this->session->userdata('id');
		$level = $this->session->userdata('level');
		if ($level === 'mahasiswa') {
			$where = "WHERE tm.nim = '$id'";
		} elseif ($level === 'dosen') {
			$where = "WHERE td1.nip_nik = '$id' OR td2.nip_nik = '$id'";
		}
		$data['tempat'] = $this->seminar_model->get_tempat_seminar($alias = "title");
		$data['jadwalku'] = $this->seminar_model->get_jadwal($where);
		$this->load->view('user/sidang_jadwal', $data);
	}

}

/* End of file Magang.php */
?>
