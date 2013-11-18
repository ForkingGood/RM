<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->model('tshirt_model');
		$tshirt_Data['query'] = $this->tshirt_model->get_all(array('showTShirt' => true));

		$this->load->model('announcement_model');
		$announcement_Data['query'] = $this->announcement_model->get_all(null, 4);


		$this->load->helper('url');

		$home['tshirt'] = $this->load->view('tshirt/autoGrid', $tshirt_Data, true);
		$home['announcement'] = $this->load->view('announcement/list', $announcement_Data, true);
		$home['recentVideo'] = $this->load->view('youtube/recentVideo', null, true);
		// $template['content'] = $this->load->view('tshirt/joinUs', null, true);
		$template['content'] = $this->load->view('home/index', $home, true);
		$template['content'] .= $this->load->view('template/Submit', null, true);
		$template['content'] .= $this->load->view('template/Playlist', null, true);

		// MASTER PAGE
		$session_data = $this->session->userdata('logged_in');
		$template['login'] = $session_data;
		$template['menu'] = $this->load->view('template/menuPublic', null, true);
		if (!isset($_COOKIE['firstTime'])) {
			$template['content'] .= $this->load->view('template/Intro', null, true);			
		}
		$this->load->view('template/mainTemplate', $template);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */