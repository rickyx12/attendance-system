<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller {

 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('course_model');
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
		$this->load->view('settings/course/index');
		$this->load->view('includes/footer');
	}

	public function add() {

		$this->isLogged();

		$course = $this->input->post('course');

		if($course != "") {

			$data = array($course);
			$this->course_model->add($data);
			$data = array('status' => 'success','message' => 'Successfully Added.');
		} else {

			$data = array('status' => 'error','message' => 'Please Fill out the field.');
		}
	
		echo json_encode($data);
	}

	public function update() {

		$this->isLogged();

		$courseId = $this->input->post('courseId');
		$course = $this->input->post('course');

		if($course != "") {

			$data = array(
				$course,
				$courseId
			);

			$this->course_model->update($data);

			$data = array('status' => 'success', 'message' => 'Successfully Updated.');
		}else {

			$data = array('status' => 'error', 'message' => 'Please Fill out the fields.');
		}

		echo json_encode($data);
	}

	public function delete() {

		$this->isLogged();

		$courseId = $this->input->post('courseId');

		$this->course_model->delete(array($courseId));

		$data = array('status' => 'success', 'message' => 'Successfully Deleted.');

		echo json_encode($data);
	}

    public function resultJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->course_model->getCourse(null,null,null)->num_rows(),
            "recordsFiltered" => $this->course_model->getCourse(null,null,null)->num_rows(),
            "data" => $this->course_model->getCourse($start,$length,$search)->result()
        );

        echo json_encode($data);            
    }
}
