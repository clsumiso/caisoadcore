<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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


class Encoder extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Encoder_model', 'encoder');
		$this->load->helper('date');
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
			'name'				=>	$_SESSION['account_name'],
			'user_type'			=>	strtoupper($_SESSION['utype']),
			'email'				=>	$_SESSION['e_id'],
			'get_time'			=>	$this->get_time(),
            'college'           =>  $this->college()
		);
		$this->load->view('encoder/_header', $data);
	    $this->load->view('encoder/_css', $data);
	    $this->load->view('encoder/encoder_view', $data);
	    $this->load->view('encoder/_footer', $data);
	    $this->load->view('encoder/_js', $data);
	}

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

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
		$semester = 7;
		$student_data = $this->encoder->get_student_info($_POST['studid'], 6);
		$name = '---';
		$course = $_POST['course'];
		$section = $_POST['section'];
		$htmlData = '';
		$i = 1;
        $approve = 0;
        $decline = 0;
        $pending = 0;

		foreach ($student_data as $student) 
		{
			$name = $student->lname.", ".$student->fname." ".$student->mname;
			// $course = $student->course_desc;
			// $section = $student->section;
		}

		$subject_data = $this->encoder->get_class_schedule($section, $semester);

		foreach ($subject_data as $subject) 
		{
            $approve = count($this->encoder->get_enrolled($subject->schedid, 'approved', 7));
            $decline = count($this->encoder->get_enrolled($subject->schedid, 'declined', 7));
            $decline = count($this->encoder->get_enrolled($subject->schedid, '', 7));
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
                $htmlData .= '<td>'.$approve.'</td>';
                $htmlData .= '<td>'.$decline.'</td>';
                $htmlData .= '<td>'.$pending.'</td>';
                $htmlData .= '<td>'.($approve + $decline + $pending).'</td>';
			$htmlData .= '</tr>';
		}

		echo json_encode(array("name"	=>	$name, "htmlData"	=>	$htmlData));
	}

    public function showSubjects()
    {
        $semester = 7;
        $section = $_POST['section'];
        $idNumber = $_POST['studid'];
        $filter = $_POST['filter'];
        $htmlData = "";
        $i = 1;
        $approve = 0;
        $decline = 0;
        $pending = 0;
        $subject_data = $this->encoder->getClassScheduleByFilter($filter, 7);

        foreach ($subject_data as $subject) 
        {
            $approve = count($this->encoder->get_enrolled($subject->schedid, 'approved', 7));
            $decline = count($this->encoder->get_enrolled($subject->schedid, 'declined', 7));
            $decline = count($this->encoder->get_enrolled($subject->schedid, '', 7));
            
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
                $htmlData .= '<td>'.$approve.'</td>';
                $htmlData .= '<td>'.$decline.'</td>';
                $htmlData .= '<td>'.$pending.'</td>';
                $htmlData .= '<td>'.($approve + $decline + $pending).'</td>';
            $htmlData .= '</tr>';
        }

        echo json_encode(array("htmlData"   =>  $htmlData));
    }

    public function getCourse()
    {
        $courseData = $this->encoder->getCourse($_POST['collegeID']);
        $htmlData = '<option value="-1" selected>--- SELECT COURSE ---</option>';
        foreach ($courseData as $course) 
        {
            $htmlData .= '<option value="'.$course->course_id.'">'.$course->course_name.'</option>';
        }

        echo json_encode(array("courseData" =>  $htmlData));
    }

    public function getSection()
    {
        $sectionData = $this->encoder->getSection($_POST['courseID']);
        $htmlData = '<option value="-1" selected>--- SELECT SECTION ---</option>';
        foreach ($sectionData as $section) 
        {
            $htmlData .= '<option value="'.$section->section.'">'.$section->section.'</option>';
        }

        echo json_encode(array("sectionData" =>  $htmlData));
    }

	public function subject_enrolled()
	{
		$enrollData = $this->encoder->get_enrollment($_POST['studid'], 7);
		$htmlData = '';
		$i = 1;

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
				$htmlData .= '<td>'.$enroll->units.'</td>';
                $htmlData .= '<td>'.$enroll->ra_status.'</td>';
                $htmlData .= '<td>'.$enroll->decline_reason.'</td>';
			$htmlData .= '</tr>';
		}
		echo json_encode(array("htmlData"	=>	$htmlData));
	}

    public function studentInformation()
    {
        
    }

}

/* End of file Encoder.php */
/* Location: ./application/controllers/Encoder.php */