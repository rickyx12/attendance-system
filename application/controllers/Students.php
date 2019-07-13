<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('students_model');
 		$this->load->model('settings_model');
 		$this->load->model('gradelevel_model');
 		$this->load->library('session');
 	}


    private function isLogged() {

        if(!$this->session->has_userdata('id')) {
                redirect('Account/login');
        }
    }

	public function index()
	{

		$this->isLogged();

		$data = array(
			'page' => 'students-page',
			'gradeLevel' => $this->settings_model->getGradeLevel(null,null,null)->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('students/index');
		$this->load->view('includes/footer');
	}

	public function create() {

		$this->isLogged();

		$lastName = $this->input->post('lastName');
		$firstName = $this->input->post('firstName');
		$middleName = $this->input->post('middleName');


		if($lastName != "" || $firstName != "" || $middleName != "") {

			$checkRecord = $this->students_model->getStudentByName(array($lastName,$firstName,$middleName))->num_rows();

			if($checkRecord < 1) {

				$data = array(
					$lastName,
					$firstName,
					$middleName
				);

				$this->students_model->create($data);

				$data = array('status' => 'success', 'message' => 'Successfully Added.');
			}else {

				$data = array('status' => 'error', 'message' => 'Student already exist');	
			}

		}else {

			$data = array('status' => 'error', 'message' => 'Please fillup all fields.');
		}

		echo json_encode($data);
	}


	public function update() {

		$this->isLogged();

		$lastName = $this->input->post('lastName');
		$firstName = $this->input->post('firstName');
		$middleName = $this->input->post('middleName');
		$gradeLevel = $this->input->post('gradeLevel');
		$id = $this->input->post('id');


		if($lastName != "" || $firstName != "" || $middleName != "") {

				$data = array(
					$lastName,
					$firstName,
					$middleName,
					$id
				);

				$this->students_model->update($data);

				$data = array('status' => 'success', 'message' => 'Successfully Updated.');

		}else {

			$data = array('status' => 'error', 'message' => 'Please fillup all fields.');
		}

		echo json_encode($data);

	}

	public function delete() {

		$this->isLogged();

		$studentId = $this->input->post('studentId');

		$this->students_model->delete($studentId);

		$data = array('status' => 'success', 'message' => 'Successfully Deleted.');

		echo json_encode($data);
	}

    public function studentsJSON() {

        $this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->students_model->getStudents(null,null,null)->num_rows(),
            "recordsFiltered" => $this->students_model->getStudents(null,null,null)->num_rows(),
            "data" => $this->students_model->getStudents($start,$length,$search)->result()
        );

        echo json_encode($data);            
    }

    public function searchViaSelect2() {

    	$this->isLogged();

    	$term = $this->input->get('term');
    	$type = $this->input->get('type');
    	$q = $this->input->get('q');
    	$resArray = [];

    	$students = $this->students_model->searchStudent($term)->result();

    	foreach($students as $student) {

    		array_push($resArray,array("id" => $student->id, "text" => $student->last_name.", ".$student->first_name." ".$student->middle_name));

    	}
    

    	echo json_encode(array("results" => $resArray));

    }


    public function searchGradelevelStudentSelect2() {

    	$this->isLogged();

    	$term = $this->input->get('term');
    	$type = $this->input->get('type');
    	$q = $this->input->get('q');
    	$resArray = [];

    	$students = $this->gradelevel_model->searchStudent($term)->result();

    	foreach($students as $student) {

    		array_push($resArray,array("id" => $student->id, "text" => $student->last_name.", ".$student->first_name." ".$student->middle_name." (".$student->section." - ".$student->grade_level.")"));

    	}
    

    	echo json_encode(array("results" => $resArray));

    }

    public function studentsPerGradeLevelJSON() {

        $this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $gradeLevel = $this->input->get('gradeLevel');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->students_model->getStudentsPerGradeLevel(null,null,null,$gradeLevel)->num_rows(),
            "recordsFiltered" => $this->students_model->getStudentsPerGradeLevel(null,null,null,$gradeLevel)->num_rows(),
            "data" => $this->students_model->getStudentsPerGradeLevel($start,$length,$search,$gradeLevel)->result()
        );

        echo json_encode($data);            
    }


    public function studentsPerSectionJSON() {

        $this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $section = $this->input->get('section');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->students_model->getStudentsPerSection(null,null,null,$section)->num_rows(),
            "recordsFiltered" => $this->students_model->getStudentsPerSection(null,null,null,$section)->num_rows(),
            "data" => $this->students_model->getStudentsPerSection($start,$length,$search,$section)->result()
        );

        echo json_encode($data);            
    }


}
