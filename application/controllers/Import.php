<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

 	public function __construct() {

 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->model('account_model');
 		$this->load->model('students_model');
 		$this->load->model('gradelevel_model');
 		$this->load->model('utility_model');
 		$this->load->library('CSVReader');
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
			'isAdmin' => $this->account_model->getUser($this->session->id)->row()->admin
		);

		$this->load->view('includes/header',$data);
		$this->load->view('import/index');
		$this->load->view('includes/footer');
	}

	public function personalInfo() {

		$this->isLogged();

		$studentData = array();
		$gradeLevelData = array();
		$success = array();
		$denied = array();

		if(is_uploaded_file($_FILES['csvFile']['tmp_name'])) {

			$csvData = $this->csvreader->parse_csv($_FILES['csvFile']['tmp_name']);

			if(!empty($csvData)) {
				foreach($csvData as $row) {

					$formatBirthdate = preg_split("/\//", $row['birthdate']);

					$studentData = array(
						'last_name' => ucfirst($row['last_name']),
						'first_name' => ucfirst($row['first_name']),
						'middle_name' => ucfirst($row['middle_name']),
						'birthdate' => $formatBirthdate[2]."-".$formatBirthdate[0]."-".$formatBirthdate[1],
						'gender' => $row['gender']
					);


					if(
						$this->utility_model->quadSelectNow(
							'students',
							'id',
							'last_name', ucfirst($row['last_name']),
							'first_name', ucfirst($row['first_name']),
							'middle_name', ucfirst($row['middle_name']),
							'status', '1' 
						)->num_rows() < 1
					) {
											

						if($this->gradelevel_model->getGradeLevelByIdentifierTag($row['identifierTag'])->num_rows() == 0) {
						
							$insertId = $this->students_model->create($studentData);

							$gradeLevelData = array(
								'student_id' => $insertId,
								'grade_level' => $row['grade_level'],
								'section' => $row['section'],
								'course' => $row['course'],
								'school_year' => $row['school_year'],
								'schedule_timein' => $row['schedule_timein'],
								'schedule_timeout' => $row['schedule_timeout'],
								'photo' => '150x350.png',
								'guardian' => $row['guardian'],
								'guardian_contact' => $row['guardian_contact'],
								'adviser_contact' => $row['adviser_contact'],
								'identifierTag' => $row['identifierTag'],
								'date_added' => date('Y-m-d H:i:s') 
							);

							$this->gradelevel_model->create($gradeLevelData);
							array_push($success, array(ucfirst($row['last_name']).", ".ucfirst($row['first_name'])));

						}else {
							
							array_push($denied, array(ucfirst($row['last_name']).", ".ucfirst($row['first_name']).' RF Card issued to this student is already in use by another student.'));
						}
						// echo "Importing Finish.";
						// echo "<br><br>";
					}else {

						array_push($denied, array(ucfirst($row['last_name']).", ".ucfirst($row['first_name']).' is already in the list of students'));

						// echo "Importing Denied. Name Already Exist on the Database.";
						// echo "<br><br>";
					}
				}

				$data = array('status' => 'success', 'message' => 'Importing Done', 'success' => $success , 'denied' => $denied);
				echo json_encode($data);
			}
		}
	}

}
