<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template extends CI_Controller {

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
		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$data['role'] = $session_data['role'];

		$this->load->view('template/oHead');							//	Open Head tag
		//	Add headers here
		$this->load->view('template/Includes');							//	Set includes libraries
		$this->load->view('template/cHead_oBody');						//	Close Head tag, and Open Body tag
		$this->load->view('template/TopBanner', $data);						//	Set top banner
		$this->load->view('template/Playlist');							//	Set playlist
		$this->load->view('template/Submit');							//	Set submit form
		$this->load->view('template/Intro');							//	Set intro instruction displays, which only show if 'firstTime' cookie is not set
		//	Add content here
		$this->load->view('template/cBody');							//	Close Body tag
	}

	public function admin()
	{

		$session_data = $this->session->userdata('logged_in');
		$data['username'] = $session_data['username'];
		$this->load->view('template/oHead');							//	Open Head tag
		//	Add headers here
		$this->load->view('template/Includes');							//	Set includes libraries
		$this->load->view('template/cHead_oBody');						//	Close Head tag, and Open Body tag
		$this->load->view('template/AdminTopBanner', $data);			//	Set top banner

		//	Add content here
		$this->load->view('template/cBody');							//	Close Body tag
	}
}

/* End of file template.php */
/* Location: ./application/controllers/template.php */