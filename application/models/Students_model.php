<?php

class Students_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function create($data) {
		$sql = "INSERT INTO students(last_name,first_name,middle_name,birthdate,gender) VALUES (?,?,?,?,?)";
		$this->db->query($sql, $data);			
	}

	public function getStudentByName($data) {
		$sql = "SELECT * FROM students WHERE last_name = ? AND first_name = ? AND middle_name = ? AND status = 1 ";
		return $this->db->query($sql,$data);
	}

	public function searchStudent($search) {

		$search1 = $this->db->escape_str($search);

		if($search1 != null || $search1 != "") {
			$sql = "
			SELECT id,CONCAT_WS(' ',last_name,first_name,middle_name) as name 
			FROM students 
			WHERE CONCAT_WS(' ',last_name,first_name,middle_name) LIKE '".$search1."%' AND status = 1";
			return $this->db->query($sql);
		}
	}

	public function getStudents($start,$limit,$search) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {
				
				$sql = "
				SELECT * 
				FROM students 
				WHERE CONCAT_WS(' ',last_name,first_name,middle_name) 
				LIKE '".$search1."%' 
				AND status = 1 
				ORDER BY id DESC 
				LIMIT ".$start1.",".$limit1;
			
			}else {
				
				$sql = "
				SELECT * 
				FROM students 
				WHERE status = 1 
				ORDER BY id DESC 
				LIMIT ".$start1.",".$limit1;	
			}	

		}else {

			$sql = "SELECT * FROM students";
		}

		return $this->db->query($sql);
	}

	public function update($data) {

		$sql = "UPDATE students SET last_name = ?, first_name = ?, middle_name = ?, birthdate = ?, gender = ? WHERE id = ? AND status = 1";
		$this->db->query($sql,$data);		
	}

	public function delete($data) {

		$sql = "UPDATE students SET status = 0 WHERE id = ?";
		$this->db->query($sql,$data);		
	}


	public function getStudentsPerGradeLevel($start,$limit,$search,$gradeLevel,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$grade = $this->db->escape_str($gradeLevel);
		$sy = $this->db->escape_str($schoolYear);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT s.last_name, s.first_name, s.middle_name, ss.section
				FROM students s ,grade_level gl, settings_section ss
				WHERE s.id = gl.student_id
				AND gl.grade_level = ".$grade." 
				AND gl.section = ss.id
				AND gl.school_year = '".$sy."'
				AND (s.last_name LIKE '".$search1."%') 
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;
			
			}else {
			
				$sql = "
				SELECT s.last_name, s.first_name, s.middle_name, ss.section
				FROM students s, grade_level gl, settings_section ss
				WHERE s.id = gl.student_id 
				AND gl.grade_level = ".$grade."
				AND gl.section = ss.id
				AND gl.school_year = '".$sy."'
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;	
			}

		}else {

			$sql = "
			SELECT * FROM students s ,grade_level gl, settings_section ss
			WHERE s.id = gl.student_id 
			AND gl.grade_level = ".$grade."
			AND gl.school_year = '".$sy."'
			AND gl.section = ss.id
			AND gl.status = 1";
		}

		return $this->db->query($sql);
	}


	public function getStudentsPerSection($start,$limit,$search,$section,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$sec = $this->db->escape_str($section);
		$sy = $this->db->escape_str($schoolYear);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT s.last_name, s.first_name, s.middle_name
				FROM students s ,grade_level gl
				WHERE s.id = gl.student_id
				AND gl.section = ".$sec."
				AND gl.school_year = '".$sy."'
				AND (s.last_name LIKE '".$search1."%') 
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;
			
			}else {
			
				$sql = "
				SELECT s.last_name, s.first_name, s.middle_name
				FROM students s, grade_level gl
				WHERE s.id = gl.student_id 
				AND gl.section = ".$sec."
				AND gl.school_year = '".$sy."'
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;	
			}

		}else {

			$sql = "
			SELECT * FROM students s ,grade_level gl
			WHERE s.id = gl.student_id 
			AND gl.section = ".$sec."
			AND gl.school_year = '".$sy."'
			AND gl.status = 1";
		}

		return $this->db->query($sql);
	}


	public function getStudentsPerCourse($start,$limit,$search,$course,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$course1 = $this->db->escape_str($course);
		$sy = $this->db->escape_str($schoolYear);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT s.last_name, s.first_name, s.middle_name, ss.section
				FROM students s ,grade_level gl, settings_section ss
				WHERE s.id = gl.student_id
				AND gl.section = ss.id
				AND gl.course = ".$course1."
				AND gl.school_year = '".$sy."'
				AND (s.last_name LIKE '".$search1."%') 
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;
			
			}else {
			
				$sql = "
				SELECT s.last_name, s.first_name, s.middle_name, ss.section
				FROM students s, grade_level gl, settings_section ss
				WHERE s.id = gl.student_id
				AND gl.section = ss.id 
				AND gl.course = ".$course1."
				AND gl.school_year = '".$sy."'
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;	
			}

		}else {

			$sql = "
			SELECT gl.* FROM students s ,grade_level gl, settings_section ss
			WHERE s.id = gl.student_id 
			AND gl.section = ss.id
			AND gl.course = ".$course1."
			AND gl.school_year = '".$sy."'
			AND gl.status = 1";
		}

		return $this->db->query($sql);
	}


}