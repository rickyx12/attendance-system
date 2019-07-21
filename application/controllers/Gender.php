<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gender extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('course_model');
 		$this->load->model('gender_model');
 		$this->load->model('settings_model');
 		$this->load->library('session');
 	}

    private function isLogged() {

        if(!$this->session->has_userdata('id')) {
                redirect('Account/login');
        }
    }

	public function course()
	{
		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'courses' => $this->course_model->getCourse(null,null,null)->result(),
			'schoolYear' => $this->settings_model->getSchoolYear(null,null,null)->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/gender/course');
		$this->load->view('includes/footer');
	}

	public function section()
	{
		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'sections' => $this->settings_model->getSection(null,null,null)->result(),
			'schoolYear' => $this->settings_model->getSchoolYear(null,null,null)->result()
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/gender/section');
		$this->load->view('includes/footer');
	}

    public function courseJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $course = $this->input->get('course');
        $gender = $this->input->get('gender');
        $schoolYear = $this->input->get('schoolYear');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->gender_model->getGenderPerCourse(null,null,null,$course,$gender,$schoolYear)->num_rows(),
            "recordsFiltered" => $this->gender_model->getGenderPerCourse(null,null,null,$course,$gender,$schoolYear)->num_rows(),
            "data" => $this->gender_model->getGenderPerCourse($start,$length,$search,$course,$gender,$schoolYear)->result()
        );

        echo json_encode($data);            
    }

    public function sectionJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];
        $section = $this->input->get('section');
        $gender = $this->input->get('gender');
        $schoolYear = $this->input->get('schoolYear');

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->gender_model->getGenderPerSection(null,null,null,$section,$gender,$schoolYear)->num_rows(),
            "recordsFiltered" => $this->gender_model->getGenderPerSection(null,null,null,$section,$gender,$schoolYear)->num_rows(),
            "data" => $this->gender_model->getGenderPerSection($start,$length,$search,$section,$gender,$schoolYear)->result()
        );

        echo json_encode($data);            
    }

}
