<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function get_user_info($email, $password)
  {
    $this->db->select("tbl_profile.profile_id, tbl_profile.email, tbl_profile.fname, tbl_profile.lname, tbl_profile.year_level, tbl_users.uname, tbl_users.user_type, tbl_users.status, tbl_profile.sex, tbl_course.course_name");
    $this->db->from('tbl_profile');
    $this->db->join('tbl_users', 'tbl_profile.profile_id = tbl_users.profile_id', 'inner');
    $this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
    $this->db->group_start();
    $this->db->where('tbl_profile.email', $email);
    $this->db->or_where('tbl_users.uname', $email);
    $this->db->group_end();
    $this->db->where('tbl_users.upass', $password);
    $query = $this->db->get();
    return $query->result();
  }

<<<<<<< Updated upstream
  public function update($data, $condition = array(), $table = "") 
=======
  public function update($data = array(), $condition = array(), $table ="") 
>>>>>>> Stashed changes
  {
    $this->db->trans_begin();
    $this->db->trans_strict(TRUE);
    $this->db->update($table, $data, $condition);

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
    } else {
        $this->db->trans_commit();
        return true;
    }
  }
}

/* End of file Login_model_model.php */
/* Location: ./application/models/Login_model_model.php */