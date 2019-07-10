<?php

class Timelog_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function create($data) {
		$sql = "INSERT INTO timelog(grade_level_id,type,timeTap,dateTap) VALUES (?,?,?,?)";
		$this->db->query($sql, $data);			
	}

	public function checkTimein($data) {

		$sql = "SELECT id,type FROM timelog WHERE grade_level_id = ? AND dateTap = ? ORDER BY id DESC LIMIT 1 ";
		return $this->db->query($sql,$data);			
	}

	public function getCurrentTimelog($data) {

		$sql = "SELECT * FROM timelog WHERE dateTap = ? AND type = ? ORDER BY id DESC";
		return $this->db->query($sql,$data);		
	}

	public function getTimelog($data) {

		$sql = "
		SELECT t.id, s.last_name, s.first_name,sg.grade_level,ss.section,t.timeTap 
		FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss,timelog t 
		WHERE s.id = gl.student_id
		AND gl.grade_level = sg.id
		AND gl.section = ss.id
		AND gl.id = t.grade_level_id
		AND t.dateTap = ? 
		AND t.type = ? 
		AND gl.grade_level = ?
		AND gl.status = 1
		ORDER BY t.id DESC";	

		return $this->db->query($sql,$data);		
	}

	public function getTimelogPerSection($data) {

		$sql = "
		SELECT t.id, s.last_name, s.first_name,sg.grade_level,ss.section,t.timeTap 
		FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss,timelog t 
		WHERE s.id = gl.student_id
		AND gl.grade_level = sg.id
		AND gl.section = ss.id
		AND gl.id = t.grade_level_id
		AND t.dateTap = ? 
		AND t.type = ? 
		AND gl.section = ?
		ORDER BY t.id DESC";	

		return $this->db->query($sql,$data);		
	}

	public function getLatePerSection($data) {

		$sql = "
		SELECT t.id, s.last_name, s.first_name,sg.grade_level,ss.section, gl.schedule_timein, t.timeTap 
		FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss,timelog t 
		WHERE s.id = gl.student_id
		AND gl.grade_level = sg.id
		AND gl.section = ss.id
		AND gl.id = t.grade_level_id
		AND t.grade_level_id = gl.id
		AND t.type = ?
		AND t.dateTap = ?  
		AND gl.section = ?
		AND t.timeTap > gl.schedule_timein
		ORDER BY t.id ASC";

		return $this->db->query($sql,$data);			
	}

	public function getAllLate($data) {

		$sql = "
		SELECT t.id, s.last_name, s.first_name,sg.grade_level,ss.section, gl.schedule_timein, t.timeTap 
		FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss,timelog t 
		WHERE s.id = gl.student_id
		AND gl.grade_level = sg.id
		AND gl.section = ss.id
		AND gl.id = t.grade_level_id
		AND t.grade_level_id = gl.id
		AND t.type = ?
		AND t.dateTap = ? 
		AND gl.grade_level = ? 
		AND t.timeTap > gl.schedule_timein
		ORDER BY t.id ASC";

		return $this->db->query($sql,$data);			
	}

}