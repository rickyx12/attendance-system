<?php

class Gender_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function getGenderPerCourse($start,$limit,$search,$course,$gender,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$course1 = $this->db->escape_str($course);
		$gender1 = $this->db->escape_str($gender);
		$schoolYear1 = $this->db->escape_str($schoolYear);

		if($limit1 > 0 || $limit1 != '') {

			if($search1 != "") {

				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_course course
				ON gl.course = course.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				WHERE gl.course = '".$course1."'
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) LIKE '".$search1."%'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				LIMIT ".$start1.",".$limit1."
				";
			
			}else {
			
				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_course course
				ON gl.course = course.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				WHERE gl.course = ".$course1."
				AND s.gender = '".$gender1."'
				AND gl.school_year = ".$schoolYear1."
				AND gl.status = 1
				ORDER BY s.last_name ASC
				LIMIT ".$start1.",".$limit1;
			}

		}else {

				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_course course
				ON gl.course = course.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				WHERE gl.course = '".$course1."'
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				";
		}

		return $this->db->query($sql);
	}


	public function getGenderPerSection($start,$limit,$search,$section,$gender,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$section1 = $this->db->escape_str($section);
		$gender1 = $this->db->escape_str($gender);
		$schoolYear1 = $this->db->escape_str($schoolYear);

		if($limit1 > 0 || $limit1 != '') {

			if($search1 != "") {

				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				WHERE gl.section = '".$section1."'
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) LIKE '".$search1."%'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				LIMIT ".$start1.",".$limit1."
				";
			
			}else {
			
				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				WHERE gl.section = ".$section1."
				AND s.gender = '".$gender1."'
				AND gl.school_year = ".$schoolYear1."
				AND gl.status = 1
				ORDER BY s.last_name ASC
				LIMIT ".$start1.",".$limit1;
			}

		}else {

				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				WHERE gl.section = '".$section1."'
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				";
		}

		return $this->db->query($sql);
	}


	public function getGenderPerGradeLevel($start,$limit,$search,$gradeLevel,$gender,$schoolYear) {

		$start1 = $this->db->escape_str($start);
		$limit1 = $this->db->escape_str($limit);
		$search1 = $this->db->escape_str($search);
		$gradeLevel1 = $this->db->escape_str($gradeLevel);
		$gender1 = $this->db->escape_str($gender);
		$schoolYear1 = $this->db->escape_str($schoolYear);

		if($limit1 > 0 || $limit1 != '') {

			if($search1 != "") {

				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section,
					course.course
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				JOIN settings_course course
				ON gl.course = course.id
				JOIN settings_gradelevel level
				ON gl.grade_level = level.id
				WHERE gl.grade_level = ".$gradeLevel1."
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) LIKE '".$search1."%'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				LIMIT ".$start1.",".$limit1."
				";
			
			}else {
			
				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section,
					course.course
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				JOIN settings_course course
				ON gl.course = course.id
				JOIN settings_gradelevel level
				ON gl.grade_level = level.id
				WHERE gl.grade_level = ".$gradeLevel1."
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				LIMIT ".$start1.",".$limit1."
				";
			}

		}else {

				$sql = "
				SELECT 
					CONCAT_WS(' ',s.last_name,s.first_name,s.middle_name) as student,
					section.section,
					course.course
				FROM students s
				JOIN grade_level gl
				ON s.id = gl.student_id
				JOIN settings_section section
				ON gl.section = section.id
				JOIN settings_schoolyear sy
				ON gl.school_year = sy.id
				JOIN settings_course course
				ON gl.course = course.id
				JOIN settings_gradelevel level
				ON gl.grade_level = level.id
				WHERE gl.grade_level = ".$gradeLevel1."
				AND s.gender = '".$gender1."'
				AND gl.school_year = '".$schoolYear1."'
				AND gl.status = 1
				ORDER BY s.last_name ASC
				";
		}

		return $this->db->query($sql);
	}

}