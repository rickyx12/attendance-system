<?php

class Account_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function create($data) {
		$sql = "INSERT INTO users(username,password,added) VALUES (?,?,?)";
		$this->db->query($sql, $data);			
	}

	public function delete($data) {

		$sql = "DELETE FROM users WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function getUsers($start,$limit,$search) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT *
				FROM users
				AND username LIKE '".$search1."%'
				ORDER BY username ASC LIMIT ".$start1.",".$limit1;
			
			}else {
			
				$sql = "
				SELECT *
				FROM users
				ORDER BY username ASC LIMIT ".$start1.",".$limit1;	
			}

		}else {

				$sql = "
				SELECT *
				FROM users
				ORDER BY username ASC";
		}

		return $this->db->query($sql);
	}	

}