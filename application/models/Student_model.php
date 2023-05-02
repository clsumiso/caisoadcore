<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function getSemester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		// $this->db->where('semester_id <= 6');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

    public function getGrades($userID = "", $semesterID = "", $status = array())
    {
        $this->db->select('*');
		$this->db->from('tbl_grades');
		$this->db->where('user_id', $userID);
		$this->db->where('semester_id', $semesterID);
		$this->db->where_in('status', $status);
		$query = $this->db->get();

		return $query->result();
    }

    /*
    * Datatables
    */
    public function getGradeList($userID = "", $semesterID = "", $status = array())
    {
        if ($semesterID <= 2)
        {
            $this->db->select('*');
            $this->db->from('tbl_grades');
            $this->db->where('user_id', $userID);
            $this->db->where('semester_id', $semesterID);
            $this->db->where_in('status', $status);
            $query = $this->db->get();
        }else
        {
            if ($semesterID == 3)
            {
                $this->db->select('tbl_registration.user_id, tbl_registration.schedid, tbl_class_schedule.cat_no, tbl_class_schedule.units, tbl_grades.grades, tbl_grades.reexam, tbl_grades.status');
                $this->db->from('tbl_registration');
                $this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
                $this->db->join('tbl_grades', 'tbl_class_schedule.cat_no = tbl_grades.subject', 'inner');
                $this->db->where('tbl_registration.user_id', $userID);
                $this->db->where('tbl_grades.user_id', $userID);
                $this->db->where('tbl_registration.semester_id', $semesterID);
                $this->db->where('tbl_registration.status', 2);
                $this->db->where('tbl_grades.semester_id', $semesterID);
                $this->db->where_in('tbl_grades.status', $status);
                $query = $this->db->get();
            }else
            {
                $this->db->select('tbl_registration.user_id, tbl_registration.schedid, tbl_class_schedule.cat_no, tbl_class_schedule.units, tbl_grades.grades, tbl_grades.reexam, tbl_grades.status');
                $this->db->from('tbl_registration');
                $this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
                $this->db->join('tbl_grades', 'tbl_class_schedule.cat_no = tbl_grades.subject', 'inner');
                $this->db->where('tbl_registration.user_id', $userID);
                $this->db->where('tbl_grades.user_id', $userID);
                $this->db->where('tbl_registration.semester_id', $semesterID);
                $this->db->where('tbl_registration.ra_status', "approved");
                $this->db->where('tbl_grades.semester_id', $semesterID);
                $this->db->where_in('tbl_grades.status', $status);
                $query = $this->db->get();
            }
        }
        return $query->result();
    }
    /*
    * End of the datatable 
    */
}

/* End of file Student_model.php */
/* Location: ./application/models/Student_model.php */