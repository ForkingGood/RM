<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TShirt extends CI_Controller {

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
		ob_start();
		$mainLayout = file_get_contents('http://localhost:1234/RM/Template/');
		echo $mainLayout;

		$this->load->model('tshirt_model');
		$data['query'] = $this->tshirt_model->get_all();

		$this->load->helper('url');

		$this->load->view('home/tshirt');
		$this->load->view('home/announcements');
	}

	public function add() {

	}
}