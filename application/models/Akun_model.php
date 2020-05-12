<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_model extends CI_Model
{

	private $_table = 'tb_akun';
	private $_primary_key = 'username';
	private $_seconde_primary = 'id';
	public $username;
	public $password;

	//add parameter here

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->helper(array('master'));

	}

	public function rules()
	{
		return array(
			array(
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			),
		);
	}

	public function getAll()
	{
		return $this->db->get($this->_table)->result();
	}

	public function getById($id = null)
	{
		return $this->db->get_where($this->_table, array($this->_primary_key => $id))->row();
	}
	public function get_detail_account($id){
		return $this->db->get_where($this->_table, array($this->_seconde_primary => $id))->row();
	}

	public function getAllAccounts($kind = null,$id = null)
	{
		if($id){
			$this->db->where("tb_akun.id = '$id'");
		}
		$this->db->select('tb_akun.id,tb_akun.username, tb_akun.password, tb_akun.level,tb_akun.id_level')
			->from('(select tb_akun.*,tb_level.id_level,tb_master_level.nama_master_level as level from tb_akun inner join tb_level on tb_akun.username = tb_level.username left outer join tb_master_level on tb_level.id_master_level = tb_master_level.id_master_level) tb_akun');
		if ($kind !== null) {
			switch ($kind) {
				case 'pegawai':
					$this->db->select('tb_pegawai.nama_pegawai as nama');
					$this->db->join('tb_pegawai', 'tb_pegawai.username = tb_akun.username', 'INNER');
					break;
				case 'mahasiswa':
					$this->db->select('tb_mahasiswa.nama_mahasiswa as nama');
					$this->db->join('(select tm.*,tw.`id_tahun_akademik` as id_ta from tb_mahasiswa tm join tb_waktu tw on tm.id_tahun_akademik =tw.id_tahun_akademik) tb_mahasiswa', 'tb_mahasiswa.username = tb_akun.username', 'INNER');
					break;
				case 'peserta':
					$this->db->select('tb_peserta.namapes as nama');
					$this->db->join('(select tp.*,tw.`id_tahun_akademik` as id_ta from tb_peserta tp join tb_waktu tw on tp.id_tahun_akademik =tw.id_tahun_akademik) tb_peserta', 'tb_peserta.username = tb_akun.username', 'INNER');
					break;
			}
		}
		return $this->db->get()->result();
	}

	public function tambah_akun(){
		$post = $this->input->post();
		//insert akun
		if($post['mode'] === 'mahasiswa'){
			$this->db->trans_start();
			$input_akun = array('username'=>$post['username'],'password'=>password_hash($post['password'], PASSWORD_DEFAULT));
			$this->db->insert('tb_akun',$input_akun);
			$input_level = array('username'=>$post['username'],'id_master_level'=>'IML006');
			$this->db->insert('tb_level',$input_level);
			$input_mahasiswa = array('username'=>$post['username'],'nim'=>$post['id'],'nama_mahasiswa'=>$post['nama'],'id_tahun_akademik'=>$post['id_ta'],'id_program_studi'=>$post['id_prodi']);
			$this->db->insert('tb_mahasiswa',$input_mahasiswa);
			$this->db->trans_complete();
			if ($this->db->trans_status() != false) {
				redirect(site_url('akun'));
			}
		}
		else if($post['mode'] === 'peserta'){
			$this->db->trans_start();
			$input_akun = array('username'=>$post['username'],'password'=>password_hash($post['password'], PASSWORD_DEFAULT));
			$this->db->insert('tb_akun',$input_akun);
			$input_level = array('username'=>$post['username'],'id_master_level'=>'IML009');
			$this->db->insert('tb_level',$input_level);
			$input_peserta = array('username'=>$post['username'],'nimpes'=>$post['id'],'namapes'=>$post['nama'],'id_tahun_akademik'=>$post['id_ta'],'id_program_studi'=>$post['id_prodi']);
			$this->db->insert('tb_peserta',$input_peserta);
			$this->db->trans_complete();
			if ($this->db->trans_status() != false) {
				redirect(site_url('akun'));
			}
		}
		else{
			$this->db->trans_start();
			$input_akun = array('username'=>$post['username'],'password'=>md5($post['password']));
			$this->db->insert('tb_akun',$input_akun);
			foreach ($post['level'] as $level){
				$input_level = array('username'=>$post['username'],'id_master_level'=>$level);
				$this->db->insert('tb_level',$input_level);
			}
			$input_pegawai = array('username'=>$post['username'],'email_pegawai'=>$post['username'],'nip_nik'=>$post['id'],'nama_pegawai'=>$post['nama']);
			$this->db->insert('tb_pegawai',$input_pegawai);
			$this->db->trans_complete();
			if ($this->db->trans_status() != false) {
				//add session flash
				redirect(site_url('akun'));
			}
		}

		//insert level
		//insert pegawai || insert mahasiswa
	}
	public function delete_akun($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('tb_akun');
	}
	public function hapus_level(){
		$post = $this->input->post();
		$this->db->where("id_master_level = '$post[id_lev]' AND username='$post[username]'");
		return $this->db->delete('tb_level');
	}
	public function edit_level(){
		$post = $this->input->post();
		$this->db->set(array("id_master_level" => $post['id_lev'],"username"=>$post['username']));
		return $this->db->insert('tb_level');
	}
	public function edit_password(){
		$post = $this->input->post();
		$this->db->set(array('password'=>md5($post['newpass'])));
		$this->db->where("id = '$post[id]'");
		return $this->db->update('tb_akun');
	}

	public function addAccount($data)
	{
		return $this->db->insert('tb_akun', $data);
	}

	public function getAccount($akun)
	{
		$result = null;
		// var_dump('reading');
		//why two, cause akun require only username and password
		if (count($akun) != 0) {
			$result = $this->db->select(array(
				'tb_akun.username as id',
				'tb_master_level.nama_master_level as level',
				'tb_akun.password as password'
			))
				->from('tb_akun')
				->join('tb_level', 'tb_akun.username = tb_level.username', 'left outer')
				->join('tb_master_level', 'tb_level.id_master_level = tb_master_level.id_master_level')
				->where($akun)->get()->result();
		}

		return $result;
	}

	public function insert()
	{

		$post = $this->input->post();

		$this->username = $post['username'];
		$this->password = password_hash($post['password'], PASSWORD_DEFAULT);
		//add parameter here
		$this->db->insert($this->_table, $this);
	}
	public function insert_level($uname,$level_id){
		return $this->db->insert('tb_level',array('username'=>$uname,'id_master_level'=>$level_id));
	}
	public function make_account($datas = array(), $dataName)
	{
		$createdAccount = array();
		ini_set('max_execution_time', 120);
		foreach ($datas as $data) {
			array_push($createdAccount, array(
				'username' => $data->{$dataName},
				'password' => password_hash($data->{$dataName}, PASSWORD_DEFAULT),
			));
		}

		return $createdAccount;
	}

	public function match_data($datas = array(), $addtionalDatas = array(), $replacers =array(), $addtionalUnset = array())
	{
		//rename index data
		array_map(function ($data) use ($replacers, $addtionalUnset) {
			foreach ($replacers as $replacer) {
				//inject new index with same value
				$data->{$replacer['new']} = $data->{$replacer['old']};
				//delete old index
				if (!$replacer['keep']) {
					unset($data->{$replacer['old']});
				}
				if (count($addtionalUnset) != 0) {
					foreach ($addtionalUnset as $unset) {
						unset($data->{$unset});
					}
				}
			}

			return $data;
		}, $datas);
		//inject addtional data
		foreach ($datas as $data) {
			foreach ($addtionalDatas as $indexName => $dataName) {
				$data->{$indexName} = $dataName;
			}
		}

		return $datas;
	}

	public function insert_batch($batchData, $importFor = null, $addtionalDatas = [])
	{
		// Batch data must array, at least contain username and password

		$statusImport = array();
		$statusImport['status'] = false;
		$key = null;
		$primaryTable = 'tb_akun';
		//addtional table
		$addtionalTable = null;
		$addtionalTable2 = null;
		$addtionalTable3 = null;
		//replacer
		$replacers = [];
		$replacerLevel = [];
		$replacerNotif = [];
		//unset data
		$unsetDataLevel = [];
		$unsetDataNotif = [];

		$addtionalDataLevel = [];
		$addtionalDataNotif = [];
		switch ($importFor) {
			case 'mahasiswa':
				$key = 'nim';
				$replacers = array(
					['old' => 'nama', 'new' => 'nama_mahasiswa', 'keep' => false],
					['old' => 'nim', 'new' => 'username', 'keep' => true]
				);
				$replacerLevel = [
					[
						'old' => 'nim',
						'new' => 'username',
						'keep' => false
					]
				];
				$unsetDataLevel = ['id_program_studi', 'id_tahun_akademik', 'nama_mahasiswa'];
				//fecting data needed
				$idLevelMhs = masterdata('tb_master_level', ['nama_master_level' => 'mahasiswa']);
				$addtionalDataLevel['id_master_level'] = $idLevelMhs->id_master_level;


				$addtionalDataNotif['pengirim'] = $this->session->userdata('level') ? $this->session->userdata('level') : null;
				$addtionalDataNotif['pesan'] = 'Silahkan melengkapi profil terlebih dahulu untuk bisa mengajukan permohonan magang';
				$addtionalDataNotif['hal'] = 'profil';
				$addtionalDataNotif['uri'] = 'user/profile';
				$unsetDataNotif = ['id_master_level'];
				$replacerNotif = [
					[
						'old' => 'username',
						'new' => 'penerima',
						'keep' => false
					]
				];
				$addtionalTable = 'tb_mahasiswa';
				$addtionalTable2 = 'tb_level';
				$addtionalTable3 = 'tb_notification';

				break;
			case 'pegawai':
				//chage this config
				//key same as data id
				$key = 'nip';
				$replacers = array(
					['old' => 'nama', 'new' => 'nama_pegawai', 'keep' => false],
					['old' => 'nip', 'new' => 'nip_nik', 'keep' => true],
					['old' => 'nip', 'new' => 'username', 'keep' => false],
					['old' => 'alamat', 'new' => 'alamat_pegawai', 'keep' => false],
					['old' => 'jk', 'new' => 'jk_pegawai', 'keep' => false],
					['old' => 'email', 'new' => 'email_pegawai', 'keep' => false],
				);

				//fecting data needed
				$idLevelMhs = masterdata('tb_master_level', ['nama_master_level' => 'dosen']);
				$addtionalDataLevel['id_master_level'] = $idLevelMhs->id_master_level;

				$replacerLevel = [
					[
						'old' => 'nip_nik',
						'new' => 'username',
						'keep' => false
					]
				];
				$unsetDataLevel = ['nama_pegawai', 'nip_nik', 'alamat_pegawai', 'jk_pegawai', 'email_pegawai'];

				$addtionalDataNotif['pengirim'] = $this->session->userdata('level') ? $this->session->userdata('level') : null;
				$addtionalDataNotif['pesan'] = 'Akun telah dibuat, silahkan melengkapi profil';
				$addtionalDataNotif['hal'] = 'profil';
				$addtionalDataNotif['uri'] = 'user/profile';
				$unsetDataNotif = ['id_master_level'];
				$replacerNotif = [
					[
						'old' => 'username',
						'new' => 'penerima',
						'keep' => false
					]
				];

				$addtionalTable = 'tb_pegawai';
				$addtionalTable2 = 'tb_level';
				$addtionalTable3 = 'tb_notification';
				break;
			case 'peserta':
				$key = 'nimpes';
				$replacers = array(
					['old' => 'namapes', 'new' => 'namapes', 'keep' => false],
					['old' => 'nimpes', 'new' => 'username', 'keep' => true]
				);
				$replacerLevel = [
					[
						'old' => 'nimpes',
						'new' => 'username',
						'keep' => false
					]
				];
				$unsetDataLevel = ['id_program_studi', 'id_tahun_akademik', 'namapes'];
				//fecting data needed
				$idLevelMhs = masterdata('tb_master_level', ['nama_master_level' => 'peserta']);
				$addtionalDataLevel['id_master_level'] = $idLevelMhs->id_master_level;


				$addtionalDataNotif['pengirim'] = $this->session->userdata('level') ? $this->session->userdata('level') : null;
				$addtionalDataNotif['pesan'] = 'Silahkan melengkapi profil terlebih dahulu !';
				$addtionalDataNotif['hal'] = 'profil';
				$addtionalDataNotif['uri'] = 'user/profile';
				$unsetDataNotif = ['id_master_level'];
				$replacerNotif = [
					[
						'old' => 'username',
						'new' => 'penerima',
						'keep' => false
					]
				];
				$addtionalTable = 'tb_peserta';
				$addtionalTable2 = 'tb_level';
				$addtionalTable3 = 'tb_notification';

				break;
			default:
				return 0;
		}
		//generate account with username and password default
		$accounts = $this->make_account($batchData, $key);
		//START TRANSACTION
		$this->db->trans_start();
		$status = $this->db->insert_batch($primaryTable, $accounts);
		// var_dump($status);
		//status == TRUE,do insert to addtional Table

		//=========MATCH DATA METHOD ALWAYS GET DATA FROM RAW (BATCH DATA)
		if ($status != false) {

			//============insert batch to User (might be Mahasiswa, or Pegawai)
			//MATCHING DATA
			$generatedDataUser = $this->match_data($batchData, $addtionalDatas, $replacers);

//			var_dump( $generatedDataUser);
			//perform insert batch to User(it can be mahasiswa or pegawai)
			//BATCH INSERT
			$addtionalStatus = $this->db->insert_batch($addtionalTable, $generatedDataUser);


			//============insert batch to Level
			//MATCHING DATA
			$generatedDataLevel = $this->match_data($batchData, $addtionalDataLevel, $replacerLevel, $unsetDataLevel);

//			var_dump( $generatedDataLevel);

			//BATCH INSERT
			$this->db->insert_batch($addtionalTable2, $generatedDataLevel);

			//============insert batch to Notification
			//MATCHING DATA
			$generatedDataNotif = $this->match_data($batchData, $addtionalDataNotif, $replacerNotif, $unsetDataNotif);

//			var_dump( $generatedDataNotif);

			//BATCH INSERT
			$this->db->insert_batch($addtionalTable3, $generatedDataNotif);

			//GENERATE STATUS
			$statusImport[$primaryTable] = $status;
			if ($addtionalStatus != false) {
				$statusImport[$addtionalTable] = $addtionalStatus;
			}
		};
		//END TRANSACTION
		$this->db->trans_complete();
		//if status transaction complete, return true
		if ($this->db->trans_status() != false) {
			$statusImport['status'] = true;
		}

		return $statusImport;
	}

	public function update()
	{
		$post = $this->input->post();

		$this->username = $post['username'];
		$this->password = $post['password'];
		//add parameter here
		$this->db->update($this->_table, $this, [$this->_primary_key => $post['username']]);
	}

	public function delete($id)
	{
		$this->db->delete($this->_table, [$this->_primary_key => $id]);
	}

}

/* End of file suffix_model.php */ ?>
