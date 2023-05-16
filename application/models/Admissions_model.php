<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Admissions_model
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

class Admissions_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    $this->database->load();
  }

  // ------------------------------------------------------------------------

}

/* End of file Admissions_model.php */
/* Location: ./application/models/Admissions_model.php */