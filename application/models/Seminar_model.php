<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seminar_model extends CI_Model
{
	public function get_tempat_seminar($alias = null)
	{
		$post = $this->input->post();
		if (isset($_GET['id'])) {
			$where = "id = $_GET[id]";
			$this->db->where($where);
		}
		if (isset($post['destination'])) {
			$this->db->select('id,nama title');
		}
		if ($alias) {
			$this->db->select("id,nama $alias");
		}
		return $this->db->get('tb_seminar_tempat')->result();
	}

	public function acc_verifikasi_pendaftaran($id){
		$this->db->where('id',$id);
		$this->db->set(array('status'=>'accept'));
		return $this->db->update('tb_seminar_pendaftaran');
	}
	public function dec_verifikasi_pendaftaran($id){
		$this->db->where('id',$id);
		$this->db->set(array('status'=>'reupload'));
		return $this->db->update('tb_seminar_pendaftaran');
	}
	public function get_all_seminar_date()
	{
		return $this->db->query("SELECT
					tsj.id id_jadwal,
       				mulai,
					DATE(tsj.mulai) as tanggal_seminar
				FROM
					tb_seminar_jadwal tsj
				GROUP BY
					tanggal_seminar")->result();
	}

	public function get_current_status_pendaftaran_seminar()
	{
		return $this->db->query("SELECT
				tsj.*,tsp.file,tsp.size
			FROM (
				SELECT
					tsj.id id_jadwal,
					tsj.mulai,
					tm.nama_mahasiswa
				FROM
					tb_seminar_jadwal tsj
					INNER JOIN tb_dosen_bimbingan_mhs tdbm ON tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs
					INNER JOIN tb_mahasiswa tm ON tm.nim = tdbm.nim) tsj
				LEFT OUTER JOIN tb_seminar_pendaftaran tsp ON tsj.id_jadwal = tsp.id_jadwal_seminar
			ORDER BY mulai")->result();
	}

	public function get_self_mahasiswa_seminar()
	{
		$id = $this->session->userdata('id');
		return $this->db->query("select tsj.mulai tanggal_seminar,tsj.id id_jadwal,status_seminar,nim,nip_nik,judul_laporan_mhs 
								from tb_dosen_bimbingan_mhs tdbm 
								inner join tb_seminar_jadwal tsj 
								on tdbm.id_dosen_bimbingan_mhs = tsj.id_dosen_bimbingan_mhs where tdbm.nim = '$id'")->result();
	}

	public function get_status_pendaftaran()
	{
		$id = $this->session->userdata('id');
		return $this->db->query("select tsp.* 
								from tb_dosen_bimbingan_mhs tdbm 
								inner join tb_seminar_jadwal tsj 
								on tdbm.id_dosen_bimbingan_mhs = tsj.id_dosen_bimbingan_mhs 
								inner join tb_seminar_pendaftaran tsp
								on tsp.id_jadwal_seminar = tsj.id where tdbm.nim = '$id'")->row();
	}

	public function save_pendaftaran($file)
	{
		$id = $this->session->userdata('id');
		$jadwal = datajoin('tb_seminar_jadwal tsj', array('nim' => $id), 'id', array('tb_dosen_bimbingan_mhs tdbm', 'tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs', 'inner'));
		if (count($jadwal) > 0) {
			$id_jadwal = $jadwal[0]->id;
		} else {
			return false;
		}
		$this->db->where('id_jadwal_seminar', $id_jadwal);
		if ($this->db->delete('tb_seminar_pendaftaran')) {
			$this->db->reset_query();
			$data = array(
				'id_jadwal_seminar' => $id_jadwal,
				'file' => $file['file_name'],
				'size' => $file['file_size']
			);
			return $this->db->insert('tb_seminar_pendaftaran', $data);
		} else {
			return false;
		}

	}

	public function add_tempat_seminar()
	{
		$post = $this->input->post();
		$data = array('nama' => $post['tempat']);
		return $this->db->insert('tb_seminar_tempat', $data);
	}

	public function update_tempat_seminar()
	{
		$post = $this->input->post();
		$data = array('nama' => $post['tempat']);
		$where = "id = $post[id]";
		return $this->db->update('tb_seminar_tempat', $data, $where);
	}

	public function delete_tempat_seminar()
	{
		$post = $this->input->post();
		$where = "id = $post[id]";
		return $this->db->delete('tb_seminar_tempat', $where);
	}

	public function get_waktu_seminar()
	{
		if (isset($_GET['id'])) {
			$where = "id = $_GET[id]";
			$this->db->where($where);
		}
		return $this->db->get('tb_seminar_waktu')->result();
	}

	public function add_waktu_seminar()
	{
		$post = $this->input->post();
		$data = array('jam' => $post['jam']);
		return $this->db->insert('tb_seminar_waktu', $data);
	}

	public function update_waktu_seminar()
	{
		$post = $this->input->post();
		$data = array('jam' => $post['jam']);
		$where = "id = $post[id]";
		return $this->db->update('tb_seminar_waktu', $data, $where);
	}

	public function delete_waktu_seminar()
	{
		$post = $this->input->post();
		$where = "id = $post[id]";
		return $this->db->delete('tb_seminar_waktu', $where);
	}

	public function get_tanggal_seminar()
	{
		if (isset($_GET['id'])) {
			$where = "id = $_GET[id]";
			$this->db->where($where);
		}
		return $this->db->get('tb_seminar_tanggal')->result();
	}

	public function add_tanggal_seminar()
	{
		$post = $this->input->post();
		$data = array('hari' => $post['hari'], 'tanggal' => $post['tanggal']);
		return $this->db->insert('tb_seminar_tanggal', $data);
	}

	public function update_tanggal_seminar()
	{
		$post = $this->input->post();
		$data = array('hari' => $post['hari'], 'tanggal' => $post['tanggal']);
		$where = "id = $post[id]";
		return $this->db->update('tb_seminar_tanggal', $data, $where);
	}

	public function delete_tanggal_seminar()
	{
		$post = $this->input->post();
		$where = "id = $post[id]";
		return $this->db->delete('tb_seminar_tanggal', $where);
	}

	public function add_penguji()
	{
		$post = $this->input->post();
		$data = array('id_dosen' => $post['id'], 'status' => $post['mode']);
		return $this->db->insert('tb_seminar_penguji', $data);
	}

	public function add_bulk_penguji()
	{
		$post = $this->input->post();
		$data = array();
		foreach ($post['ids'] as $id_dosen) {
			array_push($data, array('id_dosen' => $id_dosen, 'status' => $post['mode']));
		}
		return $this->db->insert_batch('tb_seminar_penguji', $data);
	}

	public function delete_bulk_penguji()
	{
		$post = $this->input->post();
		$data = array();
		foreach ($post['ids'] as $id) {
			$where = "id = $id";
			if (!$this->db->delete('tb_seminar_penguji', $where)) {
				return false;
			}
		}
		return true;
	}

	public function get_all_mhs_seminar()
	{
		return $this->db->query("
			select tm.nama_mahasiswa,tp.nama_pegawai nama_pembimbing, tdbm.id_dosen_bimbingan_mhs,tdbm.judul_laporan_mhs from tb_dosen_bimbingan_mhs tdbm 
			INNER JOIN tb_mahasiswa tm on tm.nim = tdbm.nim 
			INNER JOIN tb_pegawai tp ON tdbm.nip_nik = tp.nip_nik
			where tdbm.status_seminar = 'setuju' and tdbm.id_dosen_bimbingan_mhs NOT IN (select id_dosen_bimbingan_mhs from tb_seminar_jadwal) order by tm.nama_mahasiswa")->result();
	}

	public function get_all_penguji($status)
	{
		$select = 'tb_seminar_penguji.id,tb_pegawai.nama_pegawai,tb_pegawai.nip_nik';
		$join = array(
			array('tb_dosen', 'tb_dosen.id = tb_seminar_penguji.id_dosen', 'INNER'),
			array('tb_pegawai', 'tb_dosen.nip_nik = tb_pegawai.nip_nik', 'INNER')
		);
		$where = "tb_seminar_penguji.status = '$status'";
		return datajoin('tb_seminar_penguji', $where, $select, $join, null, 'tb_pegawai.nama_pegawai');
	}

	public function delete_penguji()
	{
		$post = $this->input->post();
		$where = array('id' => $post['id']);
		return $this->db->delete('tb_seminar_penguji', $where);
	}

	public function count_tempat()
	{
		return $this->db->query('SELECT COUNT(*) as jumlah FROM tb_seminar_tempat')->row();
	}

	public function count_waktu()
	{
		return $this->db->query('SELECT COUNT(*) as jumlah FROM tb_seminar_waktu')->row();
	}

	public function count_penguji($status)
	{
		return $this->db->query("SELECT COUNT(*) as jumlah FROM tb_seminar_penguji WHERE status = '$status'")->row();
	}

	public function add_jadwal()
	{
		$post = $this->input->post();
		$data = array('id_dosen_bimbingan_mhs' => $post['id_dosen_bimbingan_mhs'],
			'id_seminar_ruangan' => $post['id_seminar_ruangan'],
			'mulai' => $post['mulai'],
			'berakhir' => $post['berakhir'],
			'id_penguji_1' => $post['id_penguji'][0],
			'id_penguji_2' => $post['id_penguji'][1]);
		return $this->db->insert('tb_seminar_jadwal', $data);
	}

	public function update_jadwal()
	{
		$post = $this->input->post();
		$id = $post['id'];
		$data = array('id_dosen_bimbingan_mhs' => $post['id_dosen_bimbingan_mhs'],
			'id_seminar_ruangan' => $post['id_seminar_ruangan'],
			'mulai' => $post['mulai'],
			'berakhir' => $post['berakhir'],
			'id_penguji_1' => $post['id_penguji'][0],
			'id_penguji_2' => $post['id_penguji'][1]);
		return $this->db->update('tb_seminar_jadwal', $data, "id = $id");
	}

	public function delete_jadwal()
	{
		$post = $this->input->post();
		$id = $post['id'];
		return $this->db->delete('tb_seminar_jadwal', "id=$id");
	}

	public function get_jadwal_past($id = null, $date, $time)
	{
		$post = $this->input->post();
		$where = "WHERE ";
		if ($id) {
			$where .= "(tp1.nip_nik = '$id' OR tp2.nip_nik = '$id' OR tp3.nip_nik = '$id') AND";
		}
		$datetime = $time ? $date . 'T' . $time : $date;
		$where .= " tsj.mulai < '$datetime'";
		if (isset($post['ij'])) {
			$where .= "AND tsj.id = '$post[ij]'";
		}
		$where .= " AND tsp.id IN (SELECT id FROM tb_seminar_penilaian WHERE id_dosen = '$id' AND id_seminar_jadwal = tsj.id )";
		return $this->db->query("SELECT
    		tsp.id id,
			tsj.id ij,
			tp3.nama_pegawai p3,
			tp1.nama_pegawai p1,
			tp2.nama_pegawai p2,
    		tdbm.judul_laporan_mhs laporan,
			tst.nama nama_tempat,
			tm.nama_mahasiswa,
       		tsp.nilai_seminar,
       		tsp.detail_nilai_seminar,
       		thsp.nilai_seminar nilai_seminar_past,
       		thsp.detail_nilai_seminar detail_nilai_seminar_past,
       		tsp.status_revisi,
       		tps.nama_program_studi,
       		tm.nim,
			tsj.mulai start,
			tsj.berakhir end,
       		tsj.id_dosen_bimbingan_mhs id_bimbingan
		FROM
			tb_seminar_jadwal tsj
		INNER JOIN tb_seminar_tempat tst ON tst.id = tsj.id_seminar_ruangan
		INNER JOIN tb_seminar_penilaian tsp ON tsp.id_seminar_jadwal = tsj.id
		LEFT OUTER JOIN tb_history_seminar_penilaian thsp ON thsp.id_seminar_penilaian = tsp.id
		INNER JOIN tb_dosen_bimbingan_mhs tdbm ON tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs
		INNER JOIN tb_pegawai tp3 ON tp3.nip_nik = tdbm.nip_nik
		INNER JOIN tb_mahasiswa tm ON tm.nim = tdbm.nim
		INNER JOIN tb_program_studi tps on tm.id_program_studi = tps.id_program_studi
		INNER JOIN tb_seminar_penguji penguji_1 ON penguji_1.id = tsj.id_penguji_1
		INNER JOIN tb_seminar_penguji penguji_2 ON penguji_2.id = tsj.id_penguji_2
		INNER JOIN tb_dosen td1 ON td1.id = penguji_1.id_dosen
		INNER JOIN tb_dosen td2 ON td2.id = penguji_2.id_dosen
		INNER JOIN tb_pegawai tp1 ON tp1.nip_nik = td1.nip_nik
		INNER JOIN tb_pegawai tp2 ON tp2.nip_nik = td2.nip_nik
			$where
		ORDER BY start")->result();
	}

	public function get_jadwal_past_left($id = null, $date, $time)
	{
		$post = $this->input->post();
		$where = "WHERE ";
		if ($id) {
			$where .= "(tp1.nip_nik = '$id' OR tp2.nip_nik = '$id' OR tp3.nip_nik = '$id') AND";
		}
		$datetime = $time ? $date . 'T' . $time : $date;
		$where .= " tsj.berakhir < '$datetime'";
		if (isset($post['ij'])) {
			$where .= "AND tsj.id = '$post[ij]'";
		}
		$where .= " AND tsj.id NOT IN (SELECT id_seminar_jadwal FROM tb_seminar_penilaian WHERE id_dosen='$id' AND id_seminar_jadwal = tsj.id)";
		return $this->db->query("SELECT
			tsj.id ij,
			tp3.nama_pegawai p3,
			tp1.nama_pegawai p1,
			tp2.nama_pegawai p2,
    		tdbm.judul_laporan_mhs laporan,
			tst.nama nama_tempat,
			tm.nama_mahasiswa,
       		tps.nama_program_studi,
       		tm.nim,
			tsj.mulai start,
			tsj.berakhir end
		FROM
			tb_seminar_jadwal tsj
		INNER JOIN tb_seminar_tempat tst ON tst.id = tsj.id_seminar_ruangan
		INNER JOIN tb_dosen_bimbingan_mhs tdbm ON tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs
		INNER JOIN tb_pegawai tp3 ON tp3.nip_nik = tdbm.nip_nik
		INNER JOIN tb_mahasiswa tm ON tm.nim = tdbm.nim
		INNER JOIN tb_program_studi tps on tm.id_program_studi = tps.id_program_studi
		INNER JOIN tb_seminar_penguji penguji_1 ON penguji_1.id = tsj.id_penguji_1
		INNER JOIN tb_seminar_penguji penguji_2 ON penguji_2.id = tsj.id_penguji_2
		INNER JOIN tb_dosen td1 ON td1.id = penguji_1.id_dosen
		INNER JOIN tb_dosen td2 ON td2.id = penguji_2.id_dosen
		INNER JOIN tb_pegawai tp1 ON tp1.nip_nik = td1.nip_nik
		INNER JOIN tb_pegawai tp2 ON tp2.nip_nik = td2.nip_nik
			$where
		ORDER BY start")->result();
	}

	public function get_jadwal_today($id = null, $date, $time = null)
	{
		$post = $this->input->post();
		$where = "WHERE ";
		if ($id) {
			$where .= "(tp1.nip_nik = '$id' OR tp2.nip_nik = '$id' OR tp3.nip_nik = '$id') AND";
		}
		$datetime = $time ? $date . 'T' . $time : $date;
		$where .= " tsj.mulai like '$datetime%'";
		if (isset($post['ij'])) {
			$where .= " AND tsj.id = '$post[ij]'";
		}
		$where .= " AND tsj.id NOT IN (SELECT id_seminar_jadwal FROM tb_seminar_penilaian WHERE id_dosen = '$id')";
		return $this->db->query("SELECT
			tsj.id ij,
			tp3.nama_pegawai p3,
			tp1.nama_pegawai p1,
			tp2.nama_pegawai p2,
    		tdbm.judul_laporan_mhs laporan,
			tst.nama nama_tempat,
			tm.nama_mahasiswa,
       		tps.nama_program_studi,
       		tm.nim,
			tsj.mulai start,
			tsj.berakhir end
		FROM
			tb_seminar_jadwal tsj
		INNER JOIN tb_seminar_tempat tst ON tst.id = tsj.id_seminar_ruangan
		INNER JOIN tb_dosen_bimbingan_mhs tdbm ON tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs
		INNER JOIN tb_pegawai tp3 ON tp3.nip_nik = tdbm.nip_nik
		INNER JOIN tb_mahasiswa tm ON tm.nim = tdbm.nim
		INNER JOIN tb_program_studi tps on tm.id_program_studi = tps.id_program_studi
		INNER JOIN tb_seminar_penguji penguji_1 ON penguji_1.id = tsj.id_penguji_1
		INNER JOIN tb_seminar_penguji penguji_2 ON penguji_2.id = tsj.id_penguji_2
		INNER JOIN tb_dosen td1 ON td1.id = penguji_1.id_dosen
		INNER JOIN tb_dosen td2 ON td2.id = penguji_2.id_dosen
		INNER JOIN tb_pegawai tp1 ON tp1.nip_nik = td1.nip_nik
		INNER JOIN tb_pegawai tp2 ON tp2.nip_nik = td2.nip_nik
			$where
		ORDER BY start")->result();
	}

	public function get_jadwal($where = null)
	{
		$post = $this->input->post();
		$select = "tsj.id, tst.id id_tempat, tp3.nama_pegawai nama_pembimbing, tst.nama nama_tempat, tm.nama_mahasiswa title, tdbm.judul_laporan_mhs laporan, 
		tsj.id_dosen_bimbingan_mhs, tsj.mulai start, tsj.berakhir end, tsj.id_penguji_1, tsj.id_penguji_2, 'bg-info' as className, 
		tp1.nama_pegawai p1, tp2.nama_pegawai p2";
		if (isset($post['view'])) {
			$select = "tsj.id, tst.id resourceId, tp3.nama_pegawai nama_pembimbing, tst.nama nama_tempat, tm.nama_mahasiswa title, tdbm.judul_laporan_mhs laporan, 
		tsj.id_dosen_bimbingan_mhs, tsj.mulai start, tsj.berakhir end, tsj.id_penguji_1, tsj.id_penguji_2, 'bg-info' as className, 
		tp1.nama_pegawai p1, tp2.nama_pegawai p2";
		}
		if ((isset($post['filter']) and $post['filter'] == 'penguji')) {
			$nip = $this->session->userdata('nip_nik');
			$where = "WHERE td1.nip_nik = '$nip' OR td2.nip_nik = '$nip'";
		}
		if ((isset($post['filter']) and $post['filter'] == 'pembimbing')) {
			$nip = $this->session->userdata('nip_nik');
			$where = "WHERE tdbm.nip_nik = '$nip'";
		}
		return $this->db->query("SELECT $select FROM tb_seminar_jadwal tsj
			INNER JOIN tb_seminar_tempat tst ON tst.id = tsj.id_seminar_ruangan
			INNER JOIN tb_dosen_bimbingan_mhs tdbm ON tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs
    		INNER JOIN tb_pegawai tp3 ON tp3.nip_nik = tdbm.nip_nik
			INNER JOIN tb_mahasiswa tm ON tm.nim = tdbm.nim
			INNER JOIN tb_seminar_penguji penguji_1 ON penguji_1.id = tsj.id_penguji_1
			INNER JOIN tb_seminar_penguji penguji_2 ON penguji_2.id = tsj.id_penguji_2
			INNER JOIN tb_dosen td1 ON td1.id = penguji_1.id_dosen
			INNER JOIN tb_dosen td2 ON td2.id = penguji_2.id_dosen
			INNER JOIN tb_pegawai tp1 ON tp1.nip_nik = td1.nip_nik
			INNER JOIN tb_pegawai tp2 ON tp2.nip_nik = td2.nip_nik $where")->result();
	}

	public function insert_penilaian()
	{
		$post = $this->input->post();
		$data = array(
			"nilai_seminar" => $post['nas'],
			"detail_nilai_seminar" => $post['dns'],
			"id_seminar_jadwal" => $post['ij'],
			"id_dosen" => $post['session'],
			"status_dosen" => $post['status'],
		);
		return $this->db->insert('tb_seminar_penilaian', $data);

	}

	public function update_penilaian()
	{
		$post = $this->input->post();
		$data = array(
			"nilai_seminar" => $post['nas'],
			"detail_nilai_seminar" => $post['dns'],
			"id_seminar_jadwal" => $post['ij'],
			"id_dosen" => $post['session'],
			"status_dosen" => $post['status'],
			"status_revisi" => 1
		);
		$id = $post['id'];
		if ($id != "") {
			$this->db->trans_start();
			$this->db->query("insert into tb_history_seminar_penilaian(id_seminar_penilaian, nilai_seminar,tanggal_revisi, detail_nilai_seminar) select id ,nilai_seminar,DATE(NOW()),detail_nilai_seminar from tb_seminar_penilaian where id = '$id'");
			$this->db->update('tb_seminar_penilaian', $data, "id = '$id'");
			$this->db->trans_complete();
			return $this->db->trans_status();
		}
		return false;
	}

	public function tampil_tgl($id)

	{
		$hasil=$this->db->query("SELECT tsj.id, tm.nama_mahasiswa, tsj.id_dosen_bimbingan_mhs, tsj.mulai, tsj.berakhir FROM tb_seminar_jadwal tsj
		 INNER JOIN tb_dosen_bimbingan_mhs tdbm ON tsj.id_dosen_bimbingan_mhs = tdbm.id_dosen_bimbingan_mhs
		 INNER JOIN tb_mahasiswa tm ON tm.nim = tdbm.nim WHERE tm.nim = '$id'")->result();
		return $hasil;
	}
}
