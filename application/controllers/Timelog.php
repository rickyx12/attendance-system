<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Timelog extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('gradelevel_model');
 		$this->load->model('timelog_model');
 	}

	public function index()
	{

		$this->load->view('timelog/index');
	}


	private function sendSMS($cpNumber,$message) {

		//Initialize cURL.
		$ch = curl_init();
		 
		//Set the URL that you want to GET by using the CURLOPT_URL option.
		curl_setopt($ch, CURLOPT_URL, $this->config->item('sms_gateway').'action_page?cpNumber='.$cpNumber.'&message='.$message);
		 
		//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		 
		//Execute the request.
		$data = curl_exec($ch);
		 
		//Close the cURL handle.
		curl_close($ch);
		 
		//Print the data out onto the page.
		return $data;
	}

	public function timeIn() {

		$identifierTag = $this->input->post('identifierTag');
		$student = $this->gradelevel_model->getGradeLevelByIdentifierTag(array($identifierTag))->row();
		$type = null;
		$typeMessage = null;

		if($student) {

			if(
				$this->timelog_model->checkTimein(array($student->gradeLevelId,date('Y-m-d')))->num_rows() < 1 ||
				$this->timelog_model->checkTimein(array($student->gradeLevelId,date('Y-m-d')))->row()->type == 'out'
			) {
				$type = 'in';
				$typeMessage = 'IN';
			}else {
				$type = 'out';
				$typeMessage = 'OUT';
			}


			$timeFrontEnd = date('h:i A');
			$timeBackEnd = date('H:i');
			$dateBackend = date('Y-m-d');
			$dateFrontend = date('M d, Y');


			$message = $this->config->item('sms_header')."\n"..$student->last_name.", ".$student->first_name." \n".$typeMessage.": ".$timeFrontEnd." \n".$dateFrontend;

			$cpNumber = urlencode($student->guardian_contact);
			$message = urlencode($message);			

			// $this->sendSMS($cpNumber,$message);

			$tapData = array(
				$student->gradeLevelId,
				$type,
				$timeBackEnd,
				$dateBackend
			);

			$this->timelog_model->create($tapData);

			// $url = 'http://192.168.0.92/action_page?cpNumber='.$cpNumber.'&message='.$message;
			// $contents = file_get_contents($url);

			if($this->sendSMS($cpNumber,$message) != "") {

				$data = array(
					'status' => 'success', 
					'student' => $student->last_name.", ".$student->first_name,
					'photo' => $student->photo,
					'fetcher' => $student->fetcher, 
					'tap' => $typeMessage,
					'time' => $timeFrontEnd, 
					'date' => $dateFrontend
				);
			}else {
				$data = array('status' => 'error', 'message' => 'SMS Error.');
			}

		}else {

			$data = array('status' => 'error', 'message' => 'Record not found.');
		}

		echo json_encode($data);
	}
}
