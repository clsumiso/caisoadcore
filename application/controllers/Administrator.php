<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('computation');
		$this->load->helper('date');
		$this->load->model('administrator_model', 'administrator');
		$this->load->helper('directory');
		if (!isset($_SESSION['uid'])) 
        {
        	redirect('/');
        }
	}

	public function index()
	{
		if (!isset($_SESSION['uid'])) 
        {
        	redirect('/');
        }

		$data = array(
			'name'		=>	$_SESSION['account_name'],
			'user_type'	=>	strtoupper($_SESSION['utype']),
			'email'		=>	$_SESSION['e_id'],
			'get_time'	=>	$this->get_time(),
            'semester'  =>  $this->semesterList(),
            'college'  =>  $this->collegeList()
		);
		$this->load->view('administrator/_header', $data);
	    $this->load->view('administrator/_css', $data);
	    $this->load->view('administrator/administrator_view', $data);
	    $this->load->view('administrator/_footer', $data);
	    $this->load->view('administrator/_js', $data);
	}

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

	public function semesterList()
    {
        $semesterData = $this->administrator->getSemester();
        $htmlData = '<option value="-1" selected>--- SELECT SEMESTER ---</option>';

        foreach ($semesterData as $semester) 
        {
            $htmlData .= '<option value="'.$semester->semester_id.'">'.($semester->semester_name." ".$semester->semester_year).'</option>';
        }

        return $htmlData;
    }

	public function collegeList()
    {
        $collegeData = $this->administrator->getCollege();
        $htmlData = '<option value="-1" selected>--- SELECT COLLEGE ---</option>';

        foreach ($collegeData as $college) 
        {
            $htmlData .= '<option value="'.$college->college_id.'">'.$college->college_name.'</option>';
        }

        return $htmlData;
    }

	public function getCourse()
	{
		$college = $_POST['college'];
        $htmlData = '<option value="-1" selected>--- SELECT COURSE ---</option>';

		$courseData = $this->administrator->getCourse($college);
		foreach ($courseData as $course) 
        {
			if (!in_array($course->course_id, array(0, 144, 145)))
			{
				$htmlData .= '<option value="'.$course->course_id.'">'.$course->course_desc.'</option>';
			}
        }

		echo json_encode(array("course"	=>	$htmlData));
	}

    public function scheduleList()
    {

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->administrator->getSchedule($postData);

		echo json_encode($data);
   	}

	public function sectionMonitoringList()
	{

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->administrator->getClassMonitoring($postData);

		echo json_encode($data);
	}

	/*Analytics*/
   	public function enrollPerCollegeChart()
   	{	
		$semester = $_POST['sem'];
		$course = array();
		$output = array();
		$college = array('CAG', 'CASS', 'CBAA', 'CED', 'CEN', 'CF', 'CHSI', 'COS', 'CVSM');
		$collegeValue = array();
		$pictureArr = array();
		$cag = $cass = $cbaa = $ced = $cen = $cf = $chsi = $cos = $cvsm = 0;
		$chartData = $this->administrator->getEnrollPerCollege($semester, $course);

		foreach ($chartData as $chart) 
		{
			$cag += $college[0] == $chart->college_name ? 1 : 0;
			$cass += $college[1] == $chart->college_name ? 1 : 0;
			$cbaa += $college[2] == $chart->college_name ? 1 : 0;
			$ced += $college[3] == $chart->college_name ? 1 : 0;
			$cen += $college[4] == $chart->college_name ? 1 : 0;
			$cf += $college[5] == $chart->college_name ? 1 : 0;
			$chsi += $college[6] == $chart->college_name ? 1 : 0;
			$cos += $college[7] == $chart->college_name ? 1 : 0;
			$cvsm += $college[8] == $chart->college_name ? 1 : 0;
		}

		for ($i=0; $i < count($college); $i++) 
		{ 
			$data = array(
				'college'			=>	$college[$i],
				'value'				=>	($college[$i] == "CAG" ? $cag : 
												($college[$i] == "CASS" ? $cass : 
													($college[$i] == "CBAA" ? $cbaa : 
														($college[$i] == "CED" ? $ced :
															($college[$i] == "CEN" ? $cen : 
																($college[$i] == "CF" ? $cf : 
																	($college[$i] == "CHSI" ? $chsi : 
																		($college[$i] == "COS" ? $cos : 
																			($college[$i] == "CVSM" ? $cvsm : 0))))))))),
				'pictureSettings'	=>	array("src"	=>	base_url("assets/images/college-logo/").$college[$i].".jpg")
			);

			array_push($output, $data);
		}
		
		echo json_encode($output);
   	}

	public function enrollPerCourse()
	{
		$semester = $_POST['sem'];
		$college = $_POST['college'];
		$courseArr = array();
		$courseNameArr = array();
		$output = array();
		$chartTmp = array();
		$chartTmpIndex = 0;

		// Get data
		$courseData = $this->administrator->getCourse($college);

		foreach ($courseData as $course) 
		{
			if (!in_array($course->course_id, array(0, 144, 145)))
			{
				array_push($courseArr, $course->course_id);

				//Set defult values for chart data VALUE
				array_push($chartTmp, 0);
				// Set Course Name
				array_push($courseNameArr, $course->course_name);
			}
		}

		$chartData = $this->administrator->getEnrollPerCollege($semester, $courseArr);
		foreach ($chartData as $chart) 
		{
			for ($i = 0; $i < count($courseArr); $i++)
			{
				if ($courseArr[$i] == $chart->course_id)
				{
					$chartTmp[$i] += 1;
					break;
				}
			}
		}

		for ($i = 0; $i < count($courseArr); $i++)
		{
			$data = array(
				'course'			=>	$courseNameArr[$i],
				'value'				=>	$chartTmp[$i]
			);

			array_push($output, $data);
		}

		echo json_encode($output);
	}
	/*end of analytics*/

	/*
    * Accounting Module Functions
    *
    *
    */
	public function accountingList()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->administrator->getAccounting($postData);

		echo json_encode($data);
	}

	/*End of accounting module*/

}

/* End of file Administrator.php */
/* Location: ./application/controllers/Administrator.php */