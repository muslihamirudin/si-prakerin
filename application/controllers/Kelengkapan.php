<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kelengkapan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('kelengkapan_model', 'penilaian_model','seminar_model'));
		$this->load->helper('upload');
		!$this->session->userdata('level') ? redirect(site_url('main')) : null;
	}

	public function index()
	{
		$data = array();
		$data['allow'] = false;
		$level = $this->session->userdata('level');
		if (isset($_GET['m'])) {
			switch ($_GET['m']) {
				case 'upload':
					return $this->upload_berkas();
					break;
				default:
					redirect(site_url('kelengkapan'));
			}
		}
		$id = $this->session->userdata('id');
		$data['jadwalku'] = $this->seminar_model->tampil_tgl($id);
		$nim = $this->session->userdata('id');
		$dsn_bimbingan = masterdata('tb_dosen_bimbingan_mhs', "nim = '$nim'", 'id_dosen_bimbingan_mhs id');
		if (isset($dsn_bimbingan->id)) {
			$file = masterdata('tb_kelengkapan_berkas', "id_dosen_bimbingan_mhs = '$dsn_bimbingan->id'", 'nama_file,status', true);
			$join = array(
				array('tb_history_seminar_penilaian thsp', 'thsp.id_seminar_penilaian = tsp.id', 'LEFT OUTER'),
				array('tb_seminar_jadwal tsj', 'tsj.id = tsp.id_seminar_jadwal', 'INNER')
			);
			$revisi = datajoin('tb_seminar_penilaian tsp', "id_dosen_bimbingan_mhs = '$dsn_bimbingan->id'", 'thsp.id', $join);
			if (count($revisi) > 0) {
				$belum_revisi = array();
				foreach ($revisi as $rev) {
					if ($rev->id != "" || $rev->id != null) {
						array_push($belum_revisi, 0);
					} else {
						array_push($belum_revisi, 1);
					}
				}
				//verifikasi, apakah sudah revisi atau belum, jika $belum revisi msh terdapat 1, maka belum bisa.
				if (in_array(1, $belum_revisi)) {
					$data['allow'] = false;
				} else {
					$data['allow'] = true;
				}
				$data['file'] = $file;
				if (count($file) > 0) {
					if ($file[0]->nama_file != "") {
						$data['allow'] = false;
						$data['status'] = (object)array("message" => "<b>Menunggu</b> Mohon untuk menunggu koordinator memverifikasi","color" => "alert-dark");
						if ($file[0]->status == 'reupload') {
							$data['allow'] = true;
							$data['status'] = (object)array("message" => "<b>Gagal</b> Berkas tidak disetujui, silahkan upload ulang","color" => "alert-danger");
						}
						if ($file[0]->status == 'approve') {
							$data['allow'] = false;
							$data['status'] = (object)array("message" => "<b>Sukses</b> Pemberkasan berhasil disetujui koordinator, ada berhak untuk melanjutkan Tugas Akhir (TA)","color" => "alert-success");
						}
					}
				}
			}
		}
		
		$this->load->view('user/kelengkapan_berkas', $data);
	}

	public function upload_berkas()
	{
		$res = do_upload_berkas();
		$nim = $this->session->userdata('id');
		$file_name = isset($res['upload_data']['file_name']) ? $res['upload_data']['file_name'] : null;
		$dsn_bimbingan = masterdata('tb_dosen_bimbingan_mhs', "nim = '$nim'", 'id_dosen_bimbingan_mhs id');
		$is_exits = masterdata('tb_kelengkapan_berkas', "id_dosen_bimbingan_mhs = '$dsn_bimbingan->id'", 'id');
		$id = isset($is_exits->id) ? $is_exits->id : 0;
		$now = date('Y-m-d');
		if ($this->db->query("REPLACE INTO tb_kelengkapan_berkas VALUES('$id','$dsn_bimbingan->id','$file_name','$now','pending')")) {
			echo $this->db->insert_id();
		} else {
			show_error('failed upload', 500);
		}


	}
}
