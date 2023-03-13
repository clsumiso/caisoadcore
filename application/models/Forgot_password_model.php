<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forgot_password_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function check_email($email='')
	{
		$query = $this->db->query("SELECT tbl_users.user_id FROM tbl_profile INNER JOIN tbl_users ON tbl_profile.user_id = tbl_users.user_id WHERE tbl_profile.email = '$email'");

		return $query->result();
	}

	public function get_user_credential($user_id='')
	{
		$query = $this->db->query("SELECT * FROM tbl_users WHERE user_id = '$user_id'");

		return $query->result();
	}

	public function update($table, $data, $where)
	{
		return $this->db->update($table, $data, $where);
	}
}
