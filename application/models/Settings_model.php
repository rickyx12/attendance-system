<?php

class Settings_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function createGradeLevel($data) {
		$sql = "INSERT INTO settings_gradelevel(grade_level) VALUES (?)";
		$this->db->query($sql, $data);			
	}

	public function updateGradeLevel($data) {
		$sql = "UPDATE settings_gradelevel SET grade_level = ? WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function deleteGradeLevel($data) {
		$sql = "UPDATE settings_gradelevel SET status = 0 WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function getGradeLevel($start,$limit,$search) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT * 
				FROM settings_gradelevel 
				WHERE grade_level LIKE '".$search1."%'
				AND status = 1 
				ORDER BY grade_level ASC LIMIT ".$start1.",".$limit1;

			}else {
			
				$sql = "
				SELECT *
				FROM settings_gradelevel 
				WHERE status = 1 
				ORDER BY grade_level ASC LIMIT ".$start1.",".$limit1;	
			}	

		}else {

			$sql = "SELECT * FROM settings_gradelevel WHERE status = 1 ORDER BY grade_level ASC";
		}

		return $this->db->query($sql);
	}


	public function createSection($data) {
		$sql = "INSERT INTO settings_section(section,settings_grade_level_id) VALUES (?,?)";
		$this->db->query($sql, $data);			
	}

	public function updateSection($data) {
		$sql = "UPDATE settings_section SET section = ?, settings_grade_level_id = ? WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function deleteSection($data) {
		$sql = "UPDATE settings_section SET status = 0 WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function getSection($start,$limit,$search) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT ss.id,sg.grade_level, ss.section 
				FROM settings_section ss, settings_gradelevel sg 
				WHERE ss.settings_grade_level_id = sg.id
				AND ss.section LIKE '".$search1."%'
				AND ss.status = 1 
				ORDER BY sg.grade_level ASC LIMIT ".$start1.",".$limit1;

			}else {
			
				$sql = "
				SELECT ss.id,sg.grade_level, ss.section 
				FROM settings_section ss, settings_gradelevel sg 
				WHERE ss.settings_grade_level_id = sg.id
				AND ss.status = 1 
				ORDER BY sg.grade_level ASC LIMIT ".$start1.",".$limit1;	
			}	

		}else {

			$sql = "
			SELECT ss.id, sg.grade_level, ss.section 
			FROM settings_section ss, settings_gradelevel sg 
			WHERE ss.settings_grade_level_id = sg.id
			AND ss.status = 1 
			ORDER BY sg.grade_level ASC";
		}

		return $this->db->query($sql);
	}


	public function getSectionByGrade($data) {

		$sql = "
		SELECT ss.id,sg.grade_level, ss.section 
		FROM settings_section ss, settings_gradelevel sg 
		WHERE ss.settings_grade_level_id = sg.id
		AND ss.settings_grade_level_id = ?
		AND ss.status = 1 
		ORDER BY sg.grade_level ASC";
		
		return $this->db->query($sql,$data);
	}

	public function createSchoolYear($data) {
		$sql = "INSERT INTO settings_schoolyear(school_year) VALUES (?)";
		$this->db->query($sql, $data);			
	}

	public function updateSchoolYear($data) {
		$sql = "UPDATE settings_schoolyear SET school_year = ? WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function deleteSchoolYear($data) {
		$sql = "UPDATE settings_schoolyear SET status = 0 WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function getSchoolYear($start,$limit,$search) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT * 
				FROM settings_schoolyear 
				WHERE school_year LIKE '".$search1."%'
				AND status = 1 
				ORDER BY id ASC LIMIT ".$start1.",".$limit1;

			}else {
			
				$sql = "
				SELECT *
				FROM settings_schoolyear 
				WHERE status = 1 
				ORDER BY id ASC LIMIT ".$start1.",".$limit1;	
			}	

		}else {

			$sql = "SELECT * FROM settings_schoolyear WHERE status = 1 ORDER BY id ASC";
		}

		return $this->db->query($sql);
	}

}