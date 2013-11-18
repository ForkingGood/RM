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
			$allowedExtensions = array("jpg","jpeg", "gif","png");
			// Obtain file upload vars
			$attachment_file      = $_FILES['attachment_file']['tmp_name'];
			$attachment_file_type = $_FILES['attachment_file']['type'];
			$attachment_file_name = $_FILES['attachment_file']['name'];
			$attachment_file_size = $_FILES['attachment_file']['size'];
			if (!isset($_FILES["attachment_file"]) || $_FILES['attachment_file']['name'] == "" || !in_array(strtolower(pathinfo($attachment_file_name, PATHINFO_EXTENSION)), $allowedExtensions)) {
				$error .= '<br clear="all"><div class="info">Please select an image file in the <b>FILE</b> field to proceed. Thanks.</div>';
			}
			else if ($description == "") {
				$error .= '<br clear="all"><div class="info">Please enter a description in the <b>DESCRIPTION</b> field to proceed. Thanks.</div>';	
			}
			else if ($summonerName == "") {
				$error .= '<br clear="all"><div class="info">Please enter your summoner name in the <b>SUMMONER NAME</b> field to proceed. Thanks.</div>';	
			}

			if ($error != '') {
				echo $error;
			} else {

				// Store in file system
				$location = 'asset/uploads/T-shirts/';
				$fileName = pathinfo($attachment_file_name, PATHINFO_FILENAME);
				$fileExtension = pathinfo($attachment_file_name, PATHINFO_EXTENSION);
				//		generate filename that is not used
				$tmpName = $fileName;
				for ($i = 1; file_exists($location.$tmpName.'.'.$fileExtension); $i++) {
					$tmpName = $fileName.'('.$i.')';
				}
				$fileName = $tmpName;
				//		push file to file system with new generated name
				if (move_uploaded_file($attachment_file, $location.$fileName.'.'.$fileExtension)) {

					// Store in db
					$this->load->model('tshirt_model');
					$this->tshirt_model->insert(array(
													'summonerName' => $summonerName, 
													'description' => $description, 
													'imgPath' => $fileName.'.'.$fileExtension
												));

					// Return msg
				    $vpb_sent = '<font style="font-size:0px;">vpb_sent&</font>';
				    $vpb_sent_status = "<br clear='all' /><div align='left' class='info'>Congrats, your T-shirt has been uploaded successfully! Thanks.</div>";
				    echo $vpb_sent.$vpb_sent_status;
				} else {
					// pushing to filesystem failed
					echo "<br clear='all' /><div align='left' class='info'>The file did not successfully save, please try again later.</div>";
				}

			}
		}
	}

	public function ToggleViewed($id) {
		$this->load->model('tshirt_model');
		//	Get row
		$obj = $this->tshirt_model->get($id);
		//	Set update
		$state = !$obj->viewed;
		if (isset($_POST['state'])) {
			$state = $_POST['state'];
		}
		//	Send update
		$obj->viewed = $state;
		$this->tshirt_model->edit($id, $obj);
		//	Show MSG
		echo $state ? 'done' : 'failed';
	}
	
	public function ToggleShow($id) {
		$this->load->model('tshirt_model');
		//	Get row
		$obj = $this->tshirt_model->get($id);
		//	Set update
		$state = !$obj->showTShirt;
		if (isset($_POST['state'])) {
			$state = $_POST['state'];
		}
		//	Send update
		$obj->showTShirt = $state;
		$this->tshirt_model->edit($id, $obj);
		//	Show MSG
		echo $state ? 'show' : 'don\'t show';
	}

	public function delete($id) {
		$this->load->model('tshirt_model');
		//	Delete physical file
		$row = $this->tshirt_model->get($id);
		unlink('asset/uploads/T-shirts/'.$row->imgPath);
		//	Delete in db
		$this->tshirt_model->delete($id);
		echo "Done";
	}
}