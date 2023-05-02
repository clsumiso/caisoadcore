<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Spreadsheet */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
			'name'				=>	$_SESSION['account_name'],
			'user_type'			=>	strtoupper($_SESSION['utype']),
			'email'				=>	$_SESSION['e_id'],
			'get_time'			=>	$this->get_time(),
            'semester'  		=>  $this->semesterList(),	
            'college'  			=>  $this->collegeList(),
            'applicantProgram'  =>  $this->applicantProgram()['programDropDown'],
            'programCheckBox'  	=>  $this->applicantProgram()['programCheckbox'],
            'applicantCategory' =>  $this->applicantCategory()
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

		$courseData = $this->administrator->getGradeCourse($college);
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

<<<<<<< HEAD
	public function applicantList()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->administrator->getApplicants($postData);

		echo json_encode($data);
	}

=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
	/*Analytics*/
   	public function enrollPerCollegeChart()
   	{	
		$semester = $_POST['sem'];
		$enrollmentType = $_POST['enrollmentType'];
		$course = array();
		$output = array();
		$college = array('CAG', 'CASS', 'CBAA', 'CED', 'CEN', 'CF', 'CHSI', 'COS', 'CVSM');
		$collegeValue = array();
		$pictureArr = array();
		$cag = $cass = $cbaa = $ced = $cen = $cf = $chsi = $cos = $cvsm = 0;
		$chartData = $this->administrator->getEnrollPerCollege($semester, $course, $enrollmentType);

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
		$enrollmentType = $_POST['enrollmentType'];
		$courseArr = array();
		$courseNameArr = array();
		$output = array();
		$chartTmp = array();
		$chartTmpIndex = 0;

		// Get data
		$courseData = $this->administrator->getCourse($college, $enrollmentType);

		foreach ($courseData as $course) 
		{
			
			$parseCourseName = "";
			$startingCheck = 0;
			if (!in_array($course->course_id, array(0, 144, 145)))
			{
				array_push($courseArr, $course->course_id);

				//Set defult values for chart data VALUE
				array_push($chartTmp, 0);
				// Set Course Name
				if ($enrollmentType == "incoming_freshmen")
				{
					for ($x = 0; $x < strlen($course->course_name); $x++)
					{
						if ($course->course_name[$x] == "(")
						{
							$startingCheck = $x;
						}
					}
					for ($x = $startingCheck; $x < strlen($course->course_name); $x++)
					{
						$parseCourseName .= $course->course_name[$x];
					}
				}else if ($enrollmentType == "resident")
				{
					$parseCourseName = $course->course_name;
				}
				array_push($courseNameArr, str_replace(array("(", ")"), "", $parseCourseName));
			}
		}

		$chartData = $this->administrator->getEnrollPerCollege($semester, $courseArr, $enrollmentType);
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

	public function saveLetter()
	{
		$letterData = $_POST;
		$msg = array();
		$is_update = false;

		$data = array(
			"content"		=>	$letterData['content'],
			"type"			=>	$letterData['letterType'],
			"date_created"	=>	date("Y-m-d H:i:s"),
			"date_updated"	=>	date("Y-m-d H:i:s")
		);

		$condtion = array(
			"type"	=> $letterData['letterType']
		);

		// Check letter if exist
		$letterContent = $this->administrator->getLetterTemplateContent($letterData['letterType']);
		if (count($letterContent) > 0)
		{
			$data = array(
				"content"		=>	$letterData['content'],
				"type"			=>	$letterData['letterType'],
				"date_updated"	=>	date("Y-m-d H:i:s")
			);
			$is_update = true;
		}

		if ($is_update == true)
		{
			$saveLetter = $this->administrator->updateLetter($data, $condtion, array("tbl_letter"));
		}else
		{
			$saveLetter = $this->administrator->saveLetter('tbl_letter', $data);
		}

		if ($saveLetter !== false)
		{
			$msg = array(
				"sys_msg"	=>	"success",
				"msg"		=> 	"Letter Successfuly saved!",
				"icon"		=>	"success"
			);
		}else
		{
			$msg = array(
				"sys_msg"	=>	"failed",
				"msg"		=> 	"Letter save failed!",
				"icon"		=>	"error"
			);
		}

		echo json_encode($msg);
	}

<<<<<<< HEAD
	public function saveLetterType()
	{
		$letterTypeData = $_POST;
		$msg = array();
		$is_update = false;

		$data = array(
			"name"		=>	$letterTypeData['name'],
			"code"		=>	$letterTypeData['code']
		);

		$condtion = array(
			"code"	=> $letterTypeData['code']
		);

		// Check letter type if exist
		$letterType = $this->administrator->getLetterType($letterTypeData['code']);
		if (count($letterType) > 0)
		{
			$is_update = true;
		}

		if ($is_update == true)
		{
			$saveLetterType = $this->administrator->updateLetter($data, $condtion, array("tbl_letterType"));
		}else
		{
			$saveLetterType = $this->administrator->saveLetter('tbl_letterType', $data);
		}

		if ($saveLetterType !== false)
		{
			$msg = array(
				"sys_msg"	=>	"success",
				"msg"		=> 	"Successfuly saved!",
				"icon"		=>	"success"
			);
		}else
		{
			$msg = array(
				"sys_msg"	=>	"failed",
				"msg"		=> 	"Save failed!",
				"icon"		=>	"error"
			);
		}

		echo json_encode($msg);
	}

=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
	public function saveRelease()
	{
		$releaseData = $_POST;
		$msg = array();
<<<<<<< HEAD
		$is_update = false;
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
		$data = array(
			"type"    			=>   $releaseData['letterType'],
			"date_from"         =>   $releaseData['dFrom'],
			"date_to"           =>   $releaseData['dTo'],
			"percent_from"      =>   $releaseData['pFrom'],
			"percent_to"        =>   $releaseData['pTo'],
<<<<<<< HEAD
			"release_date"      =>   $releaseData['rDate'],
			"release_date_to"   =>   $releaseData['rDateTo'],
			"program_id"      	=>   $releaseData['programs']
		);

		$checkRelease = $this->administrator->getList('tbl_release', array($_POST['releaseID']), 'release_id');

		if (count($checkRelease) > 0)
		{
			$saveRelease = $this->administrator->updateLetter($data, array("release_id"	=>	$_POST['releaseID']), array('tbl_release'));
		}else
		{
			$saveRelease = $this->administrator->saveLetter('tbl_release', $data);
		}
		
=======
			"release_date"      =>   $releaseData['rDate']
		);

		$saveRelease = $this->administrator->saveLetter('tbl_release', $data);
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
		if ($saveRelease !== false)
		{
			$msg = array(
				"sys_msg"	=>	"success",
				"msg"		=> 	"Release Setup Successfuly saved!",
				"icon"		=>	"success"
			);
		}else
		{
			$msg = array(
				"sys_msg"	=>	"failed",
				"msg"		=> 	"Release Setup save failed!",
				"icon"		=>	"error"
			);
		}

		echo json_encode($msg);
	}
