<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('settings_model');
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

		$data = array('page' => 'settings-page');

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


    public function gradeLevelStudents() {

 		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'gradeLevel' => $this->settings_model->getGradeLevel('','','')->result()
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

		if($section != "" || $gradeLevel != "") {

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
			'sections' => $this->settings_model->getSection('','','')->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/section/students/index.php');
		$this->load->view('includes/footer');   	
    }

}
