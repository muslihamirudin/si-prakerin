<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Seminarpeserta extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('seminar_model');
		$this->load->helper('master');
		$this->load->library('form_validation');
		! $this->session->userdata( 'level' ) ? redirect( site_url( 'main' ) ) : null;
	}

	public function index()
	{
       $data['sempes'] = $this->seminar_model->get_jadwal_sempes();
       $this->load->view('user/seminar_peserta', $data);
	}
}