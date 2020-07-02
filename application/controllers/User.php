<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('mahasiswa_model', 'konsultasi_model', 'pembimbing_model', 'penilaian_model', 'seminar_model', 'peserta_model'));
		$this->load->model('pegawai_model');
		$this->load->library('form_validation');
		$this->load->helper('notification','tanggal_indo');
		!$this->session->userdata('level') ? redirect(site_url('main')) : null;
	}

	//dashboard user
	public function index()
	{
		$id = $this->session->userdata('id');
		$level = $this->session->userdata('level');
		
		switch ($level) {
			case 'mahasiswa' :
				$data=array();
				
				$data['menus'] = array(
					array('name' => 'SIG Perusahaan',
						'href' => 'https://simpkl.politala.ac.id/sig/home',
						'icon' => 'ni ni-square-pin',
						'step_intro' => '2',
						'message_intro' => 'SIG Perusahaan merupakan aplikasi geografis perusahaan, meliputi letak geografis, dan data penting terkait perusahaan magang anda',
						'desc' => 'Sistem Informasi Pemetaan Mahasiswa yang melaksanakan Praktik Kerja Industri Politeknik Negeri Tanah Laut'),
				);
				
				

				$data['mahasiswa'] = $this->mahasiswa_model->getById();
				$data['latest_bimbingan'] = $this->konsultasi_model->show_latest_bimbingan();
				$data['get_pembimbing'] = $this->pembimbing_model->is_has();
				if (count($data['get_pembimbing']) > 0) {
					$id_dosen_bimbingan_mhs = $data['get_pembimbing'][0]->id_dosen_bimbingan_mhs;
					$penilaian_perusahaan = $this->penilaian_model->get_penilaian_perusahaan(array("id_dosen_bimbingan_mhs"=>$id_dosen_bimbingan_mhs));
					count($penilaian_perusahaan);
					if (count($penilaian_perusahaan) == 0) {
						$data['informasi'] = (object)array('pesan' => 'Anda belum mengisi penilaian perusahaan, segera lakukan pengisian. Penguji tidak akan memberikan anda penilaian jika penilaian dari perusahaan kosong', 'uri' => site_url('magang?m=penilaian'));
					}
				}
				$data['intro'] = array(array('step_intro' => '5', 'message_intro' => 'Pastikan melihat informasi terlebih dahulu'), array('step_intro' => '6', 'message_intro' => 'Klik foto profil, dan pergi ke My Profile, dan ubah profil anda ketika pertama kali login. Hal ini bertujuan agar kalian bisa melakukan proses pengajuan magang'));
				$data['intro_dashboard'] = true;

				$data['jadwalku'] = $this->seminar_model->tampil_tgl($id);


				break;
			case 'dosen':
				$data['menus'] = array(
					array('name' => 'Monev Prakerin',
						'href' => 'https://simpkl.politala.ac.id/monev/login',
						'icon' => 'ni ni-square-pin',
						'step_intro' => '3',
						'message_intro' => 'Menu .',
						'desc' => 'Aplikasi monitoring tempat Praktik kerja lapangan')
				);
				$data['dosen'] = $this->pegawai_model->getById();
				$data['all_latest_bimbingan'] = $this->konsultasi_model->show_all_latest_bimbingan();
				break;
			case 'peserta':
				$data['menus'] = array(
					array('name' => 'SIG Perusahaan',
						'href' => 'https://simpkl.politala.ac.id/sig/home',
						'icon' => 'ni ni-square-pin',
						'step_intro' => '2',
						'message_intro' => 'SIG Perusahaan merupakan aplikasi geografis perusahaan, meliputi letak geografis, dan data penting terkait perusahaan magang anda',
						'desc' => 'Sistem Informasi Pemetaan Mahasiswa yang melaksanakan Praktik Kerja Industri Politeknik Negeri Tanah Laut'),
				);

				$data['lihat'] = $this->seminar_model->count_lihatsem($id);
				break;
			default:
				$data['menus'] = array();
				redirect(site_url('main'));//@TODO:change this, clean code
		}
		$this->load->view('user/dashboard', $data);
	}

	public function profile()
	{
		$level = $this->session->userdata('level');
		$id = $this->session->userdata('id');
		switch ($level) {
			case 'mahasiswa':
				$data['profile'] = $this->mahasiswa_model->getById($id);
				break;
			case 'dosen':
				$data['profile'] = $this->pegawai_model->getById($id);
				break;
			case 'peserta':
				$data['profile'] = $this->peserta_model->getById($id);
				break;
			default:
				$data['profile'] = null;
		}
		$this->load->view('user/profile', $data);
	}

	public function editprofile()
	{
		$level = $this->session->userdata('level');
		$id = $this->session->userdata('id');
		switch ($level) {
			case 'mahasiswa':
				if (!isset($id)) redirect('prodi');
				$mahasiswa = $this->mahasiswa_model;
				$validation = $this->form_validation;
				$validation->set_rules($mahasiswa->rules());
				if ($validation->run()) {
					$mahasiswa->update();
					update_notification('read', 'profil', $id);
					$this->session->set_flashdata('status', 'Berhasil dirubah');

				} else {
					$this->session->set_flashdata('status', 'Gagal Mengubah');
				}
				break;
			case 'dosen':
				$data['profile'] = $this->pegawai_model->getById($id);
				break;
			case 'peserta':
				if (!isset($id)) redirect('prodi');
				$peserta = $this->$peserta_model;
				$validation = $this->form_validation;
				$validation->set_rules($peserta->rules());
				if ($validation->run()) {
					$peserta->update();
					update_notification('read', 'profil', $id);
					$this->session->set_flashdata('status', 'Berhasil dirubah');

				} else {
					$this->session->set_flashdata('status', 'Gagal Mengubah');
				}
				break;
			default:
				$data['profile'] = null;
		}
		redirect(site_url('user/profile'));
	}

	public function logout()
	{
		session_destroy();
		redirect(site_url('blog/home'));
	}

	public function login()
	{

	}

	public function create()
	{
		$changeHere = $this->changeHere;
		$validation = $this->form_validation;
		$validation->set_rules($changeHere->rules());
		if ($validation->run()) {
			$changeHere->insert();
			$this->session->set_flashdata('success', 'Berhasil disimpan');
		}
		$this->load->view('changeHere');
	}

	public function edit($id = null)
	{
		if (!isset($id)) redirect('changeHere');
		$changeHere = $this->changeHere;
		$validation = $this->form_validation;
		$validation->set_rules($changeHere->rules());

		if ($validation->run()) {
			$changeHere->update();
			$this->session->set_flashdata('success', 'Berhasil disimpan');
		}
		$data['changeHere'] = $changeHere->getById($id);
		if (!$data['changeHere']) show_404();
		$this->load->view('changeHere', $data);
	}

	public function remove($id = null)
	{
		if (!isset($id)) show_404();
		if ($this->changeHere->delete($id)) {
			redirect(site_url('changeHere'));
		}
	}

	public function kuesioner()
	{
		$get = $this->input->get();
		if (isset($get['m'])) {
			$this->load->view('user/kuesioner');
		}
	}
} ?>
