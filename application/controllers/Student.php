<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (!isset($_SESSION['uid'])) 
        {
        	redirect('/');
        }

		$data = array(
			'name'				=>	$_SESSION['account_name'],
			'user_type'			=>	strtoupper($_SESSION['utype']),
			'email'				=>	$_SESSION['e_id'],
			'semester'			=>	$this->semester(),
			'get_time'			=>	$this->get_time()
		);
		$this->load->view('student/_header', $data);
	    $this->load->view('student/_css', $data);
	    $this->load->view('student/student_view', $data);
	    $this->load->view('student/_footer', $data);
	    $this->load->view('student/_js', $data);
	}

}

/* End of file Student.php */
/* Location: ./application/controllers/Student.php */