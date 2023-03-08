<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enrollment_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_tuition($semester)
    {
        $this->db->select("*");
        $this->db->from('tbl_tuition_fee');
        $this->db->where('semester_id', $semester);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_admission_entrance_fee($semester)
    {
        $this->db->select("*");
        $this->db->from('tbl_admission_fee');
        $this->db->where('semester_id', $semester);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_athletic_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_athletic_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_computer_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_computer_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_development_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_development_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_entrance_fee_new()
    {
        $this->db->select("*");
        $this->db->from('tbl_entrance_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_laboratory_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_laboratory_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_guidance_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_guidance_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_library_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_libary_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_medical_dental()
    {
        $this->db->select("*");
        $this->db->from('tbl_medical_dental_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_registration_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_medical_dental_fee');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_school_id_fee()
    {
        $this->db->select("*");
        $this->db->from('tbl_school_id_fee');
        $query = $this->db->get();
        return $query->result();
    }
    /* END OF FEES */

    public function get_no_tosf($user_id)
    {
        $this->db->select("user_id");
        $this->db->from('tbl_no_tosf');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_registered_students($semester, $user_id)
    {
        $this->db->select("user_id");
        $this->db->from('tbl_registration');
        $this->db->where('semester_id', $semester);
        $this->db->where('user_id', $user_id);
        // $this->db->where('ra_status', 'approved');
        // $this->db->where('tbl_registration.user_id', '21-1111');
        //$this->db->limit(1);
        $this->db->group_by(array("tbl_registration.user_id"));

        $query = $this->db->get();
        return $query->result();
    }

    public function get_course_type()
    {
        $this->db->select("course_id, course_type");
        $this->db->from('tbl_course');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_class_schedule($schedid, $semester)
    {
        $this->db->select("*");
        $this->db->from('tbl_class_schedule');
        $this->db->where('schedid', $schedid);
        $this->db->where('semester_id', $semester);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_semester($semester_id)
    {
        $this->db->select("*");
        $this->db->from('tbl_semester');
        $this->db->where('semester_id', $semester_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function getActiveSemester()
    {
        $this->db->select("semester_id");
        $this->db->from('tbl_semester');
        $this->db->where('semester_status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentInfo($userID, $semesterID)
    {
        $this->db->select("tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name, tbl_enrollment.section");
        $this->db->from('tbl_profile');
        $this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
        $this->db->join('tbl_enrollment', 'tbl_profile.user_id = tbl_enrollment.user_id', 'inner');
        $this->db->where('tbl_profile.user_id', $userID);
        $this->db->where('tbl_enrollment.user_id', $userID);
        $this->db->where('tbl_enrollment.semester_id', $semesterID);
        $query = $this->db->get();
        return $query->result();
    }

    public function check_scholarship($user_id, $semester)
    {
        $query = $this->db->query("SELECT * FROM tbl_scholarship WHERE user_id = '$user_id' AND semester_id = '$semester'");
        return $query->result();
    }

    public function check_payment($user_id, $semester)
    {
        $query = $this->db->query("SELECT SUM(amount) AS amount, transaction_id, date_of_payment FROM tbl_payment WHERE user_id = '$user_id' AND semester_id = '$semester'");
        return $query->result();
    }

    public function get_student_enrollment($user_id, $semester)
    {
        /* $this->db->select("tbl_registration.schedid, tbl_registration.status, tbl_class_schedule.units, tbl_class_schedule.class_type, tbl_class_schedule.lab_type");
        $this->db->from('tbl_registration');
        $this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
        $this->db->where('tbl_registration.status', 2);
        $this->db->where('tbl_registration.user_id', $user_id);
        $query = $this->db->get(); */
        if ($semester == 3) 
        {
            $query = $this->db->query("SELECT tbl_registration.user_id, tbl_registration.schedid, tbl_registration.status, tbl_registration.ra_status, tbl_class_schedule.units, tbl_class_schedule.class_type, tbl_class_schedule.lab_type, tbl_class_schedule.weight FROM tbl_registration, tbl_class_schedule WHERE tbl_registration.schedid = tbl_class_schedule.schedid AND tbl_registration.status = 2 AND tbl_registration.user_id = '$user_id' AND tbl_registration.semester_id = '$semester'");
        }else
        {
            $query = $this->db->query("SELECT tbl_registration.user_id, tbl_registration.schedid, tbl_registration.status, tbl_registration.ra_status, tbl_class_schedule.units, tbl_class_schedule.class_type, tbl_class_schedule.lab_type, tbl_class_schedule.weight FROM tbl_registration, tbl_class_schedule WHERE tbl_registration.schedid = tbl_class_schedule.schedid AND tbl_registration.ra_status = 'approved' AND tbl_registration.user_id = '$user_id' AND tbl_registration.semester_id = '$semester'");
        }
        
        return $query->result();
    }

    public function getRegistration($userID, $semesterID)
    {
        $this->db->select("tbl_registration.schedid, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name, tbl_enrollment.section");
        $this->db->from('tbl_registration');
        $this->db->join('tbl_profile', 'tbl_registration.user_id = tbl_profile.user_id', 'inner');
        $this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
        $this->db->join('tbl_enrollment', 'tbl_profile.user_id = tbl_enrollment.user_id', 'inner');
        $this->db->where('tbl_profile.user_id', $userID);
        $this->db->where('tbl_registration.user_id', $userID);
        $this->db->where('tbl_enrollment.user_id', $userID);
        $this->db->where('tbl_registration.semester_id', $semesterID);
        if ($semesterID == 3) 
        {
            $this->db->where('tbl_registration.status', 2);
        }else
        {
            $this->db->where('tbl_registration.ra_status', 'approved');
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_student_enrollment_ric($user_id, $semester)
    {
        /* $this->db->select("tbl_registration.schedid, tbl_registration.status, tbl_class_schedule.units, tbl_class_schedule.class_type, tbl_class_schedule.lab_type");
        $this->db->from('tbl_registration');
        $this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
        $this->db->where('tbl_registration.status', 2);
        $this->db->where('tbl_registration.user_id', $user_id);
        $query = $this->db->get(); */
        if ($semester <= 3){
            $query = $this->db->query("SELECT tbl_registration.user_id, tbl_registration.schedid, tbl_registration.status, tbl_class_schedule.units, tbl_class_schedule.class_type, tbl_class_schedule.lab_type, tbl_class_schedule.weight FROM tbl_registration, tbl_class_schedule WHERE tbl_registration.schedid = tbl_class_schedule.schedid AND tbl_registration.status = '2' AND tbl_registration.user_id = '$user_id' AND tbl_registration.semester_id = '$semester'");
            return $query->result_array();
        }else{
            $query = $this->db->query("SELECT tbl_registration.user_id, tbl_registration.schedid, tbl_registration.status, tbl_class_schedule.units, tbl_class_schedule.class_type, tbl_class_schedule.lab_type, tbl_class_schedule.weight FROM tbl_registration, tbl_class_schedule WHERE tbl_registration.schedid = tbl_class_schedule.schedid AND tbl_registration.ra_status = 'approved' AND tbl_registration.user_id = '$user_id'");
            return $query->result_array();
        }
    }

    public function get_student_information($user_id)
    {
        $query = $this->db->query("SELECT tbl_profile.user_id, tbl_profile.course_id, tbl_profile.fname, tbl_profile.mname, tbl_profile.lname, tbl_profile.sex, tbl_profile.student_type, tbl_profile.enroll_status, tbl_profile.year_level, tbl_profile.student_type, tbl_course.course_name, tbl_course.course_type, tbl_college.college_name FROM tbl_profile, tbl_course, tbl_college WHERE tbl_profile.course_id = tbl_course.course_id AND tbl_course.college_id = tbl_college.college_id AND tbl_profile.user_id = '$user_id'");
        return $query->result();
    }

    public function get_enroll_count($user_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_registration');
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 2);
        $this->db->group_by(array('semester_id'));
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student_section($user_id, $semester)
    {
        $this->db->select('section, registration_only_tag');
        $this->db->from('tbl_enrollment');
        $this->db->where('user_id', $user_id);
        $this->db->where('semester_id', $semester);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_mid_year_enrolled($student_id = array())
    {
        $this->db->select('user_id');
        $this->db->from('tbl_registration');
        $this->db->where('ra_status', 'approved');
        // $this->db->where('status', 2);
        $this->db->where('semester_id', 6);
        // $this->db->where_in('user_id', $student_id);
        $this->db->group_by(array("user_id"));
        $query = $this->db->get();
        return $query->result();
    }
}