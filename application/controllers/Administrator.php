<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('computation');
		$this->load->helper('date');
		$this->load->model('administrator_model', 'administrator');
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
            'semester'  =>  $this->get_semester()
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

	public function get_semester()
    {
        $semesterData = $this->administrator->getSemester();
        $htmlData = '<option value="-1" selected>--- SELECT SEMESTER ---</option>';

        foreach ($semesterData as $semester) 
        {
            $htmlData .= '<option value="'.$semester->semester_id.'">'.($semester->semester_name." ".$semester->semester_year).'</option>';
        }

        return $htmlData;
    }

    public function scheduleList()
    {

		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->administrator->getSchedule($postData);

		echo json_encode($data);
   }

   public function enrollPerCollegeChart()
   {
		$semester = $_POST['sem'];
		$course = array();
		$output = array();
		$college = array('CAG', 'CASS', 'CBAA', 'CED', 'CEN', 'CF', 'CHSI', 'COS', 'CVSM');
		$collegeValue = array();
		$cag = $cass = $cbaa = $ced = $cen = $cf = $chsi = $cos = $cvsm = 0;
		$chartData = $this->administrator->getOfficiallyEnroll($semester, $course);

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
				'college'	=>	$college[$i],
				'value'		=>	($college[$i] == "CAG" ? $cag : 
									($college[$i] == "CASS" ? $cass : 
										($college[$i] == "CBAA" ? $cbaa : 
											($college[$i] == "CED" ? $ced :
												($college[$i] == "CEN" ? $cen : 
													($college[$i] == "CF" ? $cf : 
														($college[$i] == "CHSI" ? $chsi : 
															($college[$i] == "COS" ? $cos : 
																($college[$i] == "CVSM" ? $cvsm : 0)))))))))
			);

			array_push($output, $data);
		}
		
		echo json_encode($output);
   }

}

/* End of file Administrator.php */
/* Location: ./application/controllers/Administrator.php */