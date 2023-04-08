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
	/**
	 * END OF CRUD
	 */

  // ------------------------------------------------------------------------

}

/* End of file Application_model.php */
/* Location: ./application/models/Application_model.php */