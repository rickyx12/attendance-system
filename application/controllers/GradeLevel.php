<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GradeLevel extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('gradelevel_model');
 		$this->load->model('utility_model');
 		$this->load->library('session');
 	}

    private function isLogged() {

        if(!$this->session->has_userdata('id')) {
                redirect('Account/login');
        }
    }

	public function create() {

		$this->isLogged();

        $config['upload_path']          = './uploads/photoID/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 25000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']			= TRUE;

		$this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('studentPhotoFile')) {

        	$data = array("status" => "error", "message" => $this->upload->display_errors());
        }else {		


	        //store the file info
	        $image_data = $this->upload->data();
	        $config['image_library'] = 'gd2';
	        $config['source_image'] = $image_data['full_path']; //get original image
	        $config['maintain_ratio'] = TRUE;
	        $config['rotation_angle'] = abs($this->input->post('imageOrientation'));//counter-clockwise angle of rotation
	        $this->load->library('image_lib', $config);

	        if(!$this->image_lib->rotate()) {
	        	echo $this->image_lib->display_errors();
	        }  
 

			$studentId = $this->input->post('studentId');
			$gradeLevel = $this->input->post('gradeLevel');
			$section = $this->input->post('section');

			if($this->input->post('course') != "") {
				$course = $this->input->post('course');
			}else {
				$course = 7;
			}

			$schoolYear = $this->input->post('schoolYear');
			$timeIn = $this->input->post('schedTimein');
			$timeOut = $this->input->post('schedTimeout');
			$dateAdded = date("Y-m-d");
			$filename = $this->upload->data()['file_name'];
			$guardian = $this->input->post('guardian');
			$guardianContact = $this->input->post('guardianContact');
			$rfCard = $this->input->post('rfCard');
			$imageOrientation = $this->input->post('imageOrientation');

			if($this->gradelevel_model->getGradeLevelByStudentId(array($studentId,$schoolYear))->num_rows() == 0) {

				if($this->gradelevel_model->getGradeLevelByIdentifierTag($rfCard)->num_rows() == 0) {
					if($studentId != "" && $gradeLevel != "" && $section != "" && $section != "null" && $schoolYear != "" && $timeIn != "" && $timeOut != "") {

						$filteredTimein  = date("H:i", strtotime($timeIn));
						$filteredTimeout = date("H:i", strtotime($timeOut));	

						$data = array(
							$studentId,
							$gradeLevel,
							$section,
							$course,
							$schoolYear,
							$filteredTimein,
							$filteredTimeout,
							$filename,
							$guardian,
							$guardianContact,
							$rfCard,
							$dateAdded
						);

						$this->gradelevel_model->create($data);

						$data = array("status" => "success", "message" => "Records Added.", 'imageOrientation' => $imageOrientation);

					}else {
						$data = array("status" => "error", "message" => "Please Fill up all fields.");
					}
				}else {

					$data = array("status" => "error", "message" => "RF Card already assigned to other student.");
				}
			}else {

				$lastName = $this->utility_model->selectNow('students','last_name','id',$studentId)->row()->last_name;
				$firstName = $this->utility_model->selectNow('students','first_name','id',$studentId)->row()->first_name;
				$sy = $this->utility_model->selectNow('settings_schoolyear','school_year','id',$schoolYear)->row()->school_year;

				$data = array("status" => "error", "message" => $lastName.", ".$firstName." is Already on the list of Enrollment for the S.Y ".$sy);
			}
		}

		// $this->correctImageOrientation('./uploads/photoID/'.$this->upload->data()['file_name']);
		echo json_encode($data);
	}


	public function update() {

		$this->isLogged();

        $config['upload_path']          = './uploads/photoID/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 25000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']			= TRUE;

        $this->load->library('upload', $config);

		$gradeLevelId = $this->input->post('gradeLevelId');
		$gradeLevel = $this->input->post('gradeLevel');
		$section = $this->input->post('section');
		$course = $this->input->post('course');
		$scheduleTimein = $this->input->post('scheduleTimein');
		$scheduleTimeout = $this->input->post('scheduleTimeout');
		$schoolYear = $this->input->post('schoolYear');
		$guardian = $this->input->post('guardian');
		$guardianContact = $this->input->post('guardianContact');
		$rfCard = $this->input->post('rfCard');
		$imageOrientation = $this->input->post("imageOrientation");
		$filename = null;

		$filteredTimein  = date("H:i", strtotime($scheduleTimein));
		$filteredTimeout = date("H:i", strtotime($scheduleTimeout));

        if ( ! $this->upload->do_upload('editStudentPhotoFile')) {

			$filename = $this->gradelevel_model->getGradeLevelById(array($gradeLevelId))->row()->photo;
        }else {	       

        	$filename = $this->upload->data()['file_name'];
		}

		if(
			$this->gradelevel_model->getGradeLevelByIdentifierTag($rfCard)->num_rows() == 0 ||
			($this->gradelevel_model->getGradeLevelByIdentifierTag($rfCard)->row()->gradeLevelId == $gradeLevelId)
		) {

			if($gradeLevel != "" || $scheduleTimein != "" || $scheduleTimeout != "" || $schoolYear != "") {

				$data = array(
					$gradeLevel,
					$section,
					$course,
					$schoolYear,
					$filteredTimein,
					$filteredTimeout,
					$filename,
					$guardian,
					$guardianContact,
					$rfCard,
					$gradeLevelId
				);

				$this->gradelevel_model->update($data);
			
				$data = array("status" => "success", "message" => "Successfully Updated.");
			}else {

				$data = array("status" => "error", "message" => "Please fill up all fields.");
			}

		}else {

			$data = array("status" => "error", "message" => "RF Card already assigned to other student.");
		}

		echo json_encode($data);
	}


	public function updateFetcher() {

		$this->isLogged();

        $config['upload_path']          = './uploads/fetcher/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 25000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;

        $this->load->library('upload', $config);

		$gradeLevelId = $this->input->post('gradeLevelId');
		$filename = null;

        if ( ! $this->upload->do_upload('fetcherPhotoFile')) {

			$filename = $this->gradelevel_model->getGradeLevelById(array($gradeLevelId))->row()->fetcher;
        }else {	       

        	$filename = $this->upload->data()['file_name'];
		}

		$data = array(
			$filename,
			$gradeLevelId
		);

		$this->gradelevel_model->updateFetcher($data);

		$data = array("status" => "success", "message" => "Fetcher Photo successfully updated.");

		echo json_encode($data);
	}

	public function delete() {

		$this->isLogged();

		$id = $this->input->post('id');

		$this->gradelevel_model->delete(array($id));

		$data = array("status" => "success", "message" => "Successfully Deleted.");
		echo json_encode($data);
	}

    public function gradeLevelJSON() {

        // $this->isLoggedIn();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $year = $this->input->get('schoolYear');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->gradelevel_model->getEnrollees(null,null,null,$year)->num_rows(),
            "recordsFiltered" => $this->gradelevel_model->getEnrollees(null,null,null,$year)->num_rows(),
            "data" => $this->gradelevel_model->getEnrollees($start,$length,$search,$year)->result()
        );

        echo json_encode($data);            
    }


}
