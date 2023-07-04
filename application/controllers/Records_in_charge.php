<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* Spreadsheet */
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
require 'vendor/autoload.php';

class Records_in_charge extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('records_in_charge_model', 'records_in_charge');
		$this->load->model('Encoder_model', 'encoder');
		$this->load->helper('date');
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
			'courses'			=>	$this->courses(),
			'get_time'			=>	$this->get_time(),
            'college'           =>  $this->college()
		);
		$this->load->view('ric/_header', $data);
	    $this->load->view('ric/_css', $data);
	    $this->load->view('ric/ric_view', $data);
	    $this->load->view('ric/_footer', $data);
	    $this->load->view('ric/_js', $data);
	}

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

	public function semester()
	{
		$semester_data = $this->records_in_charge->get_semester();
		$htmlContent = '<option value="#">-- SELECT SEMESTER --</option>';

		foreach ($semester_data as $semester) 
		{
			$htmlContent .= '<option value="'.$semester->semester_id.'">'.$semester->semester_name.' '.$semester->semester_year.'</option>';
		}

		return $htmlContent;
	}

	public function semester_student_individual_data()
	{
		$semester_data = $this->records_in_charge->get_semester();
		$htmlContent = '<option value="#">-- SELECT SEMESTER --</option>';

		foreach ($semester_data as $semester) 
		{
			$registration_data = $this->records_in_charge->get_student_registration($_POST['idnumber'], $semester->semester_id);
			if (count($registration_data) > 0) 
			{
				$htmlContent .= '<option value="'.$semester->semester_id.'">'.$semester->semester_name.' '.$semester->semester_year.' (enrolled)</option>';
			}else
			{
				$htmlContent .= '<option value="'.$semester->semester_id.'">'.$semester->semester_name.' '.$semester->semester_year.'</option>';
			}
		}

		echo json_encode(array("semester_content" => $htmlContent));
	}

	public function import_evaluation()
	{
		$directoryName = FCPATH.'assets/records-in-charge/uploads/'.$_SESSION['uid'];
		$msg = array();
		$output = array();
		$data_to_insert  = array();
		$data_to_update  = array();

		if(!is_dir($directoryName))
		{
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755, true);
		}
		$config['upload_path']    = 	$directoryName;
		$config['allowed_types']  = 	'xlsx';
		$config['max_size']       = 	1024;
		$config['overwrite']      = 	TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file'))
		{
				// $error = $this->upload->display_errors();
				$msg = array(
					"sys_msg"	=> 	0,
					"msg"		=>	$this->upload->display_errors(),
					"icon"		=> "warning"
				);
		}else
		{
			$data = $this->upload->data();
			$inputFileType = 'Xlsx';
			$inputFileName = $directoryName."/".$data['file_name'];
			$data_to_insert = 	array();
			$data_to_update	=	array();

			$reader = ReaderEntityFactory::createXLSXReader();
			// $reader = ReaderEntityFactory::createODSReader();
			// $reader = ReaderEntityFactory::createCSVReader();

			$reader->open($inputFileName);
			$isHeader = 0;
			foreach ($reader->getSheetIterator() as $sheet) 
			{
			    foreach ($sheet->getRowIterator() as $row) 
			    {
			    	if ($isHeader == 1) 
			    	{
			    		// do stuff with the row
				        $cells = $row->getCells();
						$emailCell = $cells[0]; // 4 because first column is at index 0.
						$email = $emailCell->getValue();

			        	array_push($output, $email);
			    	}
					$isHeader = 1;
			    }
			}
		}

		$reader->close();

		echo json_encode(array("data"	=>	$output));
	}

	public function export_evaluation($couse, $semester)
	{
		$registration_data = $this->records_in_charge->get_student_registration_per_sem($couse, $semester);
		$fileName = 'evaluation_template_'.date("m_d_Y_H_i_s");
		$directoryName = FCPATH.'assets/records-in-charge/downloads/'.$_SESSION['e_id'];
		$writer = WriterEntityFactory::createXLSXWriter();
		// $writer = WriterEntityFactory::createODSWriter();
		// $writer = WriterEntityFactory::createCSVWriter();

		//$writer->openToFile($directoryName."/".$fileName.'.xlsx'); // write data to a file or to a PHP stream
		$writer->openToBrowser($fileName.'.xlsx'); // stream data directly to the browser
		$border = (new BorderBuilder())
		    ->setBorderTop(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
		    ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
		    ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
		    ->setBorderRight(Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID)
		    ->build();
		$style = (new StyleBuilder())
		    ->setBorder($border)
		    ->build();
		$defaultStyle = (new StyleBuilder())
		    ->setFontSize(12)
		    ->build();
		$notEditableColumnStyle = (new StyleBuilder())
		    ->setBackgroundColor(Color::RED)
		    ->setFontColor(Color::BLACK)
		    ->setFontSize(12)
		    ->build();

		//CREATE HEADER
		$cells = array(
		    WriterEntityFactory::createCell('ID NUMBER', $defaultStyle),
		    WriterEntityFactory::createCell('FULLNAME', $defaultStyle),
		    WriterEntityFactory::createCell('SEMESTER (do not edit this column)', $notEditableColumnStyle),
		    WriterEntityFactory::createCell('COURSE', $defaultStyle),
		    WriterEntityFactory::createCell('SECTION', $defaultStyle),
		    WriterEntityFactory::createCell('DATE ADMITTED', $defaultStyle),
		    WriterEntityFactory::createCell('NO. STAY', $defaultStyle),
		    WriterEntityFactory::createCell('ENTRANCE CREDENTIALS', $defaultStyle),
		    WriterEntityFactory::createCell('INCOMPLETE/CONDITIONAL SUBJECTS', $defaultStyle),
		    WriterEntityFactory::createCell('LAPSE', $defaultStyle),
		    WriterEntityFactory::createCell('NO GRADES SUBJECTS', $defaultStyle),
		    WriterEntityFactory::createCell('FORCE DROP', $defaultStyle),
		    WriterEntityFactory::createCell('BEHIND SUBJECTS', $defaultStyle),
		    WriterEntityFactory::createCell('REGULAR UNITS ALLOWED TO ENROLL', $defaultStyle),
		    WriterEntityFactory::createCell('OTHER CONCERN', $defaultStyle),
		    WriterEntityFactory::createCell('INSTRUCTIONS FROM RIC', $defaultStyle),
		);

		/** add a row at a time */
		$singleRow = WriterEntityFactory::createRow($cells);
		$singleRow->setStyle($style);
		$writer->addRow($singleRow);

		/** add multiple rows at a time */
		// $multipleRows = [
		//     WriterEntityFactory::createRow($cells),
		//     WriterEntityFactory::createRow($cells),
		// ];
		// $writer->addRows($multipleRows); 

		/** Shortcut: add a row from an array of values */
		// $values = ['Carl', 'is', 'great!'];
		// $rowFromValues = WriterEntityFactory::createRowFromArray($values);
		// $writer->addRow($rowFromValues);

		foreach($registration_data as $registration)
		{
			$lname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($registration->lname)); 
			$fname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($registration->fname)); 
			$mname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($registration->mname)); 

			/*$data = array(
				$registration->user_id,
				$lname.", ".$fname." ".$mname,
				$semester,
				$registration->course_name,
				$registration->section,
				$registration->date_admitted,
				$registration->no_stay,
				$registration->entrance_credential,
				$registration->inc_cond_grades,
				$registration->lapse,
				$registration->no_grades,
				$registration->force_drop,
				$registration->behind_subjects,
				$registration->max_units_allowed,
				$registration->other_concern,
				$registration->ins_from_ric
			);*/

			$data = array(
			    WriterEntityFactory::createCell($registration->user_id, $defaultStyle),
			    WriterEntityFactory::createCell($lname.", ".$fname." ".$mname, $defaultStyle),
			    WriterEntityFactory::createCell($semester, $notEditableColumnStyle),
			    WriterEntityFactory::createCell($registration->course_name, $defaultStyle),
			    WriterEntityFactory::createCell($registration->section, $defaultStyle),
			    WriterEntityFactory::createCell($registration->date_admitted, $defaultStyle),
			    WriterEntityFactory::createCell($registration->no_stay, $defaultStyle),
			    WriterEntityFactory::createCell($registration->entrance_credential, $defaultStyle),
			    WriterEntityFactory::createCell($registration->inc_cond_grades, $defaultStyle),
			    WriterEntityFactory::createCell($registration->lapse, $defaultStyle),
			    WriterEntityFactory::createCell($registration->no_grades, $defaultStyle),
			    WriterEntityFactory::createCell($registration->force_drop, $defaultStyle),
			    WriterEntityFactory::createCell($registration->behind_subjects, $defaultStyle),
			    WriterEntityFactory::createCell($registration->max_units_allowed, $defaultStyle),
			    WriterEntityFactory::createCell($registration->other_concern, $defaultStyle),
			    WriterEntityFactory::createCell($registration->ins_from_ric, $defaultStyle),
			);
			$rowFromValues = WriterEntityFactory::createRow($data);
			$rowFromValues->setStyle($style);
			$writer->addRow($rowFromValues);
		}

		$writer->close();
	}

	public function evaluation()
	{
		$evaluation_data = $this->records_in_charge->get_evaluation($_POST['course'], $_POST['semester']);
		$i = 0;
		$output = array();

		foreach($evaluation_data as $evaluation)
		{
			$lname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($evaluation->lname)); 
			$fname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($evaluation->fname)); 
			$mname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($evaluation->mname)); 
			$i++;
			$student_evaluation_data = $this->records_in_charge->get_student_evaluation($evaluation->user_id, $_POST['semester']);
			if (count($student_evaluation_data) > 0) 
			{
				foreach ($student_evaluation_data as $student_evaluation) 
				{

					$data = array(
						$i,
						'
							<button class="btn btn-sm btn-warning btn-block waves-effect" onclick="update_evaluation(\''.$evaluation->user_id.'\',\''.$lname.'\',\''.$fname.'\',\''.$mname.'\', \''.$evaluation->course_name.'\', \''."add".'\')"><i class="material-icons">edit</i> EDIT/UPDATE</button>
							<button class="btn btn-sm btn-danger btn-block waves-effect" onclick="remove_evaluation(\''.$student_evaluation->evaluation_id.'\')"><i class="material-icons">delete</i> REMOVE</button>
						',
						$evaluation->user_id, 
						$lname, 
						$fname, 
						$mname, 
						$evaluation->course_name, 
						$student_evaluation->section, 
						$student_evaluation->date_admitted, 
						$student_evaluation->no_stay, 
						$student_evaluation->entrance_credential, 
						$student_evaluation->inc_cond_grades, 
						$student_evaluation->lapse, 
						$student_evaluation->no_grades, 
						$student_evaluation->force_drop, 
						$student_evaluation->behind_subjects,
						$student_evaluation->max_units_allowed,
						$student_evaluation->other_concern, 
						$student_evaluation->ins_from_ric
					);

					array_push($output, $data);
				}
			}else
			{
				$data = array(
				$i,
				'
					<button class="btn btn-sm btn-warning btn-block waves-effect" onclick="update_evaluation(\''.$evaluation->user_id.'\',\''.$lname.'\',\''.$fname.'\',\''.$mname.'\', \''.$evaluation->course_name.'\', \''."add".'\')"><i class="material-icons">edit</i> EDIT/UPDATE</button>
				',
				$evaluation->user_id, 
				$lname, 
				$fname, 
				$mname, 
				$evaluation->course_name, 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---", 
				"---"
			);

				array_push($output, $data);
			}
		}

		// Output to JSON format
		echo json_encode(array("data"	=>	$output));
	}

	public function courses()
	{
		$role_data = $this->records_in_charge->get_role($_SESSION['uid']);
		$htmlContent = '<option value="-1">-- SELECT COURSE --</option>';
		$course_list = array();
		if (count($role_data)) 
		{
			for ($i = 0; $i < count(explode(",", $role_data[0]->role)); $i++)
			{
				array_push($course_list, explode(",", $role_data[0]->role)[$i]);
			}

			$course_data = $this->records_in_charge->get_course($course_list);
			foreach ($course_data as $course) 
			{
				$htmlContent .= '<option value="'.$course->course_id.'">'.$course->course_desc.'</option>';
			}
		}else
		{
			$htmlContent = '<option value="#">-- SELECT COURSE --</option>';
		}

		return $htmlContent;
	}

	public function remove_evaluation()
	{
		$evaluation_id = $_POST['evaluation_id'];
		$msg = array();
		$condition = array(
			'evaluation_id'	=>	$evaluation_id
		);

		if ($this->records_in_charge->delete('tbl_evaluation', $condition)) 
		{
			$msg = array(
				"sys_msg"	=>	1,
				"msg"		=>	"SUCCESS",
				"icon"		=>	"success"
			);
		}else
		{
			$msg = array(
				"sys_msg"	=>	0,
				"msg"		=>	"FAILED",
				"icon"		=>	"error"
			);
		}

		echo json_encode($msg);
	}

	public function add_edit_evaluation()
	{
		$arrData = $_POST['data'];
		$entrance_credential = "";
		$systemMessage = array();
		// Parse entrance credentials with delimeter "|"
		if ($arrData['entrance_credential'] != "") 
		{
			for ($i=0; $i < count($arrData['entrance_credential']); $i++) 
			{ 
				$entrance_credential .= $arrData['entrance_credential'][$i].($i == (count($arrData['entrance_credential']) - 1) ? "" : '|');
			}
		}

		/*
			"studid": $('[name="studid"]').val(),
		    "lastname": $('[name="lastname"]').val(),
		    "firstname": $('[name="firstname"]').val(),
		    "middlename": $('[name="middlename"]').val(),
		    "course": $('[name="course"]').val(),
		    "major": $('[name="major"]').val(),
    		"": $('#semester option:selected').val(),
		    "section": $('[name="section"]').val(),
		    "date_admitted": $('[name="date_admitted"]').val(),
		    "residency": $('[name="residency"]').val(),
		    "entrance_credential": $('[name="entrance_credential"]').val(),
		    "inc_cond_grades": $('[name="inc_cond_grades"]').val(),
		    "lapse": $('[name="lapse"]').val(),
		    "nod_grades": $('[name="nod_grades"]').val(),
		    "behind_subjects": $('[name="behind_subjects"]').val(),
		    "other_concern": $('[name="other_concern"]').val(),
		    "instruction": $('[name="instruction"]').val(),
		    "max_units_allowed": $('[name="max_units_allowed"]').val()
		*/

		$data = array(
			'studid'                =>  $arrData['studid'],
			'fullname'              =>  $arrData['lastname'].", ".$arrData['firstname']." ".$arrData['middlename'],
			'course'                =>  $arrData['course'],
			'semester_id'           =>  $arrData['semester'],
			'section'               =>  $arrData['section'],
			'date_admitted'         =>  $arrData['date_admitted'],
			'no_stay'               =>  $arrData['residency'],
			'entrance_credential'   =>  $entrance_credential,
			'inc_cond_grades'       =>  $arrData['inc_cond_grades'],
			'lapse'                 =>  $arrData['lapse'],
			'no_grades'             =>  $arrData['nod_grades'],
			'force_drop'            =>  $arrData['forceDrop'],
			'behind_subjects'       =>  $arrData['behind_subjects'],
			'other_concern'         =>  $arrData['other_concern'],
			'ins_from_ric '         =>  $arrData['instruction'],
			'max_units_allowed'     =>  $arrData['max_units_allowed']
		);

		$con = array(
			"studid"		=>	$arrData['studid'],
			"semester_id"	=>	$arrData['semester']
		);

		$profileData = array(
			"major_id"	=>	$arrData['major']
		);

		$profileDataCon = array(
			"user_id"	=>	$arrData['studid']
		);

		$evaluation_data = $this->records_in_charge->get_student_evaluation($arrData['studid'], $arrData['semester']);
		if (count($evaluation_data) > 0) 
		{
			if ($this->records_in_charge->update($data, $con, $profileData, array('tbl_evaluation', 'tbl_profile'), $profileDataCon) !== false) 
			{
				$systemMessage = array(
					"sys_msg"	=>	1,
					"msg"		=>	"SUCCESSFULLY UPDATED!!!",
					"icon"		=>	"success"
				);
			}else
			{
				$systemMessage = array(
					"sys_msg"	=>	0,
					"msg"		=>	"UPDATE FAILED!!!",
					"icon"		=>	"error"
				);
			}
		}else
		{
			if ($this->records_in_charge->save($data, $con, $profileData, array('tbl_evaluation', 'tbl_profile'), $profileDataCon)!== false) 
			{
				$systemMessage = array(
					"sys_msg"	=>	1,
					"msg"		=>	"SUCCESSFULLY SAVED!!!",
					"icon"		=>	"success"
				);
			}else
			{
				$systemMessage = array(
					"sys_msg"	=>	0,
					"msg"		=>	"SAVE FAILED!!!",
					"icon"		=>	"error"
				);
			}
		}

		

		echo json_encode($systemMessage);
	}

	public function evaluation_modal()
	{
		$student_evaluation_data = $this->records_in_charge->get_student_evaluation($_POST['idnumber'], $_POST['semester']);
		$output = array();

		foreach ($student_evaluation_data as $student_evaluation) 
		{
			$data = array( 
				$student_evaluation->evaluation_id, 
				strtoupper($student_evaluation->section), 
				$student_evaluation->date_admitted, 
				$student_evaluation->no_stay, 
				strtoupper($student_evaluation->entrance_credential), 
				$student_evaluation->inc_cond_grades, 
				$student_evaluation->lapse, 
				$student_evaluation->no_grades, 
				$student_evaluation->force_drop, 
				$student_evaluation->behind_subjects, 
				$student_evaluation->other_concern, 
				$student_evaluation->ins_from_ric, 
				$student_evaluation->max_units_allowed
			);

			array_push($output, $data);
		}

		echo json_encode($output);
	}

	public function evaluation_modal_components()
	{
		// $course_data = $this->records_in_charge->get_course_info($_POST['course']);
		$section_html = '<option value="-1">-- SELECT SECTION --</option>';
		$major_html = '<option value="-1">-- SELECT MAJOR --</option>';
		$evaluation_arr = array();
		$forceDropList = "";

		$section_data = $this->records_in_charge->get_class_schedule_section($_POST['course'], $_POST['semester']);

		$profile_data = $this->records_in_charge->get_student_profile($_POST['idnumber']);

		$enrollment_data = $this->records_in_charge->get_enrollment($_POST['idnumber'], $_POST['semester']);

		$evaluationData = $this->records_in_charge->get_student_evaluation($_POST['idnumber'], $_POST['semester']);

		$forceDropData = $this->records_in_charge->get_force_drop($_POST['idnumber'], $_POST['semester']);

		foreach ($section_data as $section) 
		{
			if (count($enrollment_data) > 0) 
			{
				if ($enrollment_data[0]->section == strtoupper($section->section)) 
				{
					$section_html .= '<option value="'.strtoupper($section->section).'" selected>'.strtoupper($section->section).'</option>';
				}else
				{
					if (strtoupper($enrollment_data[0]->section) == 'DOTUNI' || strtoupper($enrollment_data[0]->section) == 'ETEEAP') 
					{
						$section_html .= '<option value="'.strtoupper($enrollment_data[0]->section).'" selected>'.strtoupper($enrollment_data[0]->section).'</option>';
					}else
					{
						$section_html .= '<option value="'.strtoupper($section->section).'">'.strtoupper($section->section).'</option>';
					}
				}
			}else
			{
				$section_html .= '<option value="'.strtoupper($section->section).'">'.strtoupper($section->section).'</option>';
			}
		}

		foreach ($profile_data as $profile) 
		{
			$major_data = $this->records_in_charge->get_student_major($profile->course_id);
			foreach ($major_data as $major) 
			{
				if ($profile->major_id == $major->major_id) 
				{
					$major_html .= '<option value="'.$major->major_id.'" selected>'.$major->name.'</option>';
				}else
				{
					$major_html .= '<option value="'.$major->major_id.'">'.$major->name.'</option>';
				}
			}
		}

		foreach ($evaluationData as $evaluation) 
		{
			$data = array(
				"date_admitted"			=>	$evaluation->date_admitted,
				"no_stay"				=>	$evaluation->no_stay,
				"entrance_credential"	=>	$evaluation->entrance_credential,
				"inc_cond_grades"		=>	$evaluation->inc_cond_grades,
				"lapse"					=>	$evaluation->lapse,
				"no_grades"				=>	$evaluation->no_grades,
				"force_drop"			=>	$evaluation->inc_cond_grades,
				"inc_cond_grades"		=>	$evaluation->inc_cond_grades,
				"inc_cond_grades"		=>	$evaluation->inc_cond_grades
			);
		}

		$output = array(
			'section_content'	=>	$section_html,
			'major_content'		=>	$major_html
		);

		echo json_encode($output);
	}

	public function student_registration_individual()
	{
		$registration_data = $this->records_in_charge->get_student_registration($_POST['idnumber'], $_POST['semester']);
		$registration_html = '';
		$i = 1;
		$total_units = 0;
		foreach ($registration_data as $registration) 
		{
			$registration_html .= '<tr>';
				$registration_html .= 	'<td>'.($i++).'</td>';
				$registration_html .= 	'<td>'.
											($registration->force_drop == 0 
											? 
											'<button type="button" class="btn btn-sm btn-danger waves-effect" onclick="force_drop(\''.$_POST['idnumber'].'\', \''.$_POST['semester'].'\', \''.$registration->schedid.'\', 1)">mark as force drop</button>'
											:
											'<button type="button" class="btn btn-sm btn-success waves-effect" onclick="force_drop(\''.$_POST['idnumber'].'\', \''.$_POST['semester'].'\', \''.$registration->schedid.'\', 0)">mark as enrolled</button>')
										.'</td>';
				$registration_html .= '<td>'.$registration->schedid.'</td>';
				$registration_html .= '<td>'.$registration->cat_no.'</td>';
				$registration_html .= '<td>'.($registration->weight == 1 ? $registration->units : "[".$registration->units."]").'</td>';
				$registration_html .= '<td>'.$registration->day.'</td>';
				$registration_html .= '<td>'.$registration->time.'</td>';
				$registration_html .= '<td>'.$registration->room.'</td>';
				$registration_html .= '<td>'.$registration->section.'</td>';
				$registration_html .= '<td'.($registration->force_drop == 1 ? " class='bg-red'" : "").'>'.($registration->force_drop == 1 ? "FORCE DROP" : "ENROLLED").'</td>';
			$registration_html .= '</tr>';

			if (is_numeric($registration->units) && $registration->weight == 1) 
			{
				$total_units += intval($registration->units);
			}
		}
		$registration_html .= '<tr>';
			$registration_html .= '<td colspan="9" style="text-align: center;">--- NOTHING FOLLOWS ---</td>';
		$registration_html .= '</tr>';
		$registration_html .= '<tr>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td>TOTAL</td>';
			$registration_html .= '<td>'.$total_units.'</td>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td></td>';
			$registration_html .= '<td></td>';
		$registration_html .= '</tr>';

		$output = array(
			'registration_content'	=>	$registration_html
		);

		echo json_encode($output);
	}

	public function force_drop()
	{
		$msg = array();
		$idnumber = $_POST['idnumber']; 
		$semester = $_POST['semester']; 
		$schedid = $_POST['schedid']; 
		$status = $_POST['status'];
		// $fd_status = '';
		// $cat_no = '';

		$data = array(
			"force_drop"	=>	$status
		);

		$con = array(
			"user_id"		=>	$idnumber,
			"semester_id"	=>	$semester,
			"schedid"		=>	$schedid
		);

		// if (count($this->records_in_charge->class_schedule_info($schedid, $semester)) > 0) 
		// {
		// 	$cat_no = $this->records_in_charge->class_schedule_info($schedid, $semester)[0]->cat_no;
		// }

		// if (count($this->records_in_charge->get_student_evaluation($idnumber, $semester)) > 0) 
		// {
		// 	$fd_status = $this->records_in_charge->get_student_evaluation($idnumber, $semester)[0]->force_drop;
		// }

		// if ($status == 1) 
		// {
		// 	$fd_status .= ','.$cat_no;
		// }

		if ($this->records_in_charge->update_single_table($data, $con, 'tbl_registration') !== false) 
		{
			$msg = array(
				"sys_msg"	=>	1,
				"msg"		=>	"SUCCESSFULLY UPDATED!!!",
				"icon"		=>	"success"
			);
		}else
		{
			$msg = array(
				"sys_msg"	=>	0,
				"msg"		=>	"UPDATE FAILED!!!",
				"icon"		=>	"error"
			);
		}

		echo json_encode($msg);
	}

	public function enrollment()
	{
		$student_data = $this->records_in_charge->get_students($_POST['course_id'], $_POST['yrlevel'], intval($_POST['sem']));
		$i = 1;
		$output = array();

		foreach($student_data as $student)
		{
			$lname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($student->lname)); 
			$fname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($student->fname)); 
			$mname = preg_replace('/[^a-zA-Z0-9-_\.]/','', strtoupper($student->mname));

			$data = array(
				$i,
				'
					<button class="btn btn-sm bg-teal waves-effect" onclick="update_profile()"><i class="material-icons">person_pin</i> EDIT/UPDATE PROFILE</button>
					<button class="btn btn-sm bg-amber waves-effect" onclick="show_enrollment()"><i class="material-icons">event_note</i> ENROLLMENT</button>
				',
				$student->user_id, 
				$lname, 
				$fname, 
				$mname, 
				$student->course_name, 
				$student->section, 
				strtoupper($student->student_type)
			);

			$i++;

			array_push($output, $data);
		}

		// Output to JSON format
		echo json_encode(array("data"	=>	$output));
	}

	// public function enrollment_components()
	// {
	// 	// code...
	// }

	/*ENROLLMENT COMPONENTS*/
	public function college()
    {
        $collegeData = $this->encoder->getCollege();
        $htmlData = '<option value="-1">--- SELECT COURSE ---</option>';
        foreach ($collegeData as $college) 
        {
            $htmlData .= '<option value="'.$college->college_id.'">'.$college->college_name.'</option>';
        }

        return $htmlData;
    }

	public function enroll()
	{
		$id_number = $_POST['studid'];
		$semester = $_POST['semester'];
		$schedid = $_POST['schedid'];
		$section = $_POST['section'];
		$msg = array();

		$not_allowed_to_enroll = $this->encoder->get_not_allowed_to_enroll($id_number, 7);
		if (count($not_allowed_to_enroll) > 0) {
            $msg = array(
                'sys_msg'   =>  'FAILED',
                'msg'       =>  $not_allowed_to_enroll[0]->reason,
                'icon'      =>  'error'
            );
        }else{
            // $msg = array(
            //     'sys_msg'   =>  'allowed_to_enroll',
            //     'reason'    =>  ''
            // );

            $check_registration = $this->encoder->check_if_registered($schedid, $id_number, $semester);
            if (count($check_registration) > 0) 
            {
                $msg = array(
                    'sys_msg'   =>  'FAILED',
                    'msg'       =>  'ALREADY REGISTERED, CHECK YOUR STUDENT ENROLLMENT!!!',
                    'icon'      =>  'warning'
                );
            }else
            {
                $subject_slot = $this->encoder->subject_slot($schedid, $semester);
                $total_registered = $this->encoder->check_slot($schedid, $semester);

                // $updated_section = explode('_', $section1[0]->section)[0]."_".(explode('-', explode('_', $section1[0]->section)[1])[0] + 1)."-".explode('-', explode('_', $section1[0]->section)[1])[1];

               	$check_registration = $this->encoder->check_if_registered($schedid, $id_number, $semester);
            if (count($check_registration) > 0) 
            {
                $msg = array(
                    'sys_msg'   =>  'FAILED',
                    'msg'       =>  'ALREADY REGISTERED, CHECK YOUR STUDENT ENROLLMENT!!!',
                    'icon'      =>  'warning'
                );
            }else
            {
                $subject_slot = $this->encoder->subject_slot($schedid, $semester);
                $total_registered = $this->encoder->check_slot($schedid, $semester);

                // $updated_section = explode('_', $section1[0]->section)[0]."_".(explode('-', explode('_', $section1[0]->section)[1])[0] + 1)."-".explode('-', explode('_', $section1[0]->section)[1])[1];

                if ($subject_slot[0]->no_of_slot - count($total_registered) <= 0) 
                {
                    // $msg = array(
                    //     'sys_msg'   =>  'FAILED',
                    //     'msg'       =>  'NO SLOTS AVAILABLE!!!',
                    //     'icon'      =>  'info'
                    // );

                    $data_registration = array(
                        'user_id'           =>  $id_number,
                        'semester_id'       =>  $semester,
                        'schedid'           =>  $schedid,
                        'ra_status'         =>  'approved',
                        "date_of_agreement" =>  date("Y-m-d H:i:s")
                    );

                    $log_data = array(
                        'user_id'       =>  $_SESSION['uid'],
                        'action_taken'  =>  'enroll',
                        'action'        =>  json_encode($data_registration),
                        'date_created'  =>  date('Y-m-d H:i:s')
                    );

                    $enrollment_data = array(
                        'user_id'       =>  $id_number,
                        'semester_id'   =>  $semester,
                        'section'       =>  $section,
                        'date_created'  =>  date('Y-m-d H:i:s')
                    );
                    
                    $logs = $this->encoder->save_cog_logs($log_data, 'tbl_logs');
                    if ($logs !== false) 
                    {
                        $check_enrollment = $this->encoder->check_enrollment($id_number, $semester);
                        if (count($check_enrollment) > 0) {
                            $this->encoder->table = 'tbl_registration';
                            $save = $this->encoder->save($data_registration);
                            if ($save !== false) 
                            {
                                $msg = array(
                                    'sys_msg'   =>  'SUCCESS',
                                    'msg'       =>  'SUCCESSFULLY REGISTERED',
                                    'icon'      =>  'success',
                                    'no_slot'   =>  'NO SLOTS AVAILABLE!!!'
                                );
                            }else
                            {
                                $msg = array(
                                    'sys_msg'   =>  'FAILED',
                                    'msg'       =>  'PLEASE TRY AGAIN!!!',
                                    'icon'      =>  'error',
                                    'no_slot'   =>  ''
                                );
                            }
                        }else{
                            $this->encoder->table = 'tbl_enrollment';
                            $save_enrollment = $this->encoder->save($enrollment_data);
                            if ($save_enrollment !== false) 
                            {
                                $this->encoder->table = 'tbl_registration';
                                $save = $this->encoder->save($data_registration);
                                if ($save !== false) 
                                {
                                    $msg = array(
                                        'sys_msg'   =>  'SUCCESS',
                                        'msg'       =>  'SUCCESSFULLY REGISTERED',
                                        'icon'      =>  'success',
                                        'no_slot'   =>  'NO SLOTS AVAILABLE!!!'
                                    );
                                }else
                                {
                                    $msg = array(
                                        'sys_msg'   =>  'FAILED',
                                        'msg'       =>  'PLEASE TRY AGAIN!!!',
                                        'icon'      =>  'error',
                                        'no_slot'   =>  ''
                                    );
                                }
                            }else
                            {
                                $msg = array(
                                    'sys_msg'   =>  'FAILED',
                                    'msg'       =>  'PLEASE TRY AGAIN!!!',
                                    'icon'      =>  'error',
                                    'no_slot'   =>  ''
                                );
                            }
                        }
                            
                    }else
                    {
                        $msg = array(
                            'sys_msg'   =>  'FAILED',
                            'msg'       =>  'PLEASE TRY AGAIN!!!',
                            'icon'      =>  'error',
                            'no_slot'   =>  ''
                        );
                    }
                }else{
                    $data_registration = array(
                        'user_id'           =>  $id_number,
                        'semester_id'       =>  $semester,
                        'schedid'           =>  $schedid,
                        'ra_status'         =>  'approved',
                        "date_of_agreement" =>  date("Y-m-d H:i:s")
                    );

                    $log_data = array(
                        'user_id'       =>  $_SESSION['uid'],
                        'action_taken'  =>  'enroll',
                        'action'        =>  json_encode($data_registration),
                        'date_created'  =>  date('Y-m-d H:i:s')
                    );

                    $enrollment_data = array(
                        'user_id'       =>  $id_number,
                        'semester_id'   =>  $semester,
                        'section'       =>  $section,
                        'date_created'  =>  date('Y-m-d H:i:s')
                    );
                    
                    $logs = $this->encoder->save_cog_logs($log_data, 'tbl_logs');
                    if ($logs !== false) 
                    {
                        $check_enrollment = $this->encoder->check_enrollment($id_number, $semester);
                        if (count($check_enrollment) > 0) {
                            $this->encoder->table = 'tbl_registration';
                            $save = $this->encoder->save($data_registration);
                            if ($save !== false) 
                            {
                                $msg = array(
                                    'sys_msg'   =>  'SUCCESS',
                                    'msg'       =>  'SUCCESSFULLY REGISTERED',
                                    'icon'      =>  'success',
                                    'no_slot'   =>  ''
                                );
                            }else
                            {
                                $msg = array(
                                    'sys_msg'   =>  'FAILED',
                                    'msg'       =>  'PLEASE TRY AGAIN!!!',
                                    'icon'      =>  'error',
                                    'no_slot'   =>  ''
                                );
                            }
                        }else{
                            $this->encoder->table = 'tbl_enrollment';
                            $save_enrollment = $this->encoder->save($enrollment_data);
                            if ($save_enrollment !== false) 
                            {
                                $this->encoder->table = 'tbl_registration';
                                $save = $this->encoder->save($data_registration);
                                if ($save !== false) 
                                {
                                    $msg = array(
                                        'sys_msg'   =>  'SUCCESS',
                                        'msg'       =>  'SUCCESSFULLY REGISTERED',
                                        'icon'      =>  'success',
                                        'no_slot'   =>  ''
                                    );
                                }else
                                {
                                    $msg = array(
                                        'sys_msg'   =>  'FAILED',
                                        'msg'       =>  'PLEASE TRY AGAIN!!!',
                                        'icon'      =>  'error',
                                        'no_slot'   =>  ''
                                    );
                                }
                            }else
                            {
                                $msg = array(
                                    'sys_msg'   =>  'FAILED',
                                    'msg'       =>  'PLEASE TRY AGAIN!!!',
                                    'icon'      =>  'error',
                                    'no_slot'   =>  ''
                                );
                            }
                        }
                            
                    }else
                    {
                        $msg = array(
                            'sys_msg'   =>  'FAILED',
                            'msg'       =>  'PLEASE TRY AGAIN!!!',
                            'icon'      =>  'error',
                            'no_slot'   =>  ''
                        );
                    }
                }
            }
            }
        }

        echo json_encode($msg);
	}

	public function removeEnroll()
	{
		$user_id = $_POST['studid'];
		$semester = $_POST['semester'];
		$schedid = $_POST['schedid'];

		$msg = array();

        $data = array(
            "semester_id"   =>  $semester,
            "user_id"       =>  $user_id,
            "schedid"        =>  $schedid
        );

        $logs = array(
            "user_id"       =>  $_SESSION['uid'],
            "action_taken"  =>  "cancel",
            "action"        =>  json_encode($data),
            "date_created"  =>  date("Y-m-d H:i:s")
        );
        
        $this->encoder->table = 'tbl_logs';
        $save_log = $this->encoder->save($logs);
        if ($save_log !== false) {
            $this->encoder->table = 'tbl_registration';
            $delete = $this->encoder->delete($data);
            if ($delete) {
                $msg = array(
                    'sys_msg'   =>  'SUCCESS',
                    'msg'       =>  'SUCCESSFULLY REMOVED!!!',
                    'icon'      =>  'success'
                );
            }else{
                $msg = array(
                    'sys_msg'   =>  'FAILED',
                    'msg'       =>  'FAILED, PLEASE TRY AGAIN!!!',
                    'icon'      =>  'error'
                );
            }
        }else{
            $msg = array(
                'sys_msg'   =>  'FAILED',
                'msg'       =>  'FAILED, PLEASE TRY AGAIN!!!',
                'icon'      =>  'error'
            );
        }

        echo json_encode($msg);
	}

	public function enrollment_components()
	{
		// $semester = count($this->records_in_charge->getActiveSemester()) > 0 ? $this->records_in_charge->getActiveSemester()[0]->semester_id : 0;
		$student_data = $this->encoder->get_student_info($_POST['studid'], 6);
		$name = '---';
		$course = $_POST['course'];
		$section = $_POST['section'];
		$semester = $_POST['semester'];
		$htmlData = '';
		$i = 1;

		foreach ($student_data as $student) 
		{
			$name = $student->lname.", ".$student->fname." ".$student->mname;
			// $course = $student->course_desc;
			// $section = $student->section;
		}

		$subject_data = $this->encoder->get_class_schedule($section, $semester);

		foreach ($subject_data as $subject) 
		{
			$htmlData .= '<tr>';
				$htmlData .= '<td>'.($i++).'</td>';
				$htmlData .= '<td>
								<button class="btn btn-sm bg-teal" onclick="register(\''.$_POST['studid'].'\', \''.$semester.'\', \''.$subject->schedid.'\', \''.$section.'\')">ENROLL</button>
							</td>';
				$htmlData .= '<td>'.$subject->schedid.'</td>';
				$htmlData .= '<td>'.$subject->cat_no.'</td>';
				$htmlData .= '<td>'.($subject->day."|".$subject->time."|".$subject->room).'</td>';
				$htmlData .= '<td>'.$subject->units.'</td>';
				$htmlData .= '<td>'.$subject->section.'</td>';
			$htmlData .= '</tr>';
		}

		echo json_encode(array("name"	=>	$name, "htmlData"	=>	$htmlData));
	}

    public function showSubjects()
    {
        // $semester = count($this->records_in_charge->getActiveSemester()) > 0 ? $this->records_in_charge->getActiveSemester()[0]->semester_id : 0;
        $section = $_POST['section'];
        $idNumber = $_POST['studid'];
        $filter = $_POST['filter'];
        $semester = $_POST['semester'];

        $htmlData = "";
        $i = 1;
        $subject_data = $this->encoder->getClassScheduleByFilter($filter, $semester);

        foreach ($subject_data as $subject) 
        {
            $htmlData .= '<tr>';
                $htmlData .= '<td>'.($i++).'</td>';
                $htmlData .= '<td>
                                <button class="btn btn-sm bg-teal" onclick="register(\''.$idNumber.'\', \''.$semester.'\', \''.$subject->schedid.'\', \''.$section.'\')">ENROLL</button>
                            </td>';
                $htmlData .= '<td>'.$subject->schedid.'</td>';
                $htmlData .= '<td>'.$subject->cat_no.'</td>';
                $htmlData .= '<td>'.($subject->day."|".$subject->time."|".$subject->room).'</td>';
                $htmlData .= '<td>'.$subject->units.'</td>';
                $htmlData .= '<td>'.$subject->section.'</td>';
            $htmlData .= '</tr>';
        }

        echo json_encode(array("htmlData"   =>  $htmlData));
    }

    public function getCourse()
    {
        $courseData = $this->encoder->getCourse($_POST['collegeID']);
        $htmlData = '<option value="-1">--- SELECT COURSE ---</option>';
        foreach ($courseData as $course) 
        {
            $htmlData .= '<option value="'.$course->course_id.'">'.$course->course_name.'</option>';
        }

        echo json_encode(array("courseData" =>  $htmlData));
    }

    public function getSection()
    {
        $sectionData = $this->encoder->getSection($_POST['courseID']);
        $htmlData = '<option value="-1">--- SELECT SECTION ---</option>';
        foreach ($sectionData as $section) 
        {
            $htmlData .= '<option value="'.$section->section.'">'.$section->section.'</option>';
        }

        echo json_encode(array("sectionData" =>  $htmlData));
    }

	public function subject_enrolled()
	{
        // $semester = count($this->records_in_charge->getActiveSemester()) > 0 ? $this->records_in_charge->getActiveSemester()[0]->semester_id : 0;
		$semester = $_POST['semester'];
		$enrollData = $this->encoder->get_enrollment($_POST['studid'], $semester);
		$htmlData = '';
		$i = 1;
		$total_units = 0;

		foreach ($enrollData as $enroll) 
		{
			$htmlData .= '<tr>';
				$htmlData .= '<td>'.($i++).'</td>';
				$htmlData .= '<td>
								<button class="btn btn-sm bg-red" onclick="remove(\''.$_POST['studid'].'\', \''.$enroll->semester_id.'\', \''.$enroll->schedid.'\')">REMOVE</button>
							</td>';
				$htmlData .= '<td>'.$enroll->schedid.'</td>';
				$htmlData .= '<td>'.$enroll->cat_no.'</td>';
				$htmlData .= '<td>'.($enroll->day."|".$enroll->time."|".$enroll->room."|".$enroll->section).'</td>';
				$htmlData .= '<td>'.($enroll->weight == 1 ? $enroll->units : "[".$enroll->units."]" ).'</td>';
                $htmlData .= '<td>'.$enroll->ra_status.'</td>';
                $htmlData .= '<td>'.$enroll->decline_reason.'</td>';
			$htmlData .= '</tr>';
			if ($enroll->weight == 1) 
			{
				$total_units += intval($enroll->units);
			}
		}

			$htmlData .= '<tr>';
				$htmlData .= '<td></td>';
				$htmlData .= '<td></td>';
				$htmlData .= '<td></td>';
				$htmlData .= '<td></td>';
				$htmlData .= '<td>TOTAL UNITS</td>';
				$htmlData .= '<td>'.$total_units.'</td>';
			$htmlData .= '</tr>';
		echo json_encode(array("htmlData"	=>	$htmlData));
	}

	/*
    * Grades Module Functions
    */
	public function gradeList()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->records_in_charge->getGrades($postData);

		echo json_encode($data);
	}
	
	public function studentGradeList()
	{
		$userID = $_POST['studentID'];
		$semesterID = $_POST['semesterID'];
		$htmlData = "";
		$ctr = 1;
		
		$studentGradeListData = $this->records_in_charge->getStudentGrade($userID, $semesterID);

		foreach ($studentGradeListData as $studentGrade) 
		{
			$htmlData .= "<tr>";
				$htmlData .= "<td>".($ctr++)."</td>";
				$htmlData .= "<td>".$studentGrade->user_id."</td>";
				$htmlData .= "<td><input style='width: 150px;' class='form-control' type='text' name='gradeData[]' value='".$studentGrade->schedid."' readonly /></td>";
				$htmlData .= "<td><input style='width: 150px;' class='form-control' type='text' name='gradeData[]' value='".$studentGrade->teaching_faculty_id."' readonly /></td>";
				$htmlData .= "<td><input style='width: 150px;' class='form-control' type='text' name='gradeData[]' value='".$studentGrade->cat_no."' readonly /></td>";

				$individualStudentGrade = $this->records_in_charge->checkGrades($studentGrade->user_id, $studentGrade->cat_no, $semesterID, $studentGrade->teaching_faculty_id);
				$droppingData = $this->records_in_charge->getDropping($studentGrade->user_id, $studentGrade->schedid, $semesterID);

				$tmpEdit = "";

				if (count($individualStudentGrade) == 0)
				{
					$tmpEdit = " disabled";
					$htmlData .= "<td>";
						$htmlData .= "
							<select style='width: 150px;' class='form-control' name='gradeData[]' ".$tmpEdit.">
								<option value='-1'>SELECT GRADE</option>
								<option value='1.00'>1.00</option>
								<option value='1.25'>1.25</option>
								<option value='1.50'>1.50</option>
								<option value='1.75'>1.75</option>
								<option value='2.00'>2.00</option>
								<option value='2.25'>2.25</option>
								<option value='2.50'>2.50</option>
								<option value='2.75'>2.75</option>
								<option value='3.00'>3.00</option>
								<option value='5.00'>5.00</option>
								<option value='D'>D</option>
								<option value='FD'>FORCE DROPPED</option>
								<option value='NG'>NG</option>
								<option value='INC'>INC</option>
								<option value='IP'>IP</option>
							</select>
						";
					$htmlData .= "</td>";
					$htmlData .= "<td>";
						$htmlData .= "
							<select style='width: 150px;' class='form-control' name='gradeData[]' ".$tmpEdit.">
								<option value='-1'>SELECT GRADE</option>
								<option value='1.00'>1.00</option>
								<option value='1.25'>1.25</option>
								<option value='1.50'>1.50</option>
								<option value='1.75'>1.75</option>
								<option value='2.00'>2.00</option>
								<option value='2.25'>2.25</option>
								<option value='2.50'>2.50</option>
								<option value='2.75'>2.75</option>
								<option value='3.00'>3.00</option>
								<option value='5.00'>5.00</option>
								<option value='D'>D</option>
								<option value='FD'>FORCE DROPPED</option>
								<option value='NG'>NG</option>
								<option value='INC'>INC</option>
								<option value='IP'>IP</option>
							</select>
						";
					$htmlData .= "</td>";
					$htmlData .= "<td>----</td>";
					$htmlData .= "<td>----</td>";
				}else
				{
					$postedGrade = "";
					$postedReexam = "";
					$postedGrade = strtoupper($individualStudentGrade[0]->grades);
					$postedReexam = strtoupper($individualStudentGrade[0]->reexam);
					$tmpEdit = "";
					if ($postedGrade == "" || $postedGrade != "")
					{
						$tmpEdit = " disabled";
					}
					$htmlData .= "<td>";
						$htmlData .= "
							<select style='width: 150px;' class='form-control' name='gradeData[]' ".$tmpEdit.">
								<option value='-1' ".(strtoupper($postedGrade) == "" ? 'selected="true"' : "").">SELECT GRADE</option>
								<option value='1.00' ".(strtoupper($postedGrade) == "1.00" ? 'selected="true"' : "").">1.00</option>
								<option value='1.25' ".(strtoupper($postedGrade) == "1.25" ? 'selected="true"' : "").">1.25</option>
								<option value='1.50' ".(strtoupper($postedGrade) == "1.50" ? 'selected="true"' : "").">1.50</option>
								<option value='1.75' ".(strtoupper($postedGrade) == "1.75" ? 'selected="true"' : "").">1.75</option>
								<option value='2.00' ".(strtoupper($postedGrade) == "2.00" ? 'selected="true"' : "").">2.00</option>
								<option value='2.25' ".(strtoupper($postedGrade) == "2.25" ? 'selected="true"' : "").">2.25</option>
								<option value='2.50' ".(strtoupper($postedGrade) == "2.50" ? 'selected="true"' : "").">2.50</option>
								<option value='2.75' ".(strtoupper($postedGrade) == "2.75" ? 'selected="true"' : "").">2.75</option>
								<option value='3.00' ".(strtoupper($postedGrade) == "3.00" ? 'selected="true"' : "").">3.00</option>
								<option value='5.00' ".(strtoupper($postedGrade) == "5.00" ? 'selected="true"' : "").">5.00</option>
								<option value='D' ".(strtoupper($postedGrade) == "D" ? 'selected="true"' : "").">D</option>
								<option value='FD' ".(strtoupper($postedGrade) == "FD" ? 'selected="true"' : "").">FORCE DROPPED</option>
								<option value='NG' ".(strtoupper($postedGrade) == "NG" ? 'selected="true"' : "").">NG</option>
								<option value='INC' ".(strtoupper($postedGrade) == "INC" ? 'selected="true"' : "").">INC</option>
								<option value='IP' ".(strtoupper($postedGrade) == "IP" ? 'selected="true"' : "").">IP</option>
							</select>
						";
					$htmlData .= "</td>";
					$htmlData .= "<td>";
						$htmlData .= "
							<select style='width: 150px;' class='form-control' name='gradeData[]'>
								<option value='-1' ".(strtoupper($postedReexam) == "" ? 'selected="true"' : "").">SELECT GRADE</option>
								<option value='1.00' ".(strtoupper($postedReexam) == "1.00" ? 'selected="true"' : "").">1.00</option>
								<option value='1.25' ".(strtoupper($postedReexam) == "1.25" ? 'selected="true"' : "").">1.25</option>
								<option value='1.50' ".(strtoupper($postedReexam) == "1.50" ? 'selected="true"' : "").">1.50</option>
								<option value='1.75' ".(strtoupper($postedReexam) == "1.75" ? 'selected="true"' : "").">1.75</option>
								<option value='2.00' ".(strtoupper($postedReexam) == "2.00" ? 'selected="true"' : "").">2.00</option>
								<option value='2.25' ".(strtoupper($postedReexam) == "2.25" ? 'selected="true"' : "").">2.25</option>
								<option value='2.50' ".(strtoupper($postedReexam) == "2.50" ? 'selected="true"' : "").">2.50</option>
								<option value='2.75' ".(strtoupper($postedReexam) == "2.75" ? 'selected="true"' : "").">2.75</option>
								<option value='3.00' ".(strtoupper($postedReexam) == "3.00" ? 'selected="true"' : "").">3.00</option>
								<option value='5.00' ".(strtoupper($postedReexam) == "5.00" ? 'selected="true"' : "").">5.00</option>
								<option value='D' ".(strtoupper($postedReexam) == "D" ? 'selected="true"' : "").">D</option>
								<option value='FD' ".(strtoupper($postedReexam) == "FD" ? 'selected="true"' : "").">FORCE DROPPED</option>
								<option value='NG' ".(strtoupper($postedReexam) == "NG" ? 'selected="true"' : "").">NG</option>
								<option value='INC' ".(strtoupper($postedReexam) == "INC" ? 'selected="true"' : "").">INC</option>
								<option value='IP' ".(strtoupper($postedReexam) == "IP" ? 'selected="true"' : "").">IP</option>
							</select>
						";
					$htmlData .= "</td>";
					$htmlData .= "<td>".$individualStudentGrade[0]->remarks."</td>";
					$htmlData .= "<td>".$individualStudentGrade[0]->status."</td>";
				}
				
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

		$scheduleID = '';
		$gradeFaculty = '';
		$grade = '';
		$reexam = '';
		$cat_no = '';

		for ($i = 0 ; $i < count($gradeData); $i++)
		{
			
			switch ($ctr)
			{
				case 1:
					$scheduleID = $gradeData[$i];
					break;
				case 2:
					$gradeFaculty = $gradeData[$i];
					break;
				case 3:
					$cat_no = $gradeData[$i];
					break;
				case 4:
					$grade = $gradeData[$i];
					break;
				case 5:
					$reexam = $gradeData[$i];
					break;
			}

			if ($ctr == 5)
			{
				$data = array();
				$condtion = array(
					"subject"	=>	$cat_no,
					"semester_id"	=>	$semester,
					"user_id"	=>	$studentID
				);

				/**
				 * 
				 */
				if ($action == "save")
				{
					if ($grade != -1 && $reexam != -1)
					{
						if ($action == "save")
						{
							$data = array(
								"semester_id"	=>	$semester,
								"user_id"		=>	$studentID,
								"faculty_id"	=>	$gradeFaculty,
								"subject"		=>	$cat_no,
								"units"			=>	0,
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"weight"		=> 	0,
								"status"		=>	'approved'

							);
						}
					}else if ($grade != -1 && $reexam == -1)
					{
						if ($action == "save")
						{
							$data = array(
								"semester_id"	=>	$semester,
								"user_id"		=>	$studentID,
								"faculty_id"	=>	$gradeFaculty,
								"subject"		=>	$cat_no,
								"units"			=>	0,
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"weight"		=> 	0,
								"status"		=>	'approved'

							);
						}
					}else if ($grade == -1 && $reexam != -1)
					{
						if ($action == "save")
						{
							$data = array(
								"semester_id"	=>	$semester,
								"user_id"		=>	$studentID,
								"faculty_id"	=>	$gradeFaculty,
								"subject"		=>	$cat_no,
								"units"			=>	0,
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"weight"		=> 	0,
								"status"		=>	'approved'

							);
						}
					}
				}

				// array_push($output, $condtion);
				// Get Old Data
				$gradeOldData = $this->administrator->getGradesOldData($condtion);
				foreach ($gradeOldData as $gradeVal) 
				{
					$data = array();
					if ($grade != -1 && $reexam != -1)
					{
						if ($action == "save")
						{
							$data = array(
								"semester_id"	=>	$semester,
								"user_id"		=>	$studentID,
								"faculty_id"	=>	$gradeFaculty,
								"subject"		=>	$cat_no,
								"units"			=>	0,
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"weight"		=> 	0,
								"status"		=>	'approved'

							);
						}else
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
						}
					}else if ($grade != -1 && $reexam == -1)
					{
						if ($action == "save")
						{
							$data = array(
								"semester_id"	=>	$semester,
								"user_id"		=>	$studentID,
								"faculty_id"	=>	$gradeFaculty,
								"subject"		=>	$cat_no,
								"units"			=>	0,
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"weight"		=> 	0,
								"status"		=>	'approved'

							);
						}else
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
						}
					}else if ($grade == -1 && $reexam != -1)
					{
						if ($action == "save")
						{
							$data = array(
								"semester_id"	=>	$semester,
								"user_id"		=>	$studentID,
								"faculty_id"	=>	$gradeFaculty,
								"subject"		=>	$cat_no,
								"units"			=>	0,
								"grades"		=>	$grade,
								"remarks"		=>	$this->gradeRemarks($grade),
								"weight"		=> 	0,
								"status"		=>	'approved'

							);
						}else
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
						if ($action == "save")
						{

							if ($grade == "D" || $reexam == "D")
							{
								$data = array(
									"studid"		=>	$studentID,
									"fl_id"			=>	0,
									"date_request"	=>	date("Y-m-d H:i:s"),
									"status"		=>	"encoded",
									"request_type"	=>	"drop",
									"schedid"		=>	$scheduleID,
									"semester_id"	=> 	$semester
	
								);
								$saveGrade = $this->administrator->save("tbl_dropping", $data);
							}else
							{
								$data = array();
							}
						}else if ($action == "update")
						{
							$saveGrade = $this->administrator->update($data, $condtion, array("tbl_grades"));
						}
						
						if ($saveGrade !== false)
						{
							$msg = array(
								"sys_msg"	=> 	"success",
								"msg"		=>	"Successfully updated",
								"icon"		=>	"success",
								"test"		=>	json_encode($data)
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
	 * END CRUD
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
				break;
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
	 * END of OTHER FUNCTION
	 */
}

/* End of file Records_in_charge.php */
/* Location: ./application/controllers/Records_in_charge.php */