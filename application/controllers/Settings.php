<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('settings_model');
 		$this->load->model('course_model');
 		$this->load->model('timelog_model');
 		$this->load->model('account_model');
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
			'page' => 'settings-page',
			'isAdmin' => $this->account_model->getUser($this->session->id)->row()->admin
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/index');
		$this->load->view('includes/footer');
	}

	public function gradeLevel() {

		$this->isLogged();

		$data = array('page' => 'settings-page');

		$this->load->view('includes/header',$data);
		$this->load->view('settings/gradeLevel/index');
		$this->load->view('includes/footer');		
	}

	public function createGradeLevel() {

		$this->isLogged();

		$gradeLevel = $this->input->post('gradeLevel');

		if($gradeLevel != "") {

			$data = array($gradeLevel);
			$this->settings_model->createGradeLevel($data);
			$data = array('status' => 'success','message' => 'Successfully Added.');
		} else {

			$data = array('status' => 'error','message' => 'Please Fill out the field.');
		}
	
		echo json_encode($data);
	}

	public function updateGradeLevel() {

		$this->isLogged();

		$gradeLevelId = $this->input->post('gradeLevelId');
		$gradeLevel = $this->input->post('gradeLevel');

		if($gradeLevel != "") {

			$data = array(
				$gradeLevel,
				$gradeLevelId
			);

			$this->settings_model->updateGradeLevel($data);

			$data = array('status' => 'success', 'message' => 'Successfully Updated.');
		}else {

			$data = array('status' => 'error', 'message' => 'Please Fill out the fields.');
		}

		echo json_encode($data);
	}

	public function deleteGradeLevel() {

		$this->isLogged();

		$gradeLevelId = $this->input->post('gradeLevelId');

		$this->settings_model->deleteGradeLevel(array($gradeLevelId));

		$data = array('status' => 'success', 'message' => 'Successfully Deleted.');

		echo json_encode($data);
	}

    public function gradeLevelJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->settings_model->getGradeLevel(null,null,null)->num_rows(),
            "recordsFiltered" => $this->settings_model->getGradeLevel(null,null,null)->num_rows(),
            "data" => $this->settings_model->getGradeLevel($start,$length,$search)->result()
        );

        echo json_encode($data);            
    }


    public function courseStudents() {

 		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'courses' => $this->course_model->getCourse('','','')->result(),
			'schoolYear' => $this->settings_model->getSchoolYear('','','')->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/course/students/index.php');
		$this->load->view('includes/footer');   	
    }

    public function gradeLevelStudents() {

 		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'gradeLevel' => $this->settings_model->getGradeLevel('','','')->result(),
			'schoolYear' => $this->settings_model->getSchoolYear('','','')->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/gradeLevel/students/index.php');
		$this->load->view('includes/footer');   	
    }

	public function section() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'sections' => $this->settings_model->getGradeLevel(null,null,null)->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/section/index');
		$this->load->view('includes/footer');		
	}

	public function createSection() {

		$this->isLogged();

		$section = $this->input->post('section');
		$gradeLevel = $this->input->post('gradeLevel');

		if($section != "" || $gradeLevel != "") {

			$data = array(
				$section,
				$gradeLevel
			);

			$this->settings_model->createSection($data);

			$data = array('status' => 'success', 'message' => 'Successfully Added.');
		}else {

			$data = array('status' => 'error', 'message' => 'Please Fill out all fields.');
		}

		echo json_encode($data);
	}


	public function updateSection() {

		$this->isLogged();

		$sectionId = $this->input->post('sectionId');
		$section = $this->input->post('section');
		$gradeLevel = $this->input->post('gradeLevel');

		if($section != "" && $gradeLevel != "") {

			$data = array(
				$section,
				$gradeLevel,
				$sectionId
			);

			$this->settings_model->updateSection($data);

			$data = array('status' => 'success', 'message' => 'Successfully Added.');
		}else {

			$data = array('status' => 'error', 'message' => 'Please Fill out all the fields.');
		}

		echo json_encode($data);
	}

	public function deleteSection() {

		$this->isLogged();

		$sectionId = $this->input->post('sectionId');

		$this->settings_model->deleteSection(array($sectionId));

		$data = array('status' => 'success', 'message' => 'Successfully Deleted.');

		echo json_encode($data);
	}

    public function sectionJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->settings_model->getSection(null,null,null)->num_rows(),
            "recordsFiltered" => $this->settings_model->getSection(null,null,null)->num_rows(),
            "data" => $this->settings_model->getSection($start,$length,$search)->result()
        );

        echo json_encode($data);            
    }

    public function sectionByGradeJSON() {

    	$this->isLogged();

    	$gradeLevel = $this->input->post('gradeLevel');

    	$data = array($gradeLevel);

    	$data = $this->settings_model->getSectionByGrade($data)->result();
    	echo json_encode($data);
    }


    public function sectionStudents() {

 		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'sections' => $this->settings_model->getSection('','','')->result(),
			'schoolYear' => $this->settings_model->getSchoolYear('','','')->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/section/students/index.php');
		$this->load->view('includes/footer');   	
    }


	public function lates() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page'
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/lates/index');
		$this->load->view('includes/footer');		
	}    


    public function getLateByDateJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
		$from = $this->input->get('from');
		$to = $this->input->get('to');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->timelog_model->getAllLateByDate(null,null,$from,$to)->num_rows(),
            "recordsFiltered" => $this->timelog_model->getAllLateByDate(null,null,$from,$to)->num_rows(),
            "data" => $this->timelog_model->getAllLateByDate($start,$length,$from,$to)->result()
        );

        echo json_encode($data);            
    }

	public function absences() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page'
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/absent/index');
		$this->load->view('includes/footer');		
	}  

    public function getAbsentByDateJSON() {

        $draw = $this->input->get('draw');
		$from = $this->input->get('from');
		$to = $this->input->get('to');

		$begin = new DateTime($from);
		$end = new DateTime($to);    	

		$dataArr = [];


		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		foreach ($period as $dt) {
		    
		    $result = $this->timelog_model->getAbsentByDate($dt->format("Y-m-d"))->result();

		    foreach($result as $res) {
		    	$data = new stdClass();
		    	$data->last_name = $res->last_name;
		    	$data->first_name = $res->first_name;
		    	$data->section = $res->section;
		    	$data->grade_level = $res->grade_level;
		    	$data->date = $dt->format("Y-m-d");
		    	array_push($dataArr,$data);
		    }
		}

        $data = array(
            "draw" => $draw,
            "recordsTotal" => count($dataArr),
            "recordsFiltered" => count($dataArr),
            "data" => $dataArr
        );

		echo json_encode($data);

    }


	public function attendance() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page'
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/attendance/index');
		$this->load->view('includes/footer');		
	}


	public function getStudentAttendanceByDate() {

		$student = $this->input->get('student');
		$draw = $this->input->get('draw');
		$from = $this->input->get('from');
		$to = $this->input->get('to');

		$begin = new DateTime($from);
		$end = new DateTime($to);

		$dataArr = [];

		for($x = $begin ;$x <= $end; $x->modify('+1 day')) {

			$result = $this->timelog_model->getAttendanceByDate($student,$x->format("Y-m-d"))->result();

		    foreach($result as $res) {
		    	$data = new stdClass();
		    	$data->last_name = $res->last_name;
		    	$data->timeTap = $res->timeTap;
		    	$data->type = $res->type;
		    	$data->day = $x->format("l");
		    	$data->sched_timein = $res->schedule_timein;
		    	$data->sched_timeout = $res->schedule_timeout;
		    	$data->date = $x->format("Y-m-d");
		    	array_push($dataArr,$data);
		    }	

		}

        $data = array(
            "draw" => $draw,
            "recordsTotal" => count($dataArr),
            "recordsFiltered" => count($dataArr),
            "data" => $dataArr
        );

		echo json_encode($data);	
	}


	public function schoolYear() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page'
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/schoolYear/index');
		$this->load->view('includes/footer');		
	}	

	public function createSchoolYear() {

		$this->isLogged();

		$schoolYear = $this->input->post('schoolYear');

		if($schoolYear != "") {

			$data = array($schoolYear);
			$this->settings_model->createSchoolYear($data);
			$data = array('status' => 'success','message' => 'Successfully Added.');
		} else {

			$data = array('status' => 'error','message' => 'Please Fill out the field.');
		}
	
		echo json_encode($data);
	}


    public function schoolYearJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->settings_model->getSchoolYear(null,null,null)->num_rows(),
            "recordsFiltered" => $this->settings_model->getSchoolYear(null,null,null)->num_rows(),
            "data" => $this->settings_model->getSchoolYear($start,$length,$search)->result()
        );

        echo json_encode($data);            
    }	

	public function updateSchoolYear() {

		$this->isLogged();

		$schoolYearId = $this->input->post('schoolYearId');
		$schoolYear = $this->input->post('schoolYear');

		if($schoolYear != "") {

			$data = array(
				$schoolYear,
				$schoolYearId
			);

			$this->settings_model->updateSchoolYear($data);

			$data = array('status' => 'success', 'message' => 'Successfully Updated.');
		}else {

			$data = array('status' => 'error', 'message' => 'Please Fill out the fields.');
		}

		echo json_encode($data);
	}    

	public function deleteSchoolYear() {

		$this->isLogged();

		$schoolYearId = $this->input->post('schoolYearId');

		$this->settings_model->deleteSchoolYear(array($schoolYearId));

		$data = array('status' => 'success', 'message' => 'Successfully Deleted.');

		echo json_encode($data);
	}


	public function attendancePerSection() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'sections' => $this->settings_model->getSection(null,null,null)->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/section/attendance/index');
		$this->load->view('includes/footer');		
	}


	public function getSectionAttendanceByDate() {

		$section = $this->input->get('section');
		$draw = $this->input->get('draw');
		$from = $this->input->get('from');
		$to = $this->input->get('to');

		$begin = new DateTime($from);
		$end = new DateTime($to);

		$dataArr = [];

		for($x = $begin ;$x <= $end; $x->modify('+1 day')) {

			$result = $this->timelog_model->getSectionAttendanceByDate($section,$x->format("Y-m-d"))->result();

		    foreach($result as $res) {
		    	$data = new stdClass();
		    	$data->id = $res->id;
		    	$data->student = $res->student;
		    	$data->timeTap = $res->timeTap;
		    	$data->type = $res->type;
		    	$data->day = $x->format("l");
		    	$data->sched_timein = $res->schedule_timein;
		    	$data->sched_timeout = $res->schedule_timeout;
		    	$data->date = $x->format("Y-m-d");
		    	array_push($dataArr,$data);
		    }	

		}

        $data = array(
            "draw" => $draw,
            "recordsTotal" => count($dataArr),
            "recordsFiltered" => count($dataArr),
            "data" => $dataArr
        );

		echo json_encode($data);	
	}

}
