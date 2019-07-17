<?php

class GradeLevel_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function create($data) {
		$sql = "INSERT INTO grade_level(student_id,grade_level,section,school_year,schedule_timein,schedule_timeout,photo,guardian,guardian_contact,identifierTag,date_added) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql, $data);			
	}

	public function getGradeLevelById($data) {

		$sql = "SELECT * FROM grade_level WHERE id = ? AND status = 1 ORDER BY id DESC ";
		return $this->db->query($sql,$data);			
	}

	public function getEnrollees($start,$limit,$search,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$schoolYear1 = $this->db->escape_str($schoolYear);

		if($limit > 0 || $limit != '') {

			if($search1 != "") {

				$sql = "
				SELECT gl.id as gradeLevelId,s.id as studentId,s.last_name,s.first_name,s.middle_name,sg.id as settingsGradeLevelId,sg.grade_level,ss.id as sectionId,ss.section,sy.school_year,gl.schedule_timein,gl.schedule_timeout,gl.photo,gl.identifierTag,gl.guardian,gl.guardian_contact 
				FROM students s ,grade_level gl, settings_gradelevel sg, settings_section ss, settings_schoolyear sy 
				WHERE s.id = gl.student_id
				AND gl.grade_level = sg.id 
				AND gl.section = ss.id
				AND gl.school_year = sy.id
				AND (CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) LIKE '".$search1."%' OR gl.grade_level LIKE '".$search1."%') 
				AND gl.school_year = '".$schoolYear1."'
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;
			
			}else {
			
				$sql = "
				SELECT gl.id as gradeLevelId,s.id as studentId,s.last_name,s.first_name,s.middle_name,sg.id as settingsGradeLevelId,sg.grade_level,ss.id as sectionId,ss.section,sy.school_year,gl.schedule_timein,gl.schedule_timeout,gl.photo,gl.identifierTag,gl.guardian,gl.guardian_contact
				FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss, settings_schoolyear sy 
				WHERE s.id = gl.student_id 
				AND gl.grade_level = sg.id
				AND gl.section = ss.id
				AND gl.school_year = sy.id
				AND gl.school_year = '".$schoolYear1."'
				AND gl.status = 1 
				ORDER BY gl.id DESC LIMIT ".$start1.",".$limit1;	
			}

		}else {

			$sql = "
			SELECT gl.id as gradeLevelId,s.id as studentId,s.last_name,s.first_name,s.middle_name,sg.id as settingsGradeLevelId,sg.grade_level,ss.id as sectionId,ss.section,sy.school_year,gl.schedule_timein,gl.schedule_timeout,gl.photo,gl.identifierTag,gl.guardian,gl.guardian_contact 
			FROM students s ,grade_level gl, settings_gradelevel sg, settings_section ss, settings_schoolyear sy 
			WHERE s.id = gl.student_id 
			AND gl.grade_level = sg.id
			AND gl.section = ss.id
			AND gl.school_year = sy.id
			AND gl.school_year = '".$schoolYear1."'
			AND gl.status = 1";
		}

		return $this->db->query($sql);
	}

	public function getStudentsPerSection($data) {

		$sql = "
		SELECT gl.id,s.last_name, s.first_name, s.middle_name, t.timeTap 
		FROM students s, grade_level gl, settings_gradelevel sg, settings_section ss, timelog t
		WHERE s.id = gl.student_id 
		AND gl.grade_level = sg.id
		AND gl.section = ss.id
		AND t.grade_level_id = gl.id
		AND gl.section = ?
		AND t.dateTap = ?
		AND t.type = ?
		AND gl.status = 1
		";	

		return $this->db->query($sql,$data);	
	}

	public function getGradeLevelByIdentifierTag($data) {

		$sql = "
		SELECT s.last_name, s.first_name, gl.id as gradeLevelId, gl.photo, gl.guardian_contact 
		FROM students s,grade_level gl 
		WHERE s.id = gl.student_id
		AND gl.identifierTag = ? 
		AND gl.status = 1";
		return $this->db->query($sql,$data);			
	}

	public function update($data) {

		$sql = "UPDATE grade_level SET grade_level = ?, section = ?, school_year = ?, schedule_timein = ?, schedule_timeout = ?, photo = ?, guardian = ?, guardian_contact =?, identifierTag = ? WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function delete($data) {

		$sql = "UPDATE grade_level SET status = 0 WHERE id = ?";
		$this->db->query($sql,$data);		
	}

	public function searchStudent($param) {

		$student = $this->db->escape_str($param);

		if($param != '' || $param != null) {
			$sql = "
				SELECT gl.id, CONCAT_WS(' ',s.last_name, s.first_name, s.middle_name) as name, ss.section, sg.grade_level
				FROM students s
				INNER JOIN grade_level gl
				ON s.id = gl.student_id
				INNER JOIN settings_gradelevel sg
				ON gl.grade_level = sg.id
				INNER JOIN settings_section ss
				ON gl.section = ss.id
				WHERE CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) LIKE '".$student."%'
				AND gl.status = 1
			";

			return $this->db->query($sql);
		}
	}

}