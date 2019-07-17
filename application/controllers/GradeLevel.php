<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GradeLevel extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('gradelevel_model');
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
			$schoolYear = $this->input->post('schoolYear');
			$timeIn = $this->input->post('schedTimein');
			$timeOut = $this->input->post('schedTimeout');
			$dateAdded = date("Y-m-d");
			$filename = $this->upload->data()['file_name'];
			$guardian = $this->input->post('guardian');
			$guardianContact = $this->input->post('guardianContact');
			$rfCard = $this->input->post('rfCard');


			if($studentId != "" || $gradeLevel != "" || $section != "" || $schoolYear != "" || $timeIn != "" || $timeOut != "") {

				$filteredTimein  = date("H:i", strtotime($timeIn));
				$filteredTimeout = date("H:i", strtotime($timeOut));	

				$data = array(
					$studentId,
					$gradeLevel,
					$section,
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
