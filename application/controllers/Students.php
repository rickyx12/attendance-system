<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('students_model');
 		$this->load->model('settings_model');
        $this->load->model('course_model');
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
			'gradeLevel' => $this->settings_model->getGradeLevel(null,null,null)->result(),
            'schoolYear' => $this->settings_model->getSchoolYear(null,null,null)->result(),
            'courses' => $this->course_model->getCourse(null,null,null)->result()
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
        $birthdate = $this->input->post('birthdate');
        $gender = $this->input->post('gender');

		if($lastName != "" || $firstName != "" || $middleName != "") {

			$checkRecord = $this->students_model->getStudentByName(array($lastName,$firstName,$middleName))->num_rows();

			if($checkRecord < 1) {

				$data = array(
					$lastName,
					$firstName,
					$middleName,
                    $birthdate,
                    $gender
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
        $birthdate = $this->input->post('birthdate');
        $gender = $this->input->post('gender');
		$id = $this->input->post('id');

		if($lastName != "" || $firstName != "" || $middleName != "") {

				$data = array(
					$lastName,
					$firstName,
					$middleName,
                    $birthdate,
                    $gender,
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

    		array_push($resArray,array("id" => $student->id, "text" => $student->name));

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

    		array_push($resArray,array("id" => $student->id, "text" => $student->name." (".$student->section." - ".$student->grade_level.")"));

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
        $schoolYear = $this->input->get('schoolYear');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->students_model->getStudentsPerGradeLevel(null,null,null,$gradeLevel,$schoolYear)->num_rows(),
            "recordsFiltered" => $this->students_model->getStudentsPerGradeLevel(null,null,null,$gradeLevel,$schoolYear)->num_rows(),
            "data" => $this->students_model->getStudentsPerGradeLevel($start,$length,$search,$gradeLevel,$schoolYear)->result()
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
        $schoolYear = $this->input->get('schoolYear');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->students_model->getStudentsPerSection(null,null,null,$section,$schoolYear)->num_rows(),
            "recordsFiltered" => $this->students_model->getStudentsPerSection(null,null,null,$section,$schoolYear)->num_rows(),
            "data" => $this->students_model->getStudentsPerSection($start,$length,$search,$section,$schoolYear)->result()
        );

        echo json_encode($data);            
    }


    public function studentsPerCourseJSON() {

        $this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $course = $this->input->get('course');
        $schoolYear = $this->input->get('schoolYear');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->students_model->getStudentsPerCourse(null,null,null,$course,$schoolYear)->num_rows(),
            "recordsFiltered" => $this->students_model->getStudentsPerCourse(null,null,null,$course,$schoolYear)->num_rows(),
            "data" => $this->students_model->getStudentsPerCourse($start,$length,$search,$course,$schoolYear)->result()
        );

        echo json_encode($data);            
    }

}
