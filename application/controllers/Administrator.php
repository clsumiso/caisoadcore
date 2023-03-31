<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->library('computation');
		$this->load->helper('date');
		$this->load->model('administrator_model', 'administrator');
		$this->load->helper('directory');
		// if (!isset($_SESSION['uid'])) 
        // {
        // 	redirect('/');
        // }
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

	public function gradeList()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->administrator->getGrades($postData);

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

	/*
    * Grades Module Functions
    */
	public function studentGradeList()
	{
		$userID = $_POST['studentID'];
		$semesterID = $_POST['semesterID'];
		$htmlData = "";
		$ctr = 1;
		$studentGradeListData = $this->administrator->getStudentGrade($userID, $semesterID);

		foreach ($studentGradeListData as $studentGrade) 
		{
			$htmlData .= "<tr>";
				$htmlData .= "<td>".($ctr++)."</td>";
				$htmlData .= "<td>".$studentGrade->user_id."</td>";
				$htmlData .= "<td>".$studentGrade->schedid."</td>";
				$htmlData .= "<td>".$studentGrade->faculty_id."</td>";
				$htmlData .= "<td><input style='width: 150px;' class='form-control' type='text' name='gradeData[]' value='".$studentGrade->cat_no."' readonly /></td>";
				$htmlData .= "<td>";
					$htmlData .= "
						<select style='width: 150px;' class='form-control' ".($studentGrade->status == "approved" ? '' : '')." name='gradeData[]'>
							<option value='-1' ".(strtoupper($studentGrade->grades) == "" ? 'selected="true"' : "").">SELECT GRADE</option>
							<option value='1.00' ".(strtoupper($studentGrade->grades) == "1.00" ? 'selected="true"' : "").">1.00</option>
							<option value='1.25' ".(strtoupper($studentGrade->grades) == "1.25" ? 'selected="true"' : "").">1.25</option>
							<option value='1.50' ".(strtoupper($studentGrade->grades) == "1.50" ? 'selected="true"' : "").">1.50</option>
							<option value='1.75' ".(strtoupper($studentGrade->grades) == "1.75" ? 'selected="true"' : "").">1.75</option>
							<option value='2.00' ".(strtoupper($studentGrade->grades) == "2.00" ? 'selected="true"' : "").">2.00</option>
							<option value='2.25' ".(strtoupper($studentGrade->grades) == "2.25" ? 'selected="true"' : "").">2.25</option>
							<option value='2.50' ".(strtoupper($studentGrade->grades) == "2.50" ? 'selected="true"' : "").">2.50</option>
							<option value='2.75' ".(strtoupper($studentGrade->grades) == "2.75" ? 'selected="true"' : "").">2.75</option>
							<option value='3.00' ".(strtoupper($studentGrade->grades) == "3.00" ? 'selected="true"' : "").">3.00</option>
							<option value='5.00' ".(strtoupper($studentGrade->grades) == "5.00" ? 'selected="true"' : "").">5.00</option>
							<option value='D' ".(strtoupper($studentGrade->grades) == "D" ? 'selected="true"' : "").">D</option>
							<option value='FD' ".(strtoupper($studentGrade->grades) == "FD" ? 'selected="true"' : "").">FORCE DROPPED</option>
							<option value='NG' ".(strtoupper($studentGrade->grades) == "NG" ? 'selected="true"' : "").">NG</option>
							<option value='INC' ".(strtoupper($studentGrade->grades) == "INC" ? 'selected="true"' : "").">INC</option>
							<option value='IP' ".(strtoupper($studentGrade->grades) == "IP" ? 'selected="true"' : "").">IP</option>
						</select>
					";
				$htmlData .= "</td>";
				$htmlData .= "<td>";
					$htmlData .= "
						<select style='width: 150px;' class='form-control' ".($studentGrade->status == "approved" ? '' : '')." name='gradeData[]'>
							<option value='-1' ".(strtoupper($studentGrade->reexam) == "" ? 'selected="true"' : "").">SELECT GRADE</option>
							<option value='1.00' ".(strtoupper($studentGrade->reexam) == "1.00" ? 'selected="true"' : "").">1.00</option>
							<option value='1.25' ".(strtoupper($studentGrade->reexam) == "1.25" ? 'selected="true"' : "").">1.25</option>
							<option value='1.50' ".(strtoupper($studentGrade->reexam) == "1.50" ? 'selected="true"' : "").">1.50</option>
							<option value='1.75' ".(strtoupper($studentGrade->reexam) == "1.75" ? 'selected="true"' : "").">1.75</option>
							<option value='2.00' ".(strtoupper($studentGrade->reexam) == "2.00" ? 'selected="true"' : "").">2.00</option>
							<option value='2.25' ".(strtoupper($studentGrade->reexam) == "2.25" ? 'selected="true"' : "").">2.25</option>
							<option value='2.50' ".(strtoupper($studentGrade->reexam) == "2.50" ? 'selected="true"' : "").">2.50</option>
							<option value='2.75' ".(strtoupper($studentGrade->reexam) == "2.75" ? 'selected="true"' : "").">2.75</option>
							<option value='3.00' ".(strtoupper($studentGrade->reexam) == "3.00" ? 'selected="true"' : "").">3.00</option>
							<option value='5.00' ".(strtoupper($studentGrade->reexam) == "5.00" ? 'selected="true"' : "").">5.00</option>
							<option value='D' ".(strtoupper($studentGrade->reexam) == "D" ? 'selected="true"' : "").">D</option>
							<option value='FD' ".(strtoupper($studentGrade->reexam) == "FD" ? 'selected="true"' : "").">FORCE DROPPED</option>
							<option value='NG' ".(strtoupper($studentGrade->reexam) == "NG" ? 'selected="true"' : "").">NG</option>
							<option value='INC' ".(strtoupper($studentGrade->reexam) == "INC" ? 'selected="true"' : "").">INC</option>
							<option value='IP' ".(strtoupper($studentGrade->reexam) == "IP" ? 'selected="true"' : "").">IP</option>
						</select>
					";
				$htmlData .= "</td>";
				$htmlData .= "<td>".$studentGrade->remarks."</td>";
				$htmlData .= "<td>".$studentGrade->status."</td>";
			$htmlData .= "</tr>";
		}

		echo json_encode(array("data"	=>	$htmlData));
	}
	/*End of grades module Functions*/

	/**
	 * CRUD
	 */
	public function saveGrade()
	{
		// $action = $_POST['action'];
		$gradeData = $_POST['gradeData'];
		$action = $_POST['action'];
		$semester = $_POST['semester'];
		$studentID = $_POST['studentID'];

		$output = array();
		$msg = array();
		$ctr = 1;

		$grade = '';
		$reexam = '';
		$cat_no = '';

		for ($i = 0 ; $i < count($gradeData); $i++)
		{
			
			switch ($ctr)
			{
				case 1:
					$cat_no = $gradeData[$i];
					break;
				case 2:
					$grade = $gradeData[$i];
					break;
				case 3:
					$reexam = $gradeData[$i];
					break;
			}

			if ($ctr == 3)
			{
				// if ($grade != -1 && $reexam != -1)
				// {
				// 	$data = array(
				// 		"status"		=>	"approved",
				// 		"grade"			=>	$grade,
				// 		"reexam"		=>	$reexam,
				// 		"sched_section"	=>	date("Y-m-d H:i:s")
				// 	);
				// }else if ($grade != -1 && $reexam == -1)
				// {
				// 	$data = array(
				// 		"status"		=>	"approved",
				// 		"grade"			=>	$grade,
				// 		"sched_section"	=>	date("Y-m-d H:i:s")
				// 	);
				// }else if ($grade == -1 && $reexam != -1)
				// {
				// 	$data = array(
				// 		"status"		=>	"approved",
				// 		"reexam"		=>	$reexam,
				// 		"sched_section"	=>	date("Y-m-d H:i:s")
				// 	);
				// }else
				// {
				// 	$data = array();
				// }
				
				$data = array();
				$condtion = array(
					"subject"	=>	$cat_no,
					"semester_id"	=>	$semester,
					"user_id"	=>	$studentID
				);

				// array_push($output, $condtion);
				// Get Old Data
				$gradeOldData = $this->administrator->getGradesOldData($condtion);
				foreach ($gradeOldData as $gradeVal) 
				{
					$data = array();
					if ($grade != -1 && $reexam != -1)
					{
						if ($grade != $gradeVal->grades && $reexam != $gradeVal->reexam)
						{
							$data = array(
								"status"		=>	"approved",
								"grades"		=>	$grade,
								"reexam"		=>	$reexam,
								"remarks"		=>	$this->gradeRemarks($reexam),
								"sched_section"	=>	date("Y-m-d H:i:s")
							);
						}else if($grade == $gradeVal->grades && $reexam != $gradeVal->reexam)
						{
							$data = array(
								"status"		=>	"approved",
								"reexam"		=>	$reexam,
								"remarks"		=>	$this->gradeRemarks($reexam),
								"sched_section"	=>	date("Y-m-d H:i:s")
							);
						}else if($grade != $gradeVal->grades && $reexam == $gradeVal->reexam)
						{
							$data = array(
								"status"		=>	"approved",
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"sched_section"	=>	date("Y-m-d H:i:s")
							);
						}else
						{
							$data = array();
						}
					}else if ($grade != -1 && $reexam == -1)
					{
						if ($grade != $gradeVal->grades)
						{
							$data = array(
								"status"		=>	"approved",
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"sched_section"	=>	date("Y-m-d H:i:s")
							);
						}
					}else if ($grade == -1 && $reexam != -1)
					{
						if ($reexam != $gradeVal->reexam)
						{
							$data = array(
								"status"		=>	"approved",
								"reexam"		=>	$reexam,
								"remarks"		=>	$this->gradeRemarks($reexam),
								"sched_section"	=>	date("Y-m-d H:i:s")
							);
						}
					}else
					{
						$data = array();
					}

					// array_push($output, $data);
				}

				/**
				 * First procedure save to metadata for history logs
				 */
				$metadata = array(
					"user_id"		=>	$_SESSION['uid'],
					"semester_id"	=>	$semester,
					"action"		=>	$action,
					"old_data"		=>	json_encode($gradeOldData),
					"new_data"		=>	json_encode($data),
					"date_created"	=>	date("Y-m-d H:i:s")

				);

				if (count($data) > 0)
				{
					$saveToMetadata = $this->administrator->save("metadata", $metadata);
					if ($saveToMetadata !== false)
					{
						$saveGrade = $this->administrator->update($data, $condtion, array("tbl_grades"));
						if ($saveGrade !== false)
						{
							$msg = array(
								"sys_msg"	=> 	"success",
								"msg"		=>	"Successfully updated",
								"icon"		=>	"success"
							);
						}else
						{
							$msg = array(
								"sys_msg"	=> 	"failed",
								"msg"		=>	"Something went wrong, please try again",
								"icon"		=>	"error"
							);
						}
					}else
					{
						$msg = array(
							"sys_msg"	=> 	"failed",
							"msg"		=>	"Something went wrong, please try again",
							"icon"		=>	"error"
						);
					}
				}

				if (count($data) > 0)
				{
					array_push($output, $data);
				}
				
				/**
				 * END First procedure save to metadata for history logs
				 */
				$ctr = 0;
			}
			$ctr++;
		}
		// $reexamData = $_POST['reexam'];
		if (count($output) == 0)
		{
			$msg = array(
				"sys_msg"	=> 	"no_change",
				"msg"		=>	"No changes",
				"icon"		=>	"info"
			);
		}

		echo json_encode(array("sys_msg"	=>	$msg));
	}
	 /**
	  * END OF CRUD
	  */

	/**
	 * OTHER Functions
	 */
	public function gradeRemarks($grade = "")
	{
		$remarks = "";
		switch ($grade) {
			case '1.00':
				case '1.25':
					case '1.50':
						case '1.75':
							case '2.00':
								case '2.25':
									case '2.50':
										case '2.75':
											case '3.00':
												$remarks = "PASSED";
				break;
			case 'INC':
				$remarks = "INCOMPLETE";
				break;
			case 'NG':
				$remarks = "NO GRADE";
				break;
			case 'D':
				$remarks = "DROPPED";
			case 'FD':
				$remarks = "FORCE DROPPED";
				break;
			case 'IP':
				$remarks = "IN PROGRESS";
				break;
			case '5.00':
				$remarks = "FAILED";
				break;
		}

		return $remarks;
	}
	 /**
	  * END of other functions
	  */

	public function test()
	{
		echo json_encode($this->administrator->getTestDatabase2());
	}

}

/* End of file Administrator.php */
/* Location: ./application/controllers/Administrator.php */