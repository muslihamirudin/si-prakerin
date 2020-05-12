<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index()
    {
        $level = $this->session->userdata('level');
        switch($level){
            
            case 'admin':
                redirect(site_url('dashboard'));
            break;

            case 'prakerin':

            break;

            case 'koordinator prodi':
				redirect(site_url('dashboard'));
            break;
            
            case 'akademik':

            break;

            case 'mahasiswa' and 'dosen' and 'peserta':
                redirect(site_url('user'));
            break;

            case 'pembimbing lapangan':

            break;
            
            default: redirect(site_url('blog/home'));
        }
    }

}

/* End of file Main.php */
 ?>
