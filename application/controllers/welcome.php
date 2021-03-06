<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('template/oHead');
		//	Add headers here
		$this->load->view('template/cHead_oBody');
		$this->load->view('template/dHeader');
		// Contents
		$this->load->view('template/dPlaylist');
		$this->load->view('template/dSubmit');
		if (!isset($_COOKIE['firstTime'])) {
			//$this->load->view('template/dIntro');
		}
		setcookie('firstTime', date("Y-m-d H:i:s"), time() + 7200);
		//	Add content here
		$this->load->view('template/cBody');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */