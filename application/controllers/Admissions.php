<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 *
 * Controller Admissions
 *
 * This controller for ...
 *
 * @package   CodeIgniter
 * @category  Controller CI
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @author    Raul Guerrero <r.g.c@me.com>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Admissions extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
		$this->load->helper('date');
    $this->load->model('admissions_model', 'admissions');
  }

  public function index()
  {
    if (!isset($_SESSION['uid'])) 
    {
      redirect('/');
    }

    $data = array(
			'name'				=>	$_SESSION['account_name'],
			'user_type'		=>	strtoupper($_SESSION['utype']),
			'email'				=>	$_SESSION['e_id'],
			'get_time'		=>	$this->get_time()
		);

    $this->load->view('admissions/_header', $data);
    $this->load->view('admissions/_css', $data);
    $this->load->view('admissions/admissions_view', $data);
    $this->load->view('admissions/_footer', $data);
    $this->load->view('admissions/_js', $data);
  }

  public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

  public function applicantList()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->admissions->getApplicants($postData);

		echo json_encode($data);
	}

}


/* End of file Admissions.php */
/* Location: ./application/controllers/Admissions.php */