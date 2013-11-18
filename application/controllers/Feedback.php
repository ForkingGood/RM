<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends CI_Controller {

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
		$mainLayout = file_get_contents(base_url().'Template/');
		echo $mainLayout;

		$this->load->model('tshirt_model');
		$data['query'] = $this->tshirt_model->get_all();

		$this->load->view('home/tshirt');
		$this->load->view('home/announcements');
	}

	public function add() {

		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			// From Form
			$submissionType = trim(strip_tags($_POST['uploadSubmissionType']));
			$title          = trim(strip_tags($_POST['uploadTitle']));
			$Series         = trim(strip_tags($_POST['uploadSeries']));
			$feedbackType   = trim(strip_tags($_POST['uploadType']));
			$description    = trim(strip_tags($_POST['uploadDescription']));
			$summonerName   = trim(strip_tags($_POST['uploadSummonerName']));
			$startTimeMin   = trim(strip_tags($_POST['uploadStartTimeMin']));
			$startTimeSec   = trim(strip_tags($_POST['uploadStartTimeSec']));
			$endTimeMin     = trim(strip_tags($_POST['uploadEndTimeMin']));
			$endTimeSec     = trim(strip_tags($_POST['uploadEndTimeSec']));

			$error = '';
			
			if ($title == "") {
				$error .= '<br clear="all"><div class="info">Please enter a title in the <b>TITLE</b> field to proceed. Thanks.</div>';	
			}
			if ($description == "") {
				$error .= '<br clear="all"><div class="info">Please enter a description in the <b>DESCRIPTION</b> field to proceed. Thanks.</div>';	
			}
			else if ($summonerName == "") {
				$error .= '<br clear="all"><div class="info">Please enter your summoner name in the <b>SUMMONER NAME</b> field to proceed. Thanks.</div>';	
			}

			if ($error != '') {
				echo $error;
			} else {
				$this->load->model('feedback_model');
				$this->feedback_model->insert(array(
												'type' => $feedbackType,
												'title' => $title,
												'description' => $description, 
												'summonerName' => $summonerName
											));
				// Return msg
			    $vpb_sent = '<font style="font-size:0px;">vpb_sent&</font>';
			    $vpb_sent_status = "<br clear='all' /><div align='left' class='info'>Congrats, your T-shirt has been uploaded successfully! Thanks.</div>";
			    echo $vpb_sent.$vpb_sent_status;
			}
		}
	}

	public function ToggleViewed($id) {
		$this->load->model('feedback_model');
		//	Get row
		$obj = $this->feedback_model->get($id);
		//	Set update
		$state = !$obj->viewed;
		if (isset($_POST['state'])) {
			$state = $_POST['state'];
		}
		//	Send update
		$obj->viewed = $state;
		$this->feedback_model->edit($id, $obj);
		//	Show MSG
		echo $state ? 'done' : 'failed';
	}

	public function delete($id) {
		$this->load->model('feedback_model');
		$this->feedback_model->delete($id);
	}
}