<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video extends CI_Controller {

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

		$this->load->model('video_model');
		$data['query'] = $this->video_model->get_all();

		$this->load->view('home/tshirt');
		$this->load->view('home/announcements');
	}

	public function add() {

		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			// From Form
			$submissionType = trim(strip_tags($_POST['uploadSubmissionType']));
			$title          = trim(strip_tags($_POST['uploadTitle']));
			$series         = trim(strip_tags($_POST['uploadSeries']));
			$feedbackType   = trim(strip_tags($_POST['uploadType']));
			$description    = trim(strip_tags($_POST['uploadDescription']));
			$summonerName   = trim(strip_tags($_POST['uploadSummonerName']));
			$startTimeMin   = trim(strip_tags($_POST['uploadStartTimeMin']));
			$startTimeSec   = trim(strip_tags($_POST['uploadStartTimeSec']));
			$endTimeMin     = trim(strip_tags($_POST['uploadEndTimeMin']));
			$endTimeSec     = trim(strip_tags($_POST['uploadEndTimeSec']));

echo "ST -> ".$startTimeMin.":".$startTimeSec."   ET -> ".$endTimeMin.":".$endTimeSec;

			$error = '';
			$allowedExtensions = array("lrf");
			// Obtain file upload vars
			$attachment_file      = $_FILES['attachment_file']['tmp_name'];
			$attachment_file_type = $_FILES['attachment_file']['type'];
			$attachment_file_name = $_FILES['attachment_file']['name'];
			$attachment_file_size = $_FILES['attachment_file']['size'];
			if (!isset($_FILES["attachment_file"]) || $_FILES['attachment_file']['name'] == "") {//} || !in_array(strtolower(pathinfo($attachment_file_name, PATHINFO_EXTENSION)), $allowedExtensions)) {
				$error .= '<br clear="all"><div class="info">Please select an lrf file in the <b>FILE</b> field to proceed. Thanks.</div>';
			}
			else if ($title == "") {
				$error .= '<br clear="all"><div class="info">Please enter a title in the <b>TITLE</b> field to proceed. Thanks.</div>';	
			}
			else if ($series == "") {
				$error .= '<br clear="all"><div class="info">Please enter series in the <b>SERIES</b> field to proceed. Thanks.</div>';		
			}
			else if ($description == "") {
				$error .= '<br clear="all"><div class="info">Please enter a description in the <b>DESCRIPTION</b> field to proceed. Thanks.</div>';	
			}
			else if ($summonerName == "") {
				$error .= '<br clear="all"><div class="info">Please enter your summoner name in the <b>SUMMONER NAME</b> field to proceed. Thanks.</div>';	
			}
			else if (!preg_match("/^[0-9]+$/", $startTimeMin) || !preg_match("/^[0-9]+$/", $startTimeSec) || $startTimeSec > 59) {
				$error .= '<br clear="all"><div class="info">Please enter a valid start time in the <b>START TIME</b> field to proceed. Thanks.</div>';		
			}
			else if (!preg_match("/^[0-9]+$/", $endTimeMin) || !preg_match("/^[0-9]+$/", $endTimeSec) || $endTimeSec > 59) {
				$error .= '<br clear="all"><div class="info">Please enter a valid end time in the <b>END TIME</b> field to proceed. Thanks.</div>';
			}
			else if (($endTimeMin * 60 + $endTimeSec) <= ($startTimeMin * 60 + $startTimeSec)) {
				$error .= '<br clear="all"><div class="info">Please enter a valid end time that is bigger than start time in the <b>END TIME</b> field to proceed. Thanks.</div>';	
			}

			if ($error != '') {
				echo $error;
			} else {

				// Store in file system
				$location = 'asset/uploads/Videos/';
				$fileName = pathinfo($attachment_file_name, PATHINFO_FILENAME);
				$fileExtension = pathinfo($attachment_file_name, PATHINFO_EXTENSION);
				//		generate filename that is not used
				$tmpName = $fileName;
				for ($i = 1; file_exists($location.$tmpName.'.'.$fileExtension); $i++) {
					$tmpName = $fileName.'('.$i.')';
				}
				$fileName = $tmpName;
				//		push file to file system with new generated name
				echo $location.$fileName.'.'.$fileExtension;
				if (move_uploaded_file($attachment_file, $location.$fileName.'.'.$fileExtension)) {

					// Store in db
					$this->load->model('video_model');
					$this->video_model->insert(array(
													'title' => $title,
													'series' => $series,
													'description' => $description, 
													'summonerName' => $summonerName,
													'startTime' => $startTimeMin.':'.$startTimeSec,
													'endTime' => $endTimeMin.':'.$endTimeSec,
													'vidPath' => $fileName.'.'.$fileExtension
												));

					// Return msg
				    $vpb_sent = '<font style="font-size:0px;">vpb_sent&</font>';
				    $vpb_sent_status = "<br clear='all' /><div align='left' class='info'>Congrats, your video has been uploaded successfully! Thanks.</div>";
				    echo $vpb_sent.$vpb_sent_status;
				} else {
					// pushing to filesystem failed
					echo "<br clear='all' /><div align='left' class='info'>The file did not successfully save, please try again later.</div>";
				}

			}
		}
	}

	public function ToggleViewed($id) {
		$this->load->model('video_model');
		//	Get row
		$obj = $this->video_model->get($id);
		//	Set update
		$state = !$obj->viewed;
		if (isset($_POST['state'])) {
			$state = $_POST['state'];
		}
		//	Send update
		$obj->viewed = $state;
		$this->video_model->edit($id, $obj);
		//	Show MSG
		echo $state ? 'viewed' : 'notViewed';
	}

	public function delete($id) {
		$this->load->model('video_model');
		//	Delete physical file
		$row = $this->video_model->get($id);
		unlink('asset/uploads/Videos/'.$row->vidPath);
		//	Delete in db
		$this->video_model->delete($id);
		echo "Done";
	}
}