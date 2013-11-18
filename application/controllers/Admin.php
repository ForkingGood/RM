<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in') || $this->session->userdata('logged_in')['role'] != 'admin')
		{
	     //If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}
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

		$template['content'] =   "<style>".
									"h1.mainHeading {".
										"color: white; text-align: center; font-size: 17pt; margin: 0;".
									"}".
								 "</style>";

		// echo "<h1 class='mainHeading'>T-shirts</h1>";

		// Show all !viewed
		$this->load->model('tshirt_model');
		$data['query'] = $this->tshirt_model->get_all(array('viewed' => false));
		$template['content'] .= $this->load->view('admin/tshirts', $data, true);

		$template['content'] .= "<br clear='all'><br />";//<h1 class='mainHeading'>Videos</h1>";

		$this->load->model('video_model');
		$data['query'] = $this->video_model->get_all(array('viewed' => false));
		$template['content'] .= $this->load->view('admin/videos', $data, true);	

		// echo "<br clear='all'><br /><br /><br /><h1 class='mainHeading'>Feedbacks</h1>";

		$this->load->model('feedback_model');
		$data['query'] = $this->feedback_model->get_all(array('viewed' => false));
		$template['content'] .= $this->load->view('admin/feedbacks', $data, true);

		// MASTER PAGE
		$session_data = $this->session->userdata('logged_in');
		$template['login'] = $session_data;
		$template['menu'] = $this->load->view('template/menuAdmin', null, true);
		$this->load->view('template/mainTemplate', $template);
	}

	public function TShirts() 
	{
		// CONTENT
		$this->load->model('tshirt_model');
		$data['query'] = $this->tshirt_model->get_all(null);
		$template['content'] = $this->load->view('admin/tshirts', $data, true);

		// MASTER PAGE
		$session_data = $this->session->userdata('logged_in');
		$template['login'] = $session_data;
		$template['menu'] = $this->load->view('template/menuAdmin', null, true);
		$this->load->view('template/mainTemplate', $template);
	}

	public function Videos() 
	{
		// CONTENT
		$this->load->model('video_model');
		$data['query'] = $this->video_model->get_all(null);		
		$template['content'] = $this->load->view('admin/videos', $data, true);	

		// MASTER PAGE
		$session_data = $this->session->userdata('logged_in');
		$template['login'] = $session_data;
		$template['menu'] = $this->load->view('template/menuAdmin', null, true);
		$this->load->view('template/mainTemplate', $template);
	}

	public function Announcements() 
	{
		// CONTENT
		$this->load->model('announcement_model');
		$data['query'] = $this->announcement_model->get_all(null);
		$template['content'] = $this->load->view('admin/announcements', $data);	

		// MASTER PAGE
		$session_data = $this->session->userdata('logged_in');
		$template['login'] = $session_data;
		$template['menu'] = $this->load->view('template/menuAdmin', null, true);
		$this->load->view('template/mainTemplate', $template);
	}

	public function FeedBacks()
	{
		// CONTENT
		$this->load->model('feedback_model');
		$data['query'] = $this->feedback_model->get_all(null);
		$template['content'] = $this->load->view('admin/feedbacks', $data);

		// MASTER PAGE
		$session_data = $this->session->userdata('logged_in');
		$template['login'] = $session_data;
		$template['menu'] = $this->load->view('template/menuAdmin', null, true);
		$this->load->view('template/mainTemplate', $template);
	}

	function logout()
	{
		session_start(); 
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('/', 'refresh');
	}
}