<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{

	private $_table = 'tb_pegawai';

	private $_primary_key = 'nip_nik';
	public $nip_nik;
	public $username;
	public $id_status_pkl;
	public $id_pangkat_golongan;
	public $nama_pegawai;
	public $alamat_pegawai;
	public $jk_pegawai;
	public $email_pegawai;
	public $tempat_lahir_pegawai;
	public $tanggal_lahir_pegawai;
	public $no_hp_pegawai;

	//add parameter here

	public function rules()
	{
		return [
			[
				'field' => 'nip_nik',
				'label' => 'nip',
				'rules' => 'required'
			],
			[
				'field' => 'username',
				'label' => 'username',
				'rules' => 'required'
			],
			[
				'field' => 'id_status_pkl',
				'label' => 'id_status_pkl',
				'rules' => 'required'
			],
			[
				'field' => 'id_pangkat_golongan',
				'label' => 'id_pangkat_golongan',
				'rules' => 'required'
			],
			[
				'field' => 'nama_pegawai',
				'label' => 'nama_pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'alamat_pegawai',
				'label' => 'alamat_pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'jk_pegawai',
				'label' => 'jk_pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'email_pegawai',
				'label' => 'email_pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'tempat_lahir_pegawai',
				'label' => 'tempat_lahir_pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'tanggal_lahir_pegawai',
				'label' => 'tanggal_lahir_pegawai',
				'rules' => 'required'
			],
			[
				'field' => 'no_hp_pegawai',
				'label' => 'no_hp_pegawai',
				'rules' => 'required'
			],
		];
	}

	public function get_for_sync($order)
	{
		$this->db->select(array("nip_nik",
			"tb_pegawai.username username",
			"email_pegawai",
			"ta.password password",
			"nama_pegawai",
			"alamat_pegawai",
			"tempat_lahir_pegawai",
			"tanggal_lahir_pegawai",
			"jk_pegawai"));
		if ($order) {
			$this->db->order_by($order);
		}
		$this->db->join('tb_akun ta', 'ta.username = tb_pegawai.username', 'INNER');
		return $this->db->get($this->_table)->result();
	}

	public function getAll($order = null)
	{
		if ($order) {
			$this->db->order_by($order);
		}
		return $this->db->get($this->_table)->result();
	}

	public function getById($id = null)
	{
		return $this->db->get_where($this->_table, [$this->_primary_key => $id])->row();
	}

	public function sync_pegawai()
	{

	}

	public function insert()
	{
		$post = $this->input->post();
		$this->nip_nik = $post['nip'];
		$this->username = $post['username'];
		$this->id_status_pkl = $post['id_status_pkl'];
		$this->id_pangkat_golongan = $post['id_pangkat_golongan'];
		$this->nama_pegawai = $post['nama_pegawai'];
		$this->alamat_pegawai = $post['alamat_pegawai'];
		$this->jk_pegawai = $post['jk_pegawai'];
		$this->email_pegawai = $post['email_pegawai'];
		$this->tempat_lahir_pegawai = $post['tempat_lahir_pegawai'];
		$this->tanggal_lahir_pegawai = $post['tanggal_lahir_pegawai'];
		$this->no_hp_pegawai = $post['no_hp_pegawai'];
		//add parameter here
		$this->db->insert($this->_table, $this);
	}

	public function update()
	{
		$post = $this->input->post();

		$this->nip = $post['nip'];
		$this->username = $post['username'];
		$this->id_status_pkl = $post['id_status_pkl'];
		$this->id_pangkat_golongan = $post['id_pangkat_golongan'];
		$this->nama_pegawai = $post['nama_pegawai'];
		$this->alamat_pegawai = $post['alamat_pegawai'];
		$this->jk_pegawai = $post['jk_pegawai'];
		$this->email_pegawai = $post['email_pegawai'];
		$this->tempat_lahir_pegawai = $post['tempat_lahir_pegawai'];
		$this->tanggal_lahir_pegawai = $post['tanggal_lahir_pegawai'];
		$this->no_hp_pegawai = $post['no_hp_pegawai'];
		//add parameter here
		$this->db->update($this->_table, $this, [$this->_primary_key => $post['nip']]);
	}

	public function delete($id)
	{
		return $this->db->delete($this->_table, [$this->_primary_key => $id]);
	}

	public function generate_query_data($mode,$datas,$key)
	{
		$data_query = "";
		switch ($mode) {
			case 'akun':
				$key = array('username','password');
				$keys = implode(",", $key);
				foreach ($datas as $key => $data) {
					$data_query .= "(";
					$data_query .= "'$data->email_pegawai','$data->password'";
					$data_query .= ")";
					if ($key < count($datas) - 1) {
						$data_query .= ",";
					}
				}
				return (object)array("key"=>$keys,"data_query"=>$data_query);
				break;
			case 'level':
				$key = array('username','id_master_level');
				$keys = implode(",", $key);
				foreach ($datas as $key => $data) {
					$data_query .= "(";
					$data_query .= "'$data->email_pegawai','IML005'";
					$data_query .= ")";
					if ($key < count($datas) - 1) {
						$data_query .= ",";
					}
				}
				return (object)array("key"=>$keys,"data_query"=>$data_query);
				break;
			case 'pegawai':
				$result_key = array_search('password',$key);
				if($result_key){
					unset($key[$result_key]);
				}
				$keys = implode(",", $key);
				foreach ($datas as $key => $data) {
					unset($data->password);
					$data_query .= "(";
					$data_query .= implode(',', array_map(function ($d) {
						return '"' . $d . '"';
					}, (array)$data));
					$data_query .= ")";
					if ($key < count($datas) - 1) {
						$data_query .= ",";
					}
				}
				return (object)array("key"=>$keys,"data_query"=>$data_query);
				break;
			default:
				return true;
		}
	}

	public function insert_batch($datas)
	{
		$key = count($datas) > 0 ? array_keys((array)$datas[0]) : null;
		$keys_akun = $this->generate_query_data('akun',$datas,$key)->key;
		$data_query_akun = $this->generate_query_data('akun',$datas,$key)->data_query;
		$keys_level = $this->generate_query_data('level',$datas,$key)->key;
		$data_query_level = $this->generate_query_data('level',$datas,$key)->data_query;
		$keys_pegawai = $this->generate_query_data('pegawai',$datas,$key)->key;
		$data_query_pegawai = $this->generate_query_data('pegawai',$datas,$key)->data_query;
		$this->db->trans_start();
		//insert into akun
		$this->db->query("INSERT INTO tb_akun ($keys_akun) VALUES $data_query_akun");
		//insert into level
		$this->db->query("INSERT INTO tb_level ($keys_level) VALUES $data_query_level");
		//insert into pegawai
		$this->db->query("INSERT INTO tb_pegawai ($keys_pegawai) VALUES $data_query_pegawai");
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// generate an error... or use the log_message() function to log your error
			return false;
		}
		else{
			return true;
		}
	}

}

/* End of file suffix_model.php */ ?>
