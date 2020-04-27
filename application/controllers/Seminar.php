<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Seminar extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('upload', 'master', 'notification'));
		$this->load->model(array('pembimbing_model', 'akun_model', 'penilaian_model', 'seminar_model', 'pilihperusahaan_model', 'dosen_prodi_model', 'seminar_model', 'kelengkapan_model'));
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
						'name' => 'Kelola Jadwal Seminar Prakerin',
						'href' => site_url('seminar?m=kelola'),
						'icon' => 'fas fa-calendar-alt',
						'desc' => 'Pengolahan data jadwal untuk seminar meliputi penguji, tempat dan waktu'
					),
					array(
						'name' => 'Verifikasi Pendaftaran',
						'href' => site_url('seminar?m=pendaftaran'),
						'icon' => 'fas fa-calendar',
						'desc' => 'Verfikasi pendaftaran mahasiswa seminar 2 hari sebelum seminar dimulai'),
					array(
						'name' => 'Data Jadwal Seminar ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('seminar?m=data_jadwal'),
						'icon' => 'fas fa-file-excel',
						'desc' => 'Data jadwal terkini mahasiswa seminar  ' . $tahunAkademik[0]->tahun_akademik
					),
					array(
						'name' => 'Data Penilaian Seminar ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('seminar?m=data_penilaian'),
						'icon' => 'fas fa-file-excel',
						'desc' => 'Data penilaian seminar terkini  ' . $tahunAkademik[0]->tahun_akademik
					),
					array(
						'name' => 'Proses Revisi ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('seminar?m=revisi'),
						'icon' => 'fas fa-file-excel',
						'desc' => 'Daftar mahasiswa revisi ' . $tahunAkademik[0]->tahun_akademik
					),
					array(
						'name' => 'Proses Pemberkasan ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('seminar?m=pemberkasan'),
						'icon' => 'fas fa-file-excel',
						'desc' => 'Daftar pemberkasan terkini  ' . $tahunAkademik[0]->tahun_akademik
					),
					array(
						'name' => 'Rekap Prakerin ' . $tahunAkademik[0]->tahun_akademik,
						'href' => site_url('seminar?m=rekap_akhir'),
						'icon' => 'fas fa-file-excel',
						'desc' => 'Data penilaian seminar terkini  ' . $tahunAkademik[0]->tahun_akademik
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
			case 'mahasiswa':
				$post = $this->input->post();
				if (!isset($post['id'])) {
					show_error("Access Denied. You Do Not Have The Permission To Access This Page On This
            Server", 403, "Forbidden, you don't have pemission");
				}
				break;
			case 'dosen':
				$post = $this->input->post();
				if (!isset($post['id'])) {
					show_error("Access Denied. You Do Not Have The Permission To Access This Page On This
            Server", 403, "Forbidden, you don't have pemission");
				}
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
				case 'pendaftaran':
					if (isset($get['q']) && $get['q'] == 'acc') {
						return $this->acc_verifikasi_pendaftaran();
					}
					if (isset($get['q']) && $get['q'] == 'dec') {
						return $this->dec_verifikasi_pendaftaran();
					}
					if (isset($get['q']) && $get['q'] == 'preview') {
						return $this->get_preview_modal_verif();
					}
					return $this->index_verifikasi_pendaftaran();
					break;
				case 'kelola':
					if (isset($get['q']) && $get['q'] == 'u') {

					}
					if (isset($get['q']) && $get['q'] == 'd') {

					}
					return $this->index_kelola_jadwal();
					break;
				case 'tempat':
					if (isset($get['q']) && $get['q'] == 'i') {
						return $this->add_tempat();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->update_tempat();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->delete_tempat();
					}
					return $this->get_tempat();
					break;
				case 'waktu':
					if (isset($get['q']) && $get['q'] == 'i') {
						return $this->add_waktu();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->update_waktu();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->delete_waktu();
					}
					return $this->get_waktu();
					break;
				case 'tanggal':
					if (isset($get['q']) && $get['q'] == 'i') {
						return $this->add_tanggal();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->update_tanggal();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->delete_tanggal();
					}
					return $this->get_tanggal();
					break;
				case 'penguji':
					if (isset($get['q']) && $get['q'] == 'i') {
						return $this->add_penguji();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->delete_penguji();
					}
					if (isset($get['q']) && $get['q'] == 'i_bulk') {
						return $this->add_bulk_penguji();
					}
					if (isset($get['q']) && $get['q'] == 'd_bulk') {
						return $this->delete_bulk_penguji();
					}
					return $this->get_penguji();
					break;
				case 'mahasiswa':
					return $this->get_all_mhs_seminar();
					break;
				case 'jadwal':
					if (isset($get['q']) && $get['q'] == 'i') {
						return $this->add_jadwal();
					}
					if (isset($get['q']) && $get['q'] == 'd') {
						return $this->delete_jadwal();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->update_jadwal();
					}
					return $this->get_jadwal();
					break;
				case 'data_jadwal':
					return $this->get_list_jadwal();
					break;
				case 'data_penilaian':
					if (isset($get['q']) && $get['q'] == 'filter_belum_menilai') {
						return $this->filter_belum_dinilai();
					}
					return $this->get_list_penilaian();
					break;
				case 'revisi':
					return $this->index_proses_revisi();
					break;
				case 'pemberkasan':
					if (isset($get['q']) && $get['q'] == 'preview') {
						return $this->get_modal_preview();
					}
					if (isset($get['q']) && $get['q'] == 'u') {
						return $this->update_pemberkasan();
					}
					return $this->index_proses_pemberkasan();
					break;
				case 'rekap_akhir':
					return $this->index_rekap_akhir();
					break;
				default:
					redirect(site_url('seminar'));
			}
		}

		$this->load->view('admin/seminar', $data);
	}

	public function index_proses_revisi()
	{
		$data = array();
		$penilaian = $this->penilaian_model;
		if (isset($_POST['ajax'])) {
			echo json_encode(array('data' => $penilaian->get_status_revisi()));
			return;
		}
		$this->load->view('admin/rekap_revisi', $data);
	}

	public function index_proses_pemberkasan()
	{
		$data = array();
		$pemberkasan = $this->kelengkapan_model;
		if (isset($_POST['ajax'])) {
			$pemberkasans = $pemberkasan->get_all_pemberkasan();
			echo json_encode(array('data' => $pemberkasans));
			return;
		}
		$this->load->view('admin/rekap_pemberkasan', $data);
	}

	public function update_pemberkasan()
	{
		$post = $this->input->post();
		$pemberkasan = $this->kelengkapan_model;
		if (isset($post['update']) && $post['update'] == 'acc') {
			$status = 'approve';
			$file = $post['file'];
		}
		if (isset($post['update']) && $post['update'] == 'dec') {
			$status = 'reupload';
			$file = $post['file'];
		}
		$pemberkasan->update_kelengkapan($status, $file);
		redirect(site_url('seminar?m=pemberkasan'));
	}

	//modal preview pemberkasan
	public function get_modal_preview()
	{
		$site_update = site_url('seminar?m=pemberkasan&q=u');
		$base_uri = base_url('/ViewerJS/#../file_upload/berkas/');
		$data_pemberkasan = masterdata('tb_kelengkapan_berkas', "nama_file ='$_POST[file]'", 'status');
		$disabled = ($data_pemberkasan->status == "approve" || $data_pemberkasan->status == "reupload") ? "disabled" : "";
		if (isset($_POST['file'])) {
			echo '<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="deleteModalLabel">Kelengkapan Berkas Mahasiswa</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<iframe id="preview-berkas" class="col-md-12 px-0" style="border-radius: 6px"
										height="500px"
										src="' . $base_uri . $_POST["file"] . '"
										frameborder="0"></iframe>
							</div>
							<div class="modal-footer">
								<form action="' . $site_update . '" method="POST">
									<input type="hidden" name="file" value="' . $_POST["file"] . '"/>
									<button id="btn-ulang" type="submit" '.$disabled.' name="update" value="dec" class="btn btn-sm btn-warning text-white ' . $disabled . '">
										Upload ulang
									</button>
									<button id="btn-terima" type="submit" '.$disabled.' name="update" value="acc" class="btn btn-sm btn-success text-white ' . $disabled . '">Terima</button>
								</form>
							</div>
						</div>
					</div>
				</div>';
		}
	}

	// modal verifikasi pendaftaran
	public function get_preview_modal_verif()
	{
		$post = $this->input->post();
		$status = $post['status'] != 'NULL' ? (($post['status'] == 'accept') || ($post['status'] == 'reupload') ? 'disabled' : '') : "";
		echo '
		<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header pb-0">
								<h5 class="modal-title" id="deleteModalLabel">Berkas Pendaftaran Mahasiswa</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="d-flex justify-content-end mb-3">
									<a href="' . site_url('seminar?m=pendaftaran&q=dec&id=' . $post['verif']) . '"
									   class="btn btn-sm btn-danger ' . $status . '">Upload
										Ulang</a>
									<a href="' . site_url('seminar?m=pendaftaran&q=acc&id=' . $post['verif']) . '"
									   class="btn btn-sm btn-primary mr-1 ' . $status . '">Terima</a>
								</div>
								<iframe class="col-md-12 px-0"
										style="border-radius: 6px"
										height="500px"
										src="' . base_url('/ViewerJS/#../file_upload/pendaftaran_seminar/' . $post['file']) . '"
										frameborder="0">
								</iframe>
							</div>
						</div>
					</div>
				</div>';
	}

	public function index_rekap_akhir()
	{
		$data = array();
		$this->load->view('admin/rekap_akhir', $data);
	}

	public function filter_belum_dinilai()
	{
		$data = array();
		$post = $this->input->post();
		$penilaian = $this->penilaian_model;
		$data['belum_dinilai'] = $penilaian->get_belum_penilaian_seminar();
		$this->load->view('admin/seminar_list_belum_dinilai', $data);
	}

	public function acc_verifikasi_pendaftaran()
	{
		$get = $this->input->get();
		if (isset($get['id'])) {
			$seminar = $this->seminar_model;
			if ($seminar->acc_verifikasi_pendaftaran($get['id'])) {
				$this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil'));
			} else {
				$this->session->set_flashdata(array('status' => 'error', 'message' => 'Gagal'));
			}
		}
		redirect('seminar?m=pendaftaran');
	}

	public function dec_verifikasi_pendaftaran()
	{
		$get = $this->input->get();
		if (isset($get['id'])) {
			$seminar = $this->seminar_model;
			if ($seminar->dec_verifikasi_pendaftaran($get['id'])) {
				$this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil'));
			} else {
				$this->session->set_flashdata(array('status' => 'error', 'message' => 'Gagal'));
			}
		}
		redirect(site_url('seminar?m=pendaftaran'));
	}

	public function index_verifikasi_pendaftaran()
	{
		$data = array();
		$seminar = $this->seminar_model;
		$tanggal_seminar = $seminar->get_all_seminar_date();
		$data['tanggal_seminar'] = $tanggal_seminar;
		$this->load->view('admin/seminar_verifikasi_pendaftaran', $data);
	}

	public function get_list_penilaian()
	{
		$post = $this->input->post();
		$penilaian = $this->penilaian_model;
		$data = array();
		$data_penilaian = $penilaian->get_all_penilaian_seminar();
		$data['list_penilaian'] = $data_penilaian;
		if (isset($post['ajax'])) {
			echo json_encode((object)array('data' => $data_penilaian));
			return;
		}
		$this->load->view('admin/seminar_list_penilaian', $data);
	}

	public function get_list_jadwal()
	{
		$post = $this->input->post();
		$seminar = $this->seminar_model;
		$data_jadwal = $seminar->get_jadwal();
		if (isset($post['ajax'])) {
			echo json_encode((object)array('data' => $data_jadwal));
			return;
		}
		$this->load->view('admin/seminar_list_jadwal');
	}

	public function get_jadwal()
	{
		$seminar = $this->seminar_model;
		echo json_encode($seminar->get_jadwal());
	}

	public function add_jadwal()
	{
		$seminar = $this->seminar_model;
		if ($seminar->add_jadwal()) {
			echo json_encode(array('status' => 'success'));
			return;
		}
		echo json_encode(array('status' => 'error'));
	}

	public function update_jadwal()
	{
		$seminar = $this->seminar_model;
		if ($seminar->update_jadwal()) {
			echo json_encode(array('status' => 'success'));
			return;
		}
		echo json_encode(array('status' => 'error'));
	}

	public function delete_jadwal()
	{
		$seminar = $this->seminar_model;
		if ($seminar->delete_jadwal()) {
			echo json_encode(array('status' => 'success'));
			return;
		}
		echo json_encode(array('status' => 'error'));
	}

	public function get_all_mhs_seminar()
	{
		$seminar = $this->seminar_model;
		echo json_encode(array('data' => $seminar->get_all_mhs_seminar()));
	}

	public function get_penguji()
	{
		$status = isset($_GET['status']) ? $_GET['status'] : null;
		$seminar = $this->seminar_model;
		echo json_encode(array('data' => $seminar->get_all_penguji($status)));
	}

	public function add_penguji()
	{
		$seminar = $this->seminar_model;
		if ($seminar->add_penguji()) {
			echo json_encode(array('status' => 'success'));
			return;
		} else {
			echo json_encode(array('status' => 'error'));
			return;
		}
	}

	public function add_bulk_penguji()
	{
		$seminar = $this->seminar_model;
		if ($seminar->add_bulk_penguji()) {
			echo json_encode(array('status' => 'success'));
			return;
		} else {
			echo json_encode(array('status' => 'error'));
			return;
		}
	}

	public function delete_bulk_penguji()
	{
		$seminar = $this->seminar_model;
		if ($seminar->delete_bulk_penguji()) {
			echo json_encode(array('status' => 'success'));
			return;
		} else {
			echo json_encode(array('status' => 'error'));
			return;
		}
	}

	public function delete_penguji()
	{
		$seminar = $this->seminar_model;
		if ($seminar->delete_penguji()) {
			echo json_encode(array('status' => 'success'));
			return;
		} else {
			echo json_encode(array('status' => 'error'));
			return;
		}
	}

	public function get_tempat()
	{
		$seminar = $this->seminar_model;
		echo json_encode(array('data' => $seminar->get_tempat_seminar()));
	}

	public function add_tempat()
	{
		$seminar = $this->seminar_model;
		if ($seminar->add_tempat_seminar()) {
			echo json_encode(array('status' => 'success'));
			return;
		}
	}

	public function update_tempat()
	{
		$seminar = $this->seminar_model;
		if ($seminar->update_tempat_seminar()) {
			echo json_encode(array('status' => 'success'));
		}
	}

	public function delete_tempat()
	{
		$seminar = $this->seminar_model;
		if ($seminar->delete_tempat_seminar()) {
			echo json_encode(array('status' => 'success'));
		}
	}

	public function get_waktu()
	{
		$seminar = $this->seminar_model;
		echo json_encode(array('data' => $seminar->get_waktu_seminar()));
	}

	public function add_waktu()
	{
		$seminar = $this->seminar_model;
		if ($seminar->add_waktu_seminar()) {
			echo json_encode(array('status' => 'success'));
			return;
		}
	}

	public function update_waktu()
	{
		$seminar = $this->seminar_model;
		if ($seminar->update_waktu_seminar()) {
			echo json_encode(array('status' => 'success'));
		}
	}

	public function delete_waktu()
	{
		$seminar = $this->seminar_model;
		if ($seminar->delete_waktu_seminar()) {
			echo json_encode(array('status' => 'success'));
		}
	}

	public function get_tanggal()
	{
		$seminar = $this->seminar_model;
		echo json_encode(array('data' => $seminar->get_tanggal_seminar()));
	}

	public function add_tanggal()
	{
		$seminar = $this->seminar_model;
		if ($seminar->add_tanggal_seminar()) {
			echo json_encode(array('status' => 'success'));
			return;
		}
	}

	public function update_tanggal()
	{
		$seminar = $this->seminar_model;
		if ($seminar->update_tanggal_seminar()) {
			echo json_encode(array('status' => 'success'));
		}
	}

	public function delete_tanggal()
	{
		$seminar = $this->seminar_model;
		if ($seminar->delete_tanggal_seminar()) {
			echo json_encode(array('status' => 'success'));
		}
	}

	public function index_kelola_jadwal()
	{
		$seminar = $this->seminar_model;
		$prodies = masterdata('tb_program_studi', null, '*');
		$data['prodies'] = $prodies;
		foreach ($prodies as $prodi) {
			$select = 'tb_dosen.id,tb_pegawai.nama_pegawai,tb_pegawai.nip_nik';
			$where = "id_program_studi = '$prodi->id_program_studi'";
			$join = array(
				array('tb_pegawai', 'tb_dosen.nip_nik = tb_pegawai.nip_nik', 'INNER'),
			);
			$dosens = datajoin('tb_dosen', $where, $select, $join);
			$data['dosens'][$prodi->id_program_studi] = $dosens;
			foreach ($dosens as $dosen) {
				$data['penguji'][$dosen->id] = masterdata('tb_seminar_penguji', "id_dosen = $dosen->id", '*', 
				true, 'status');
			}
			$data['tempat'] = $seminar->count_tempat();
			$data['waktu'] = $seminar->count_waktu();
			$data['penguji_1'] = $seminar->count_penguji('p1');
			$data['penguji_2'] = $seminar->count_penguji('p2');
		}
		return $this->load->view('admin/seminar_jadwal', $data);
	}

} ?>
