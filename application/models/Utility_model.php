<?php

class Utility_model extends CI_Model {

    public function __construct() {
            $this->load->database();
    }

	public function selectNow($table,$cols,$condition,$value) {

		$tbl = $this->db->escape_str($table);
		$column = $this->db->escape_str($cols);
		$cond = $this->db->escape_str($condition);
		$val = $this->db->escape_str($value);

		$sql = "SELECT ".$column." FROM ".$tbl." WHERE ".$cond." = '".$val."' ";
		return $this->db->query($sql);		
	}

	public function quadSelectNow($table, $cols, $condition, $value, $condition1, $value1, $condition2, $value2, $condition3, $value3) {

		$tbl = $this->db->escape_str($table);
		$column = $this->db->escape_str($cols);
		$cond = $this->db->escape_str($condition);
		$val = $this->db->escape_str($value);
		$cond1 = $this->db->escape_str($condition1);
		$val1 = $this->db->escape_str($value1);
		$cond2 = $this->db->escape_str($condition2);
		$val2 = $this->db->escape_str($value2);
		$cond3 = $this->db->escape_str($condition3);
		$val3 = $this->db->escape_str($value3); 

		$sql = "SELECT ".$column." FROM ".$tbl." WHERE ".$cond." = '".$val."' AND ".$cond1." = '".$val1."' AND ".$cond2." = '".$val2."' AND ".$cond3." = '".$val3."' ";
		return $this->db->query($sql);		
	}

}