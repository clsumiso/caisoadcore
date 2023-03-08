<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounting_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getNonFreeTuition()
	{
		$this->db->distinct();
		$this->db->select('user_id');
		$this->db->from('tbl_no_tosf');
		$this->db->order_by('user_id', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getGradStudent($course = array())
	{
		$this->db->select('tbl_profile.user_id, tbl_course.course_type');
		$this->db->from('tbl_profile');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->where_in('tbl_course.course_type', $course);
		$this->db->order_by('user_id', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getSemester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		$this->db->where('semester_id > 2');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getPayment($user_id, $semester_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_payment');
		$this->db->where('user_id', $user_id);
		$this->db->where('semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function save($table, $data = array())
	{
		$this->db->trans_begin();
        $this->db->trans_strict(TRUE);

        $this->db->insert($table, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
	}

	public function getStudentRegistation($userID = array())
	{
		// code...
	}

}

/* End of file Accounting_model.php */
/* Location: ./application/models/Accounting_model.php */