<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->model('student_model', 'student');
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
		$this->load->view('students/_header', $data);
	    $this->load->view('students/_css', $data);
	    $this->load->view('students/student_view', $data);
	    $this->load->view('students/_footer', $data);
	    $this->load->view('students/_js', $data);
	}

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

	public function semester()
	{
		$semester_data = $this->student->get_semester();
		$htmlContent = '<option value="#">-- SELECT SEMESTER --</option>';

		foreach ($semester_data as $semester) 
		{
			$htmlContent .= '<option value="'.$semester->semester_id.'">'.$semester->semester_name.' '.$semester->semester_year.'</option>';
		}

		return $htmlContent;
	}

}

/* End of file Student.php */
/* Location: ./application/controllers/Student.php */