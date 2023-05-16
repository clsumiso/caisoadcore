<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Application_model
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

class Admission_application_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // ------------------------------------------------------------------------
  public function gerGraduateProgram($courseType = array())
  {
    $this->db->select("course_id, course_name, course_desc");
    $this->db->from("tbl_course");
    $this->db->where_in("course_type", $courseType);
    $this->db->order_by("course_desc", 'desc');
    $query = $this->db->get();

    return $query->result();
  }

  public function getApplicationID($applicationID = "")
  {
    
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select("oad0001.application_id, tbl_course.course_desc");
    $applicantDB->from("oad0001");
    $applicantDB->join("tbl_course", "oad0001.field_of_study = tbl_course.course_id", "inner");
    $applicantDB->where("oad0001.application_id", $applicationID);
    $query = $applicantDB->get();

    return $query->result();
  }

  public function getApplication($applicationID = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select("oad0001.*, tbl_course.course_desc, tbl_course.course_name");
    $applicantDB->from("oad0001");
    $applicantDB->join("tbl_course", "oad0001.field_of_study = tbl_course.course_id", "inner");
    $applicantDB->where("oad0001.application_id", $applicationID);
    $query = $applicantDB->get();

    return $query->result();
  }

  public function checkReference($applicantID = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select("*");
    $applicantDB->from("oad0002");
    $applicantDB->where("applicant_id", $applicationID);
    $query = $applicantDB->get();

    return $query->result();
  }

  public function checkRequest($applicationID, $referenceEmail)
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select("*");
    $applicantDB->from("oad0003");
    $applicantDB->where("application_id", $applicationID);
    $applicantDB->where("reference_email", $referenceEmail);
    $query = $applicantDB->get();

    return $query->result();
  }

  public function getEmailLogs($applicationID = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select("oad0004.reference_name, oad0004.email, oad0004.status, oad0004.modified, oad0001.lname, oad0001.fname, oad0001.mname, oad0001.reference");
    $applicantDB->from("oad0004");
    $applicantDB->join("oad0001", "oad0004.application_id = oad0001.application_id", "inner");
    $applicantDB->where("oad0004.application_id", $applicationID);
    $query = $applicantDB->get();

    return $query->result();
  }

  // ------------------------------------------------------------------------
  /**
	 * CRUD
	 */
	public function save($table, $data = array())
	{
    $applicantDB = $this->load->database('applicantDB', TRUE);

		$applicantDB->trans_begin();
        $applicantDB->trans_strict(TRUE);

        $applicantDB->insert($table, $data);

        if ($applicantDB->trans_status() === FALSE) 
        {
            $applicantDB->trans_rollback();
            return false;
        } else 
        {
            $applicantDB->trans_commit();
            return true;
        }
	}

	public function update($data = array(), $con = array(), $table = array())
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->update($table[0], $data, $con);
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

	public function updateAdmission($data = array(), $con = array(), $table = array())
	{
    
    $applicantDB = $this->load->database('applicantDB', TRUE);
		if(!empty($data))
    {
			$applicantDB->trans_begin();
      $applicantDB->trans_strict(TRUE);

      // Insert member data
      $applicantDB->update($table[0], $data, $con);
      if ($applicantDB->trans_status() === FALSE) 
      {
          $applicantDB->trans_rollback();
          return false;
      } else 
      {
          $applicantDB->trans_commit();
          return true;
      }
    }
    return false;
	}
	/**
	 * END OF CRUD
	 */

  // ------------------------------------------------------------------------

}

/* End of file Application_model.php */
/* Location: ./application/models/Application_model.php */