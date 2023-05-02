<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('computation');
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
			'semester'			=>	$this->semesterList(),
			'get_time'			=>	$this->get_time()
		);
		$this->load->view('students/_header', $data);
	    $this->load->view('students/_css', $data);
	    $this->load->view('students/student_view', $data);
	    $this->load->view('students/_footer', $data);
	    $this->load->view('students/_js', $data);
	}

	public function semesterList()
    {
        $semesterData = $this->student->getSemester();
        $htmlData = '<option value="-1" selected>--- SELECT SEMESTER ---</option>';

        foreach ($semesterData as $semester) 
        {
            $htmlData .= '<option value="'.$semester->semester_id.'">'.($semester->semester_name." ".$semester->semester_year).'</option>';
        }

        return $htmlData;
    }

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

	/*
	* Datatables
	*/

	public function gradeList()
	{
		// Get data
		$gradeData = $this->student->getGradeList($_SESSION['uid'], $_POST['semesterID'], array('approved'));
		$htmlData = "";

		foreach ($gradeData as $grade) 
		{
			if ($_POST['semesterID'] <= 2)
			{
				$htmlData = "<tr>";
					$htmlData = "<td></td>";
					$htmlData = "<td>".$grade->subject."</td>";
					$htmlData = "<td>".$grade->units."</td>";
					$htmlData = "<td>".$grade->grades."</td>";
					$htmlData = "<td>".$grade->reexam."</td>";
					$htmlData = "<td>".$grade->status."</td>";
				$htmlData = "</tr>";
			}else
			{
				$htmlData = "<tr>";
					$htmlData = "<td>".$grade->schedid."</td>";
					$htmlData = "<td>".$grade->cat_no."</td>";
					$htmlData = "<td>".$grade->units."</td>";
					$htmlData = "<td>".$grade->grades."</td>";
					$htmlData = "<td>".$grade->reexam."</td>";
					$htmlData = "<td>".$grade->status."</td>";
				$htmlData = "</tr>";
			}
			
		}

		echo json_encode(array("gradeData"	=>	$htmlData));
	}

	/*
	* End of Datatables
	*/

	/*
	* ANALYTICS
	*
	*/
	public function gradesPieChart()
	{
		$gradeData = $this->student->getGrades($_SESSION['uid'], $_POST['semesterID'], array('approved'));
		$output = array();
		foreach ($gradeData as $grade) 
		{
			if (is_numeric($grade->grades) || is_float($grade->grades) || is_numeric($grade->reexam) || is_float($grade->reexam)) 
			{
				$data = array(
					'cat_no'	=>	$grade->subject,
					'value'		=>	$grade->reexam == '' ? floatval($grade->grades) : floatval($grade->reexam)
				);
			}
	
			array_push($output, $data);
		}

		echo json_encode($output);
	}
	/* 
	* End of Analytics
	*/

}

/* End of file Student.php */
/* Location: ./application/controllers/Student.php */