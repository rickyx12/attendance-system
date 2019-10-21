<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('account_model');
		$this->load->model('utility_model');
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
		$this->load->view('settings/users/index');
		$this->load->view('includes/footer');
	}

	public function login() {
		$this->load->view('login');
	}

	public function changePassword() {

		$this->isLogged();

		$data = array(
			'page' => 'settings-page',
			'username' => $this->account_model->getUser($this->session->id)->row()->username
		);

		$this->load->view('includes/header',$data);
		$this->load->view('settings/users/change_password');
		$this->load->view('includes/footer');		
	}

	public function loginNow() {

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$account = $this->utility_model->selectNow('users','id','username',$username)->row();
		$hashPass = $this->utility_model->selectNow('users','password','username',$username)->row();

		if($account->id != "") {

			if(password_verify($password,$hashPass->password)) {
				$this->session->id = $account->id;
				redirect('Students/index');
			}else {
				redirect('Account/login');
			}

		}else {
			redirect('Account/login');
		}

	}

	public function changePasswordNow() {

		$username = $this->input->post('username');
		$currentPassword = $this->input->post('currentPassword');
		$newPassword = $this->input->post('newPassword');
		$response = "";

		$account = $this->utility_model->selectNow('users','id','username',$username)->row();
		$hashPass = $this->utility_model->selectNow('users','password','username',$username)->row();

		if($account->id != "") {

			if(password_verify($currentPassword,$hashPass->password)) {
				
				$hashPass = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
				$data = array($hashPass,$account->id);
				$this->account_model->changePassword($data);

				$response = array('status' => 'success', 'message' => 'Change password success.');
			}else {

				$response = array('status' => 'error', 'message' => 'Incorrect Password');
			}

		}else {
			$response = array('status' => 'error', 'message' => 'Incorrect Password');
		}

		echo json_encode($response);					
	}

	public function register() {
		$this->load->view('register');
	}

	public function registerNow() {

		$this->isLogged();

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($username != "" && $password != "") {

			$hashPass = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
			$data = array($username,$hashPass,date("Y-m-d H:i:s"));
			$this->account_model->create($data);
			echo json_encode(array('status' => 'success','message' => 'Successfully Added!'));
		}else {
			echo json_encode(array('status' => 'error','message' => 'All fields required.'));
		}

	}

	public function logout() {

		$this->session->unset_userdata('id');
		redirect('Account/login');
	}

    public function resultJSON() {

		$this->isLogged();

        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'];

        $data = array(
            "draw" => $draw,
            "recordsTotal" => $this->account_model->getUsers(null,null,null)->num_rows(),
            "recordsFiltered" => $this->account_model->getUsers(null,null,null)->num_rows(),
            "data" => $this->account_model->getUsers($start,$length,$search)->result()
        );

        echo json_encode($data);            
    }

    public function delete() {

    	$this->isLogged();

    	$id = $this->input->post('id');
    	$this->account_model->delete(array($id));

    	echo json_encode(array('status' => 'success','message' => 'Successfully Added.'));
    }

}