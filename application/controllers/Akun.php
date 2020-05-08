<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('akun_model');
		//Do your magic here
	}

	public function index()
	{
		$data['pegawais'] = $this->akun_model->getAllAccounts('pegawai');
		$data['mahasiswas'] = $this->akun_model->getAllAccounts('mahasiswa');
		$data['pesertas'] = $this->akun_model->getAllAccounts('peserta');
		$this->load->view('admin/akun', $data);
	}

	public function tambah()
	{
		$data = array();
		$post = $this->input->post();
		$akun = $this->akun_model;
		if (isset($post['submit'])) {
			if ($akun->tambah_akun()) {
				redirect('akun/add');
			}
		}
		$this->load->view('admin/akun_tambah', $data);
	}

	public function management()
	{
		$get = $this->input->get();
		if (isset($get['edit']) ? $get['edit'] : null) {
			//TODO:doing something here when edit are press in out.

		}
		$this->load->view('admin/akun_management');
	}

	public function edit($id)
	{
		$account = $this->akun_model->get_detail_account($id);
		$data = array();
		if (count((array)$account) > 0) {
			if (strpos($account->username, '@') !== false) {
				$data['akuns'] = $this->akun_model->getAllAccounts('pegawai', $id);
			} else {
				$data['akuns'] = $this->akun_model->getAllAccounts('mahasiswa', $id);
				$data['akuns'] = $this->akun_model->getAllAccounts('peserta', $id);
			}
		}
		$this->load->view('admin/akun_management', $data);
	}

	public function edit_password()
	{
		if (isset($_POST['submit'])) {
			$akun = $this->akun_model;
			$post = $this->input->post();
			if ($akun->edit_password()) {
				$this->session->set_flashdata('status', (object)array('status' => 'success'));
				redirect('akun/edit/' . $post['id']);
			}
		}
	}

	public function edit_level()
	{
		if (isset($_POST['submit'])) {
			$akun = $this->akun_model;
			if ($akun->edit_level()) {
				echo json_encode(array('status' => 'success'));
			} else {
				echo json_encode(array('status' => 'error'));
			}
			return;
		}
	}

	public function hapus_level()
	{
		if (isset($_POST['submit'])) {
			$akun = $this->akun_model;
			if ($akun->hapus_level()) {
				echo json_encode(array('status' => 'success'));
			} else {
				echo json_encode(array('status' => 'error'));
			}
			return;
		}
	}

	public function hapus_akun($id)
	{
		if ($this->akun_model->delete_akun($id)) {
			$this->session->set_flashdata('status', (object)array(
				'status' => 'success',
				'message' => 'Level akun berhasil dihapus'
			));
			redirect(site_url('akun'));
		} else {
			$this->session->set_flashdata('status', (object)array(
				'status' => 'fail',
				'message' => 'Level akun gagal dihapus'
			));
		}
	}

}

/* End of file Controllername.php */
