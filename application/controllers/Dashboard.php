<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

 	public function __construct() {

 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('timelog_model');
 		$this->load->model('settings_model');
 		$this->load->model('gradelevel_model');
 		$this->load->library('session');
 	}

        private function isLogged() {

            if(!$this->session->has_userdata('id')) {
                    redirect('Account/login');
            }
        }

	public function index()	{

		$this->isLogged();

		$data = array(
			'page' => 'dashboard-page',
			'data' => $this->dashboardData(),
		);

		$this->load->view('includes/header',$data);
		$this->load->view('dashboard/index');
		$this->load->view('includes/footer');
	}


	public function dashboardData() {

		$this->isLogged();

		$timeArr = [];
		$gradeLevel = $this->settings_model->getGradeLevel(null,null,null)->result();

		foreach($gradeLevel as $grade) {

			array_push(
				$timeArr,
				array(
					'id' => $grade->id,
					'gradeLevel' => $grade->grade_level,
					'timein' => $this->timelog_model->getTimelog(array(date('Y-m-d'),'in',$grade->id))->num_rows(),
					'timeout' => $this->timelog_model->getTimelog(array(date('Y-m-d'),'out',$grade->id))->num_rows(),
					'late' => $this->timelog_model->getAllLate(array('in',date('Y-m-d'),$grade->id))->num_rows()
				)
			);

		}

		return $timeArr;
	}


	public function timelogDetails() {

		$this->isLogged();

		$gradeLevel = $this->input->get('gradeLevel');
		$type = $this->input->get('type');
		$typeWord = null;

		if($type == "in") {
			$typeWord = "Timein";
		}else {
			$typeWord = "Timeout";
		}

		$data = array(
			'page' => 'dashboard-page',
			'typeWord' => $typeWord,
			'data' => $this->getStudentsPerSection($type),
		);

		$this->load->view('includes/header',$data);
		$this->load->view('dashboard/details');
		$this->load->view('includes/footer');		

	}

	public function getStudentsPerSection($type) {

		$this->isLogged();

		$studentsLog = [];
		$gradeLevel = $this->input->get('gradeLevel');
		$sections = $this->settings_model->getSectionByGrade(array($gradeLevel))->result();

		foreach($sections as $section) {

			array_push(
				$studentsLog,
				array(	
					'section' => $section->section,				
					'students' => 
						$this->gradelevel_model->getStudentsPerSection(
							array(
								$section->id,
								date('Y-m-d'),
								$type
							)
						)->result()
							
					)
				);
		}

		return $studentsLog;
	}

	public function lates()	{

		$this->isLogged();

		$gradeLevel = $this->input->get('gradeLevel');

		$data = array(
			'page' => 'dashboard-page',
			'data' => $this->getLate(array($gradeLevel)),
		);

		$this->load->view('includes/header',$data);
		$this->load->view('dashboard/late');
		$this->load->view('includes/footer');
	}

	public function getLate($gradeLevel) {

		$this->isLogged();

		$lateArr = [];
		$sections = $this->settings_model->getSectionByGrade(array($gradeLevel))->result();

		foreach($sections as $section) {

			array_push(
				$lateArr,
				array(
					'section' => $section->section,
					'students' =>
						$this->timelog_model->getLatePerSection(
							array(
								'in',
								date('Y-m-d'),
								$section->id
							)
						)->result()
				)
			);
		}

		return $lateArr;

	}

}
