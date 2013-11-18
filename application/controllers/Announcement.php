<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcement extends CI_Controller {

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

	public function add() {

		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$title          = trim(strip_tags($_POST['title']));
			$description    = trim(strip_tags($_POST['description']));

			$error = '';
			if ($title == "") {
				$error .= '<div class="info"><b>TITLE : </b> cannot be empty.</div>';
			}
			if ($description == "") {
				$error .= '<div class="info"><b>DESCRIPTION : </b> cannot be empty.</div>';
			}

			if ($error == '') {
				$this->load->model('announcement_model');
				$id = $this->announcement_model->insert(array('title' => $title, 'description' => $description));
				$row = $this->announcement_model->get($id);
				$row->dateCreated = date_format(new datetime($row->dateCreated), 'M d, Y | h:ia');
				echo json_encode($row);
			} else {
				echo $error;
			}
		}
	}

	public function update($id) {
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$title          = trim(strip_tags($_POST['title']));
			$description    = trim(strip_tags($_POST['description']));

			$error = '';
			if ($id == null) {
				$error .= '<div class="info">ERROR: ID could not be received.  Please try again later.</div>';	
			}
			if ($title == "") {
				$error .= '<div class="info"><b>TITLE : </b> cannot be empty.</div>';
			}
			if ($description == "") {
				$error .= '<div class="info"><b>DESCRIPTION : </b> cannot be empty.</div>';
			}

			if ($error == '') {
				$this->load->model('announcement_model');
				$this->announcement_model->edit($id, array('id' => $id, 'title' => $title, 'description' => $description));
				echo 'done';
			} else {
				echo $error;
			}
		}
	}

	public function delete($id) {
		$this->load->model('announcement_model');
		$this->announcement_model->delete($id);
	}
}