<<<<<<< HEAD

	public function removeRelease()
	{
		$releaseID = $_POST['releaseID'];
		$condition1 = array(
			"release_id"		=>	$releaseID
		);
		$msg = array();
		if ($this->administrator->delete($condition1, array("tbl_release")) !== false) 
		{
			$msg = array(
				'sys_msg'   =>  'SUCCESS',
				'msg'       =>  'SUCCESSFULLY REMOVED!!!',
				'icon'      =>  'success'
			);
		}else
		{
			$msg = array(
				'sys_msg'   =>  'FAILED',
				'msg'       =>  'FAILED, PLEASE TRY AGAIN!!!',
				'icon'      =>  'error'
			);
		}

		echo json_encode($msg);
	}

	public function removeApplicant()
	{
		$appId = $_POST['appId'];
		$condition1 = array(
			"applicant_id"		=>	$appId
		);
		$condition2 = array(
			"confirmation_id"		=>	$appId
		);
		$msg = array();
		if ($this->administrator->delete($condition1, array("tbl_profile")) !== false || $this->administrator->delete($condition2, array("tbl_confirmation")) !== false) 
		{
			$msg = array(
				'sys_msg'   =>  'SUCCESS',
				'msg'       =>  'SUCCESSFULLY REMOVED!!!',
				'icon'      =>  'success'
			);
		}else
		{
			$msg = array(
				'sys_msg'   =>  'FAILED',
				'msg'       =>  'FAILED, PLEASE TRY AGAIN!!!',
				'icon'      =>  'error'
			);
		}

		echo json_encode($msg);
	}
	
	public function saveApplicant()
	{
		$post = $_POST;
		$msg = array();
		$data = array(
			"fname"				=>	$post['firstname'],
			"mname"				=>	$post['middlename'],
			"lname"				=>	$post['lastname'],
			"program_id"		=>	$post['applicantProgram'],
			"qualifier_type"	=>	$post['applicantCategory']
		);

		if ($post['action']	== "update")
		{
			$condition = array(
				"applicant_id"	=>	$post['appID']
			);

			$update = $this->administrator->updateLetter($data, $condition, array("tbl_profile"));
			if ($update !== false)
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
		}else if ($data['action']	== "insert")
		{

		}

		echo json_encode($msg);
	}
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
	 /**
	  * END OF CRUD
	  */

	/**
<<<<<<< HEAD
	 * APPLICANT FUNCTION
	 */

	public function applicantInfo()
	{
		$applicantData = $this->administrator->getApplicantInfo($_POST['appId']);
		$output = array();

		foreach ($applicantData as $applicant) 
		{
			$output = array(
				"appID"			=>	$applicant->applicant_id,
				"firstname"		=>	$applicant->fname,
				"middlename"	=>	$applicant->mname,
				"lastname"		=>	$applicant->lname,
				"programID"		=>	$applicant->program_id,
				"qualifierType"	=>	$applicant->qualifier_type
			);
		}

		echo json_encode($output);
	}

	public function applicantProgram()
	{
		$programData = $this->administrator->getList("tbl_program", array(), "");
		$htmlData = '<option value="-1">-- SELECT PROGRAM --</option>';
		$programCheckBox = '';
		$ctr = 1;

		foreach ($programData as $program) 
		{
			$htmlData .= '<option value="'.$program->program_id.'">'.$program->program_name.'</option>';
		}

		foreach ($programData as $program) 
		{
			$programCheckBox .= '
				<input type="checkbox" name="program[]" id="program'.$ctr.'" class="filled-in chk-col-green" value="'.$program->program_id.'">
				<label for="program'.$ctr.'">'.$program->program_name.'</label><br> 
			';
			$ctr++;
		}

		return array("programDropDown"	=>	$htmlData, "programCheckbox"	=>	$programCheckBox);
	}

	public function applicantCategory()
	{
		$letterData = $this->administrator->getList("tbl_letterType", array(), "");
		$htmlData = '<option value="-1">-- SELECT CATEGORY --</option>';

		foreach ($letterData as $letter) 
		{
			$htmlData .= '<option value="'.$letter->id.'">'.$letter->name.' ('.$letter->code.')</option>';
		}

		return $htmlData;
	}

	public function qualifierType()
	{
		
	}

	/**
	 * END APPLICANT FUNCTION
	 */

	/**
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
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

	public function getLetterType()
	{
		$letterTypeData = $this->administrator->getApplicantLetterType();
		$htmlData = "";

		foreach ($letterTypeData as $type) 
		{
<<<<<<< HEAD
			$htmlData .= '<option value="'.$type->id.'">'.$type->name.' ('.$type->code.')</option>';
=======
			$htmlData .= '<option value="'.$type->id.'">'.$type->name.'</option>';
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
		}

		echo json_encode(array("content"	=>	$htmlData));
	}

	public function getLetterTemplate()
	{
		$letterTemplateData = $this->administrator->getLetterTemplate();
		$htmlData = '<option value="-1">-- SELECT TEMPLATE --</option>';

		foreach ($letterTemplateData as $template) 
		{
			$htmlData .= '<option value="'.$template->type.'">'.$template->name.'</option>';
		}

		echo json_encode(array("content"	=>	$htmlData));
	}

	public function getLetterTemplateContent()
	{
		$letterID = $_POST['letterID'];
		$letterTemplateData = $this->administrator->getLetterTemplateContent($letterID);
		$htmlData = "";
		foreach ($letterTemplateData as $template) 
		{
			$htmlData = $template->content;
		}

		echo json_encode(array("content"	=>	$htmlData));
	}

	public function getReleaseList()
	{
		$releaseData = $this->administrator->getReleaseList();
		$htmlData = "";

		foreach ($releaseData as $release) 
		{
			$htmlData .= '<tr>';
				$htmlData .= '<td>
<<<<<<< HEAD
								<button type="button" class="btn btn-sm bg-red waves-effect" onclick="removeRelease(\''.$release->release_id.'\')">DELETE</button>
								<button type="button" class="btn btn-sm bg-amber waves-effect" onclick="updateRelease(\''.$release->release_id.'\')">EDIT</button>
=======
								<button type="button" class="btn btn-sm bg-red waves-effect">DELETE</button>
								<button type="button" class="btn btn-sm bg-amber waves-effect">EDIT</button>
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
							</td>';
				$htmlData .= '<td>'.$release->name.'</td>';
				$htmlData .= '<td>'.$release->date_from.'</td>';
				$htmlData .= '<td>'.$release->date_to.'</td>';
				$htmlData .= '<td>'.$release->percent_from.'</td>';
				$htmlData .= '<td>'.$release->percent_to.'</td>';
				$htmlData .= '<td>'.$release->release_date.'</td>';
<<<<<<< HEAD
				$htmlData .= '<td>'.$release->release_date_to.'</td>';
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
			$htmlData .= '</tr>';
		}

		echo json_encode(array("content"	=>	$htmlData));
	}
<<<<<<< HEAD

	public function releaseDateInfo()
	{
		$releaseData = $this->administrator->getIndividualReleaseList($_POST['releaseID']);
		$htmlData = array();

		foreach ($releaseData as $release) 
		{
			$htmlData = array(
				"release_id"	=>	$release->release_id,
				"letterType"	=>	$release->id,
				"name"			=>	$release->name,
				"date_from"		=>	$release->date_from,
				"date_to"		=>	$release->date_to,
				"percent_from"	=>	$release->percent_from,
				"percent_to"	=>	$release->percent_to,
				"release_date"	=>	$release->release_date,
				"release_date_to"	=>	$release->release_date_to
			);
		}

		echo json_encode($htmlData);
	}

	public function importApplicants()
	{
		$directoryName = FCPATH.'uploads/applicants/'.$_SESSION['e_id'];
		$downloads = FCPATH.'downloads/applicants/'.$_SESSION['e_id'];
		//Check if the directory already exists.
		if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755, true);
		}
		
		$config['upload_path']          = 	$directoryName;
		$config['allowed_types']        = 	'xlsx';
		$config['max_size']             = 	1024;
		$config['overwrite']            = 	TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile'))
		{
			$error = $this->upload->display_errors();
			echo json_encode(array("msg" => $error, "sys_msg"	=> "error", "icon"	=>	"error"));
			// $this->session->set_flashdata('error_upload', $error);
			// redirect('faculty/grades');
		}
		else
		{
			$data = $this->upload->data();
			$inputFileType = 'Xlsx';
			$inputFileName = $directoryName."/".$data['file_name'];

			$reader = IOFactory::createReader($inputFileType);
			$reader->setReadDataOnly(true);
			$spreadsheet = $reader->load($inputFileName);

			$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
			$importCtr = 0;
			$updateCtr = 0;

			for ($i=2; $i <= count($sheetData); $i++) 
			{ 
				$profileData = array(
					"applicant_id"		=>	htmlentities($sheetData[$i]['A']),
					"program_id"		=>	htmlentities($sheetData[$i]['E']),
					"fname"				=>	htmlentities($sheetData[$i]['C']),
					"mname"				=>	htmlentities($sheetData[$i]['D']),
					"lname"				=>	htmlentities($sheetData[$i]['B']),
					"qualifier_type"	=>	htmlentities($sheetData[$i]['F'])
				);

				$rankingData = array(
					"applicant_id"		=>	htmlentities($sheetData[$i]['A']),
					"percentile_rank"	=>	htmlentities($sheetData[$i]['G'])
				);

				$condtion = array(
					"applicant_id"	=>	htmlentities($sheetData[$i]['A'])
				);

				if (count($this->administrator->checkIfExist("tbl_profile", $sheetData[$i]['A'])) > 0)
				{
					if ($this->administrator->updateLetter($profileData, $condtion, array('tbl_profile')) !== false)
					{
						$updateCtr++;
					}
				}else
				{
					if ($this->administrator->saveLetter('tbl_profile', $profileData) !== false)
					{
						$importCtr++;
					}
				}

				if (count($this->administrator->checkIfExist("tbl_applicant_ranking", $sheetData[$i]['A'])) > 0)
				{
					if ($this->administrator->updateLetter($rankingData, $condtion, array('tbl_applicant_ranking')) !== false)
					{
						$updateCtr++;
					}
				}else
				{
					if ($this->administrator->saveLetter('tbl_applicant_ranking', $rankingData) !== false)
					{
						$importCtr++;
					}
				}
			}

			echo json_encode(array("msg" => $importCtr." row(s) imported and ".$updateCtr." updated sucessfully.", "sys_msg"	=> "success", "icon"	=>	"success", "import"	=>	$importCtr));
			// $sheetData[2]['A'];
		}
	}
=======
>>>>>>> 6f2e5c0064cd453532e5d152e8e908884bddf721
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