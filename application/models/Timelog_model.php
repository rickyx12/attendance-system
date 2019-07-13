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

	public function getAllLateByDate($start,$limit,$from,$to) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$from1 = $this->db->escape_str($from);
		$to1 = $this->db->escape_str($to);

		if($limit > 0 || $limit != '') {

			$sql = "
			SELECT t.id, s.last_name, s.first_name,sg.grade_level,ss.section, gl.schedule_timein, t.timeTap, t.dateTap 
			FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss,timelog t 
			WHERE s.id = gl.student_id
			AND gl.grade_level = sg.id
			AND gl.section = ss.id
			AND gl.id = t.grade_level_id
			AND t.grade_level_id = gl.id
			AND t.type = 'in'
			AND t.dateTap BETWEEN '".$from1."' AND '".$to1."' 
			AND t.timeTap > gl.schedule_timein
			ORDER BY gl.grade_level ASC
			LIMIT ".$start1.",".$limit1;
		}else {

			$sql = "
			SELECT t.id, s.last_name, s.first_name,sg.grade_level,ss.section, gl.schedule_timein, t.timeTap, t.dateTap 
			FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss,timelog t 
			WHERE s.id = gl.student_id
			AND gl.grade_level = sg.id
			AND gl.section = ss.id
			AND gl.id = t.grade_level_id
			AND t.grade_level_id = gl.id
			AND t.type = 'in'
			AND t.dateTap BETWEEN '".$from1."' AND '".$to1."' 
			AND t.timeTap > gl.schedule_timein
			ORDER BY gl.grade_level ASC";			
		}

		return $this->db->query($sql);			
	}


	public function getAbsentByDate($date) {

		$sql = "
		SELECT gl.id, s.last_name, s.first_name, sg.grade_level, ss.section,t.grade_level_id, t.dateTap 
		FROM grade_level gl
		INNER JOIN students s
		ON s.id = gl.student_id
		INNER JOIN settings_gradelevel sg
		ON gl.grade_level = sg.id 
		INNER JOIN settings_section ss
		ON gl.section = ss.id
		LEFT JOIN timelog t
		ON gl.id = t.grade_level_id
		AND t.dateTap = '".$date."'
		WHERE gl.status = 1
		AND t.grade_level_id IS NULL";
		
		return $this->db->query($sql);			
	}

	public function getAttendanceByDate($student,$date) {

		$student1 = $this->db->escape_str($student);
		$date1 = $this->db->escape_str($date);

		$sql = "
		SELECT s.last_name ,t.dateTap, t.timeTap, t.type, gl.schedule_timein, gl.schedule_timeout
		FROM grade_level gl
		INNER JOIN students s
		ON s.id = gl.student_id
		INNER JOIN settings_gradelevel sg
		ON gl.grade_level = sg.id 
		INNER JOIN settings_section ss
		ON gl.section = ss.id
		LEFT JOIN timelog t
		ON gl.id = t.grade_level_id
		AND t.dateTap = '".$date1."'
		WHERE gl.status = 1
		AND gl.id = ".$student1."
		ORDER BY t.id ASC";
		
		return $this->db->query($sql);			
	}

}