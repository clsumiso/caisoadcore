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
    $this->load->helper('download');
    $this->load->model('admissions_model', 'admissions');
  }

  public function index()
  {
    if (!isset($_SESSION['uid'])) 
    {
      redirect('/');
    }else
    {
      if (isset($_SESSION['utype']))
      {
        if ($_SESSION['utype'] != "admissions")
        {
          redirect('/');
        }
      }else
      {
        redirect('/');
      }
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

  public function graduate_level()
  {
    if (!isset($_SESSION['uid'])) 
    {
      redirect('/');
    }else
    {
      if (isset($_SESSION['utype']))
      {
        if ($_SESSION['utype'] != "admissions_graduate")
        {
          redirect('/');
        }
      }else
      {
        redirect('/');
      }
    }

    $data = array(
			'name'				=>	$_SESSION['account_name'],
			'user_type'		=>	strtoupper($_SESSION['utype']),
			'email'				=>	$_SESSION['e_id'],
			'get_time'		=>	$this->get_time()
		);

    $this->load->view('grad_level_admissions/_header', $data);
    $this->load->view('grad_level_admissions/_css', $data);
    $this->load->view('grad_level_admissions/admissions_view', $data);
    $this->load->view('grad_level_admissions/_footer', $data);
    $this->load->view('grad_level_admissions/_js', $data);
  }

  public function graduateLevelList()
  {
    // POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->admissions->getGraduateApplicants($postData);

		echo json_encode($data);
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

  public function downloadRequirements($directory = "", $filename = "")
  {
    force_download('/uploads/graduate_level_requirements/'.$directory.'/'.$filename, NULL);
  }

  public function departmentEndorse()
  {
    $applicationID = $_POST['appID'];
    $msg = array();

    $data = array(
      "department_remarks" =>  "pending"
    );

    $condition = array(
      "application_id"  =>  $applicationID
    );

    $endorse = $this->admissions->update($data, $condition, array("oad0003"));
    if ($endorse !== false)
    {
      $msg = array(
        "sys_msg" =>  "success",
        "msg"     =>  "Application forwarded successfully",
        "type"    =>  "success"
      );
    }else
    {
      $msg = array(
        "sys_msg" =>  "failed",
        "msg"     =>  "Application forwarding failed",
        "type"    =>  "error"
      );
    }

    echo json_encode($msg);
  }

}


/* End of file Admissions.php */
/* Location: ./application/controllers/Admissions.php */