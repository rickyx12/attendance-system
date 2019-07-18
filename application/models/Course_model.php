<?php

class Course_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function add($data) {
		$sql = "INSERT INTO settings_course(course) VALUES (?)";
		$this->db->query($sql, $data);			
	}

	public function update($data) {

		$sql = "UPDATE settings_course SET course = ?  WHERE id = ? AND status = 1";
		$this->db->query($sql,$data);		
	}

	public function delete($data) {

		$sql = "UPDATE settings_course SET status = 0 WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function getCourse($start,$limit,$search) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT *
				FROM settings_course
				WHERE status = 1
				AND course LIKE '".$search1."%'
				ORDER BY course ASC LIMIT ".$start1.",".$limit1;
			
			}else {
			
				$sql = "
				SELECT *
				FROM settings_course
				WHERE status = 1
				ORDER BY course ASC LIMIT ".$start1.",".$limit1;	
			}

		}else {

				$sql = "
				SELECT *
				FROM settings_course
				WHERE status = 1
				ORDER BY course ASC";
		}

		return $this->db->query($sql);
	}


}