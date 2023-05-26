<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Applicant_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
  }

  // ------------------------------------------------------------------------


  // ------------------------------------------------------------------------
  public function getLetterContent($applicantID = "", $applicantType = 0)
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('*');
    $applicantDB->from('tbl_letter');
    $applicantDB->where('type', $applicantType);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function getApplicantInfo($applicantID = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('tbl_profile.*, tbl_program.*');
    $applicantDB->from('tbl_profile');
    $applicantDB->join('tbl_program', 'tbl_profile.program_id = tbl_program.program_id', 'inner');
    $applicantDB->where('tbl_profile.applicant_id', $applicantID);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function checkSlot($programID = 0)
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('*');
    $applicantDB->from('tbl_program');
    $applicantDB->where('program_id', $programID);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function checkTotalEnroll($programID)
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('tbl_enrollment_form.applicant_id');
    $applicantDB->from('tbl_enrollment_form');
    $applicantDB->join('tbl_profile', 'tbl_enrollment_form.applicant_id = tbl_profile.applicant_id', 'inner');
    $applicantDB->where('tbl_profile.program_id', $programID);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function getApplicantRank($programID)
  {
    /**
     * SELECT tbl_applicant_ranking.percentile_rank FROM tbl_applicant_ranking INNER JOIN tbl_profile ON tbl_applicant_ranking.applicant_id = tbl_profile.applicant_id WHERE tbl_profile.program_id = 4 ORDER BY tbl_applicant_ranking.percentile_rank DESC; 
     */

    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('tbl_applicant_ranking.percentile_rank');
    $applicantDB->from('tbl_applicant_ranking');
    $applicantDB->join('tbl_profile', 'tbl_applicant_ranking.applicant_id = tbl_profile.applicant_id', 'inner');
    $applicantDB->where('tbl_profile.program_id', $programID);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function getApplicantIndividualRank($applicantID = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('percentile_rank');
    $applicantDB->from('tbl_applicant_ranking');
    $applicantDB->where('applicant_id', $applicantID);
    $query = $applicantDB->get();

    return $query->result();
  }

  public function getReleaseDate($applicantType = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('*');
    $applicantDB->from('tbl_release');
    $applicantDB->where('type', $applicantType);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function get_applicant_info($applicant_id = "")
  {
    $db2 = $this->load->database('applicantDB', TRUE);
    $db2->select("tbl_enrollment_form.*, tbl_profile.*, tbl_religion.religion_name, tbl_citizenship.citizenship_name, tbl_confirmation.confirmation_date");
    $db2->from('tbl_enrollment_form');
    $db2->join('tbl_profile', 'tbl_enrollment_form.applicant_id = tbl_profile.applicant_id', 'inner');
    $db2->join('tbl_confirmation', 'tbl_profile.applicant_id = tbl_confirmation.confirmation_id', 'inner');
    $db2->join('tbl_religion', 'tbl_enrollment_form.religion_id = tbl_religion.religion_id', 'inner');
    $db2->join('tbl_citizenship', 'tbl_enrollment_form.citizenship_id = tbl_citizenship.citizenship_code', 'inner');
    $db2->where('tbl_enrollment_form.applicant_id', $applicant_id);
    $query = $db2->get();
    return $query->result();
  }

  public function get_student_info($appID = "")
  {
    $db2 = $this->load->database('applicantDB', TRUE);
    $db2->select("tbl_profile.applicant_id, tbl_enrollment_form.student_email, tbl_program.program_name, tbl_college.college_desc");
    $db2->from('tbl_profile');
    $db2->join('tbl_program', 'tbl_profile.program_id = tbl_program.program_id', 'inner');
    $db2->join('tbl_college', 'tbl_program.college_id = tbl_college.college_id', 'inner');
    $db2->join('tbl_enrollment_form', 'tbl_profile.applicant_id = tbl_enrollment_form.applicant_id', 'inner');
    $db2->where('tbl_profile.applicant_id', $appID);
    $query = $db2->get();
    return $query->result();
  }

  public function getProgram($qoutaProgram = "")
  {
    $db2 = $this->load->database('applicantDB', TRUE);
		$db2->select("*");
    $db2->from('tbl_program');
    $db2->where('qouta_program', $qoutaProgram);
    $query = $db2->get();
    return $query->result();
  }

  public function get_data_privacy($applicant)
	{
    $db2 = $this->load->database('applicantDB', TRUE);
		$db2->select("*");
    $db2->from('tbl_data_privacy_logs');
    $db2->where('user_id', $applicant);
    $db2->where('semester_id', 6);
    $query = $db2->get();
    return $query->result();
	}

  public function getConfirmation($applicantID = "")
  {
    $applicantDB = $this->load->database('applicantDB', TRUE);
    $applicantDB->select('*');
    $applicantDB->from('tbl_confirmation');
    $applicantDB->where('confirmation_id', $applicantID);

    $query = $applicantDB->get();

    return $query->result();
  }

  public function save($table, $data = array())
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->trans_begin();
    $applicantDB->trans_strict(TRUE);

    $applicantDB->insert($table, $data);

    if ($applicantDB->trans_status() === FALSE) {
        $applicantDB->trans_rollback();
        return false;
    } else {
        $applicantDB->trans_commit();
        return true;
    }
	}

  public function updateForm($data = array(), $con = array(), $table = array())
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		if(!empty($data)){
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

  // ------------------------------------------------------------------------

}

/* End of file Applicant_model_model.php */
/* Location: ./application/models/Applicant_model_model.php */