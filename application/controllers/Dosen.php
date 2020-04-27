<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();  
		$this->load->helper(array('upload', 'master', 'notification'));
		$this->load->model(array('pembimbing_model', 'akun_model', 'pilihperusahaan_model', 'dosen_prodi_model', 'prodi_model'));
		$this->load->library('form_validation');
		//middleware
		!$this->session->userdata('level') ? redirect(site_url('main')) : null;
	}

	public function index()
	{
		$join = array('tahun_akademik', 'tb_waktu.id_tahun_akademik = tahun_akademik.id_tahun_akademik', 'inner');
		$tahunAkademik = datajoin('tb_waktu', null, 'tahun_akademik.tahun_akademik', $join, null);
		$level = $this->session->userdata('level');
		switch ($level) {
			case 'admin':
				$data['menus'] = array(
					array(
						'name' => 'Kelola Dosen Program Studi',
						'href' => site_url('dosen?m=dosen_prodi'),
						'icon' => 'fas fa-users',
						'desc' => 'Pemilihan dosen berdasarkan program studi'
					),
					array(
						'name' => 'Kelola Pembimbing ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('dosen?m=pembimbing'),
						'icon' => 'fas fa-users',
						'desc' => 'Manajemen dosen pembimbing mahasiswa'
					),
				);
				break;
			case 'koordinator prodi':
				$data['menus'] = array(
					array(
						'name' => 'Kelola Pembimbing ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('dosen?m=pembimbing'),
						'icon' => 'fas fa-users',
						'desc' => 'Manajemen dosen pembimbing mahasiswa  ' . $tahunAkademik[0]->tahun_akademik
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
				case 'pembimbing':
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->management_pembimbing();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->remove_pembimbing();
					}
					if (isset($get['q']) && $get['q'] == 'mv_bimbingan') {
						return $this->move_bimbingan();
					}
					if (isset($get['q']) && $get['q'] == 'rm_bimbingan') {
						return $this->remove_bimbingan();
					}
					return $this->index_pembimbing();
					break;
				case 'dosen_prodi':
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->dosen_prodi_management();
					}
					return $this->index_dosen_prodi();
					break;
				default:
					redirect(site_url('dosen'));
			}
		}

		$this->load->view('admin/dosen', $data);
	}

	//kelola dosen prodi
	public function index_dosen_prodi()
	{
		$dosen_prodi = $this->dosen_prodi_model;
		$data['dosens'] = $dosen_prodi->get();
		$this->load->view('admin/dosen_prodi', $data);
	}

	public function dosen_prodi_management()
	{
		$dosen_prodi = $this->dosen_prodi_model;
		if (isset($_POST['nip']) and isset($_POST['prodi'])) {
			if ($dosen_prodi->replace()) {
				echo json_encode(array('status' => 'success'));
				return;
			}
			echo json_encode(array('status' => 'failed'));
			return;
		}
		$this->load->view('admin/dosen_prodi_kelola');
	}


	//pembimbing
	public function index_pembimbing()
	{
		$data['prodi'] = array();
		$data['mahasiswa'] = array();
		$data['dosens'] = array();
		$dosen_prodi = $this->dosen_prodi_model;
		$prodi_model= $this->prodi_model;
		
		$data['prodi'] = $prodi_model->getAll();

		//id harus nip nik, karena mereka pegawai yang login pada tampilan backend
		$nip_nik = $this->session->userdata('id');
//		var_dump($_SESSION);
		$id_prodi = masterdata('tb_dosen', "nip_nik = '$nip_nik'", 'id_program_studi', false);
		$id_prodi = isset($_GET['filpro']) ? $_GET['filpro'] : null;

		if ($id_prodi) {
			$data['dosens'] = $dosen_prodi->get(null, $id_prodi, true);
		} else {
			$data['dosens'] = $dosen_prodi->get(null, null, true);
		}


		//null, still consider how data goes
		$this->load->view('admin/dosen_pembimbing2', $data);
	}

	public function management_pembimbing()
	{
		$pembimbing = $this->pembimbing_model;
		if (isset($_POST['send'])) {
			if ($pembimbing->replace()) {
				echo json_encode(array('status' => 'success'));
				return;
			}
			echo json_encode(array('status' => 'failed'));
		}
	}

	public function remove_pembimbing()
	{
		$pembimbing = $this->pembimbing_model;
		if (isset($_POST['id'])) {
			if ($pembimbing->delete()) {
				echo json_encode(array('status' => 'success'));
				return;
			}
			echo json_encode(array('status' => 'success'));
		}
	}

	public function move_bimbingan()
	{
		$pembimbing = $this->pembimbing_model;
		if ($pembimbing->move_bimbingan()) {
			echo json_encode(array('status' => 'moved'));
		}
	}

	public function remove_bimbingan()
	{
		$pembimbing = $this->pembimbing_model;
		if ($pembimbing->remove_bimbingan()) {
			echo json_encode(array('status' => 'removed'));
		}
	}


} ?>
