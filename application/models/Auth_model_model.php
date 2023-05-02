<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Auth_model_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Auth_model_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function index()
  {
    
  }

  public function get_account($uname, $upass)
  {
    $this->db->select("*");
    $this->db->from("tbl_users");
    $this->db->where("uname", $uname);
    $this->db->where("upass", $uname);
  }

  // ------------------------------------------------------------------------

}

/* End of file Auth_model_model.php */
/* Location: ./application/models/Auth_model_model.php */