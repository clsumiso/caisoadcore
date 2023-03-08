<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Records_in_charge_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_semester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_evaluation($course_id, $semester_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name');
		$this->db->from('tbl_profile');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_users', 'tbl_profile.user_id = tbl_users.user_id', 'inner');
		$this->db->where('tbl_profile.course_id', $course_id);
		$this->db->where('tbl_users.user_type', 'student');
		$this->db->group_by(array('tbl_profile.user_id'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_evaluation($user_id, $semester_id)
	{
		$this->db->select('tbl_evaluation.evaluation_id, tbl_evaluation.section, tbl_evaluation.date_admitted, tbl_evaluation.no_stay, tbl_evaluation.entrance_credential, tbl_evaluation.inc_cond_grades, tbl_evaluation.lapse, tbl_evaluation.no_grades, tbl_evaluation.force_drop, tbl_evaluation.behind_subjects, tbl_evaluation.other_concern, tbl_evaluation.ins_from_ric, tbl_evaluation.max_units_allowed');
		$this->db->from('tbl_evaluation');
		$this->db->where('tbl_evaluation.semester_id', $semester_id);
		$this->db->where('tbl_evaluation.studid', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_force_drop($user_id, $semester_id)
	{
		$this->db->select('tbl_class_schedule.cat_no, tbl_registration.registration_id');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$this->db->where('tbl_registration.user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_registration($user_id, $semester_id)
	{
		$this->db->select('tbl_registration.schedid, tbl_class_schedule.cat_no, tbl_class_schedule.units, tbl_class_schedule.time, tbl_class_schedule.day, tbl_class_schedule.room, tbl_class_schedule.section, tbl_class_schedule.weight, tbl_registration.force_drop');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$this->db->where('tbl_registration.user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_registration_per_sem($course_id, $semester_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name, tbl_evaluation.evaluation_id, tbl_evaluation.section, tbl_evaluation.date_admitted, tbl_evaluation.no_stay, tbl_evaluation.entrance_credential, tbl_evaluation.inc_cond_grades, tbl_evaluation.lapse, tbl_evaluation.no_grades, tbl_evaluation.force_drop, tbl_evaluation.behind_subjects, tbl_evaluation.other_concern, tbl_evaluation.ins_from_ric, tbl_evaluation.max_units_allowed');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_evaluation', 'tbl_registration.user_id = tbl_evaluation.studid', 'left');
		$this->db->join('tbl_profile', 'tbl_registration.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->where('tbl_evaluation.semester_id', $semester_id);
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$this->db->where('tbl_profile.course_id', $course_id);
		$this->db->group_by(array('tbl_registration.user_id'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_role($user_id)
	{
		$this->db->select('role');
		$this->db->from('tbl_role');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_course($course_id = array())
	{
		$this->db->select('*');
		$this->db->from('tbl_course');
		$this->db->where_in('course_id', $course_id);
		$this->db->order_by('course_desc', 'asc');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_course_info($course_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_course');
		$this->db->where('course_id', $course_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_class_schedule_section($course_id, $semester_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_class_schedule');
		$this->db->where('semester_id', $semester_id);
		$this->db->where('course_id', $course_id);
		$this->db->group_by(array("section")); 
		$query = $this->db->get();

		return $query->result();
	}

	public function get_enrollment($user_id, $semester_id)
	{
		$this->db->select('section');
		$this->db->from('tbl_enrollment');
		$this->db->where('user_id', $user_id);
		$this->db->where('semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_profile($user_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_profile');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_major($course_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_major');
		$this->db->where('course_id', $course_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_students($course_id, $year_level, $semester_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_profile.student_type, tbl_course.course_name, tbl_enrollment.section');
		$this->db->from('tbl_profile');
		$this->db->join('tbl_enrollment', 'tbl_profile.user_id = tbl_enrollment.user_id', 'left');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->where('tbl_profile.course_id', $course_id);
		$this->db->where('tbl_profile.year_level', $year_level);
		$this->db->where('tbl_enrollment.semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function save($data = array(), $con = array(), $profileData = array(), $table = array(), $profileDataCon = array())
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->insert($table[0], $data);
    		$this->db->update($table[1], $profileData, $profileDataCon);
            if ($this->db->trans_status() === FALSE) 
            {
		        $this->db->trans_rollback();
		        return false;
		    } else 
		    {
		        $this->db->trans_commit();
		        return true;
		    }
        }
        return false;
	}

	public function update($data = array(), $con = array(), $profileData = array(), $table = array(), $profileDataCon = array())
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->update($table[0], $data, $con);
    		$this->db->update($table[1], $profileData, $profileDataCon);
            if ($this->db->trans_status() === FALSE) 
            {
		        $this->db->trans_rollback();
		        return false;
		    } else 
		    {
		        $this->db->trans_commit();
		        return true;
		    }
        }
        return false;
	}

	public function update_single_table($data = array(), $con = array(), $table)
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->update($table, $data, $con);
            if ($this->db->trans_status() === FALSE) 
            {
		        $this->db->trans_rollback();
		        return false;
		    } else 
		    {
		        $this->db->trans_commit();
		        return true;
		    }
        }
        return false;
	}

	public function delete($table, $condition = array())
	{
		$this->db->trans_begin();
	    $this->db->trans_strict(TRUE);
        $this->db->delete($table, $condition);

	    if ($this->db->trans_status() === FALSE) 
	    {
	        $this->db->trans_rollback();
	        return false;
	    } else 
	    {
	        $this->db->trans_commit();
	        return true;
	    }
	}

}

/* End of file Records_in_charge_model.php */
/* Location: ./application/models/Records_in_charge_model.php */