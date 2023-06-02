<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

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

}

/* End of file Student_model.php */
/* Location: ./application/models/Student_model.php */