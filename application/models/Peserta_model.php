<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta_model extends CI_Model {

    private $_table = 'tb_peserta';
    private $_primary_key = 'nimpes';
    
    public $nimpes;
    public $username;
    public $namapes;
  
    //add parameter here

    public function rules(){
        return[
            [
                'field'=>'nimpes',
                'label'=>'Nim',
                'rules'=>'required'
            ],
            [
                'field'=>'namapes',
                'label'=>'NamaPeserta',
                'rules'=>'required'
            ]
        ];
    }

    public function getAll($idProdi = null){
    	$this->db->select('tp.*,prodi.nama_program_studi,tw.id_tahun_akademik')
		    ->from($this->_table.' tp')
		    ->join('tb_program_studi prodi','prodi.id_program_studi = tp.id_program_studi')
		    ->join('tb_waktu tw','tw.id_tahun_akademik = tp.id_tahun_akademik');
    	if($idProdi){
    		$this->db->where("prodi.id_program_studi = $idProdi");
	    }
        return $this->db->get()->result();
    }

    public function getById($id = null){
        return $this->db->get_where($this->_table,[$this->_primary_key=>$id])->row();
    }

    public function insert(){
	    $statusInsert = false;
    	$get_level = masterdata( 'tb_master_level','nama_master_level = "peserta"');
    	$akun = new stdClass();
    	$level = new stdClass();
        $post = $this->input->post();
        $this->nimpes = $post['nimpes'];
        $this->id_tahun_akademik = $post['id_tahun_akademik'];
        $this->id_program_studi = $post['id_program_studi'];
        $this->username = $post['nimpes'];
        $this->namapes = $post['namapes'];
        //add parameter here
	    $akun->username = $post['nimpes'];
	    $akun->password = password_hash($post['nimpes'],PASSWORD_DEFAULT);

	    $level->username = $post['nimpes'];
	    $level->id_master_level = $get_level->id_master_level;
	    $this->db->trans_start();
	        $this->db->insert('tb_akun',$akun);
	        $this->db->insert('tb_level',$level);
	        $this->db->insert($this->_table,$this);
	    $this->db->trans_complete();
	    //if status transaction complete, return true
	    if ( $this->db->trans_status() != false ) {
		    $statusInsert = true;
	    }
	    return $statusInsert;
    }

    public function update(){
        $post = $this->input->post();
        $this->nimpes = $post['nimpes'];
        if(isset($post['id_tahun_akademik'])){
            $this->id_tahun_akademik = $post['id_tahun_akademik'];
            $this->id_program_studi = $post['id_program_studi'];
        }
        $this->username = $post['username'];
        $this->namapes = $post['namapes'];
        $this->db->update($this->_table,$this,[$this->_primary_key=>$post['nimpes']]);
    }

    public function delete($id){
        return $this->db->delete($this->_table,[$this->_primary_key=>$id]);
    }

}