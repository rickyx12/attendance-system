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

		$this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('studentPhotoFile')) {

        	$data = array("status" => "error", "message" => $this->upload->display_errors());
        }else {		

			$studentId = $this->input->post('studentId');
			$gradeLevel = $this->input->post('gradeLevel');
			$section = $this->input->post('section');
			$course = $this->input->post('course');
			$schoolYear = $this->input->post('schoolYear');
			$timeIn = $this->input->post('schedTimein');
			$timeOut = $this->input->post('schedTimeout');
			$dateAdded = date("Y-m-d");
			$filename = $this->upload->data()['file_name'];
			$guardian = $this->input->post('guardian');
			$guardianContact = $this->input->post('guardianContact');
			$rfCard = $this->input->post('rfCard');

			if($this->gradelevel_model->getGradeLevelByStudentId(array($studentId,$schoolYear))->num_rows() == 0) {

				if($studentId != "" || $gradeLevel != "" || $section != "" || $schoolYear != "" || $timeIn != "" || $timeOut != "") {

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

					$data = array("status" => "success", "message" => "Records Added.");

				}else {
					$data = array("status" => "error", "message" => "Please Fill up all fields.");
				}
			}else {

				$lastName = $this->utility_model->selectNow('students','last_name','id',$studentId)->row()->last_name;
				$firstName = $this->utility_model->selectNow('students','first_name','id',$studentId)->row()->first_name;
				$sy = $this->utility_model->selectNow('settings_schoolyear','school_year','id',$schoolYear)->row()->school_year;

				$data = array("status" => "error", "message" => $lastName.", ".$firstName." is Already on the list of Enrollment for the S.Y ".$sy);
			}
		}

		echo json_encode($data);
	}



	public function update() {

		$this->isLogged();

        $config['upload_path']          = './uploads/photoID/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 25000;
        $config['max_width']            = 0;
        $config['max_height']           = 0;

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
		$filename = null;

		$filteredTimein  = date("H:i", strtotime($scheduleTimein));
		$filteredTimeout = date("H:i", strtotime($scheduleTimeout));

        if ( ! $this->upload->do_upload('editStudentPhotoFile')) {

			$filename = $this->gradelevel_model->getGradeLevelById(array($gradeLevelId))->row()->photo;
        }else {	       

        	$filename = $this->upload->data()['file_name'];
		}

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
