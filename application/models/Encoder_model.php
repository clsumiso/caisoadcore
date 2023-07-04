<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Encoder_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->table = '';
	}

	public function get_student_info($user_id, $semester_id)
	{
		// $query  =   $this->db->query("SELECT tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_desc, tbl_enrollment.section FROM tbl_profile INNER JOIN tbl_course ON tbl_profile.course_id = tbl_course.course_id INNER JOIN tbl_enrollment ON tbl_profile.user_id = tbl_enrollment.user_id WHERE tbl_profile.user_id = '$user_id' AND tbl_enrollment.user_id = '$user_id' AND tbl_enrollment.semester_id = '$semester_id'");
        // return $query->result();

        $this->db->select('user_id, lname, fname, mname');
        $this->db->from('tbl_profile');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        return $query->result();
	}

    public function get_enrollment($user_id, $semester_id)
    {
        $query  =   $this->db->query("SELECT tbl_registration.schedid, tbl_registration.semester_id, tbl_registration.ra_status, tbl_registration.decline_reason, tbl_class_schedule.cat_no, tbl_class_schedule.day, tbl_class_schedule.time, tbl_class_schedule.room, tbl_class_schedule.units, tbl_class_schedule.weight, tbl_class_schedule.section FROM tbl_registration INNER JOIN tbl_class_schedule ON tbl_registration.schedid = tbl_class_schedule.schedid WHERE tbl_registration.user_id = '$user_id' AND tbl_registration.semester_id = '$semester_id' AND tbl_class_schedule.semester_id = '$semester_id'");
        return $query->result();
    }

    public function getClassScheduleByFilter($filter, $semester_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_class_schedule');

        $this->db->group_start();
            $this->db->like('schedid', $filter, 'both');
            $this->db->or_like('cat_no', $filter, 'both');
            $this->db->or_like('section', $filter, 'both');
        $this->db->group_end();
            $this->db->where('semester_id', $semester_id);
        $query = $this->db->get();

        return $query->result();
    }

	public function get_class_schedule($section, $semester_id)
	{
		$query  =   $this->db->query("SELECT * FROM tbl_class_schedule WHERE section = '$section' AND semester_id = '$semester_id'");
        return $query->result();
	}
	
	public function get_enrolled($schedid, $status, $semester_id)
    {
        $this->db->select('schedid');
        $this->db->from('tbl_registration');
        $this->db->where('semester_id', $semester_id);
        $this->db->where('schedid', $schedid);
        if ($status == '') 
        {
            $this->db->where('ra_status IS NULL');
        }else
        {
            $this->db->where('ra_status', $status);
        }
        

        $query = $this->db->get();

        return $query->result();
    }

	public function get_not_allowed_to_enroll($user_id, $semester_id)
    {
        $query  =   $this->db->query("SELECT * FROM tbl_decline_enrollment WHERE user_id = '$user_id' AND semester_id = '$semester_id'");
        return $query->result();
    }

    public function check_if_registered($schedid, $user_id, $semester_id)
    {
        $query = $this->db->query("SELECT * FROM tbl_registration WHERE schedid = '$schedid' AND user_id = '$user_id' AND semester_id = '$semester_id'");
        return $query->result();
    }

    public function subject_slot($schedid, $semester)
    {
        $query = $this->db->query("SELECT no_of_slot FROM tbl_class_schedule WHERE schedid = '$schedid' AND semester_id = '$semester'");
        return $query->result();
    }

    public function check_slot($schedid, $semester)
    {
        $query = $this->db->query("SELECT schedid FROM tbl_registration WHERE schedid = '$schedid' AND semester_id = '$semester'");
        return $query->result();
    }

    public function check_enrollment($user_id, $semester_id)
    {
        $query = $this->db->query("SELECT enrollment_id, section FROM tbl_enrollment WHERE user_id = '$user_id' AND semester_id = '$semester_id'");
        return $query->result();
    }

    public function getCollege()
    {
        $this->db->select('*');
        $this->db->from('tbl_college');
        $this->db->where('college_id <=', 10);
        $query = $this->db->get();

        return $query->result();
    }

    public function getCourse($collegeID)
    {
        $this->db->select('*');
        $this->db->from('tbl_course');
        $this->db->where('college_id', $collegeID);
        $this->db->where_in('course_type', array('B', 'BS', 'BA', 'D', 'MS', 'PhD', 'MA'));
        $query = $this->db->get();

        return $query->result();
    }

    public function getSection($courseID)
    {
        $this->db->distinct();
        $this->db->select('section');
        $this->db->from('tbl_class_schedule');
        $this->db->where('course_id', $courseID);
        $this->db->where('semester_id', 7);
        $query = $this->db->get();

        return $query->result();
    }

    public function save_cog_logs($data, $table)
    {
        // $this->db->insert($table, $data);
        // return $this->db->insert_id();

        if(!empty($data)){
            // Insert member data
            $insert = $this->db->insert($table, $data);
            
            // Return the status
            return $insert ? $this->db->insert_id() : false;
        }
        return false;
    }

    public function save($data = array()) {
        if(!empty($data)){
            // Insert member data
            $insert = $this->db->insert($this->table, $data);
            
            // Return the status
            return $insert ? $this->db->insert_id() : false;
        }
        return false;
    }

    public function delete($condition = array())
    {
        $query = $this->db->delete($this->table, $condition);

        return $query;
    }
}

/* End of file Encoder_model.php */
/* Location: ./application/models/Encoder_model.php */