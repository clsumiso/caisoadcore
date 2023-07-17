<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('faculty_model', 'faculty');
		$this->load->helper('date');
	}

	public function verify_session()
	{
        if (!isset($_SESSION['uid'])) 
        {
        	echo 0;
        }else
        {
        	echo 1;
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
			'semester'			=>	$this->semester(),
			'get_time'			=>	$this->get_time()
		);
		$this->load->view('faculty/_header', $data);
	    $this->load->view('faculty/_css', $data);
	    $this->load->view('faculty/faculty_view', $data);
	    $this->load->view('faculty/_footer', $data);
	    $this->load->view('faculty/_js', $data);
	}

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

	public function semester()
	{
		$semester_data = $this->faculty->get_semester();
		$htmlContent = '<option value="#">-- SELECT SEMESTER --</option>';

		foreach ($semester_data as $semester) 
		{
			$htmlContent .= '<option value="'.$semester->semester_id.'">'.$semester->semester_name.' '.$semester->semester_year.'</option>';
		}

		return $htmlContent;
	}

	public function subject_filter()
	{
		$htmlContent = '';
		if ($_POST['semid'] >= 3 && $_POST['semid'] <= 5) 
		{
			$subject_filter_data = $this->faculty->get_subjects_new_grades($_POST['semid'], $_SESSION['e_id']);
			$htmlContent = '<option value="#">-- SELECT SUBJECT --</option>';

			foreach ($subject_filter_data as $subject_filter) 
			{
				$htmlContent .= '<option value="'.$subject_filter->schedid.'">'.$subject_filter->cat_no.' ('.$subject_filter->section.')('.$subject_filter->schedid.')</option>';
			}
		}else if($_POST['semid']>=6){
			$subject_filter_data = $this->faculty->get_subjects_new_grades($_POST['semid'], $_SESSION['e_id']);
			$htmlContent = '<option value="#">-- SELECT SUBJECT --</option>';

			foreach ($subject_filter_data as $subject_filter) 
			{
				$htmlContent .= '<option value="'.$subject_filter->schedid.'">'.$subject_filter->cat_no.' ('.$subject_filter->section.')</option>';
			}
		}

		else
		{
			$subject_filter_data = $this->faculty->get_subjects_old_grades($_POST['semid'], $_SESSION['e_id']);
			$htmlContent = '<option value="#">-- SELECT SUBJECT --</option>';

			foreach ($subject_filter_data as $subject_filter) 
			{
				$htmlContent .= '<option value="'.$subject_filter->subject.'">'.$subject_filter->subject.'</option>';
			}
		}

		echo json_encode(array(
			'sem_id'	=>	$_POST['semid'],
			'content'	=>	$htmlContent,
		));
	}

	public function manage_grades()
	{
		
		$output = array();
		$tmp_date = '';
		$datestringY = '%Y';
		$datestringM = '%m';
		$datestringD = '%d';
		$time = time();
		$tmp_dateY = mdate($datestringY, $time);
		$tmp_dateD = mdate($datestringD, $time);
		$tmp_dateM = mdate($datestringM, $time);
		$student_arr = array('@');
		$cat_no = '';

		if ($_POST['semid'] >= 3 && $_POST['semid'] <= 5) 
		{
			/*Get student ID on the class list*/
			$class_list = $this->faculty->get_students_on_class_list($_POST['subject'], $_POST['semid']);
			foreach ($class_list as $student) 
			{
				array_push($student_arr, $student->user_id);
			}
			/*End of func*/
			
			$schedule_info = $this->faculty->get_class_schedule_info($_POST['subject'], $_POST['semid']);
			foreach ($schedule_info as $schedule) 
			{
				$cat_no = $schedule->cat_no;
			}
			/*End of func*/

			$manage_grades_data = $this->faculty->get_new_grades($_POST['semid'], $cat_no, $_SESSION['e_id'], $student_arr);
			$i = 0;
			$output = array();
			foreach($manage_grades_data as $manage_grades)
			{
				$i++;

				if (intval($tmp_dateY) - intval(date('Y', strtotime($manage_grades->date_uploaded))) >= 1 
					&& intval($tmp_dateM) - intval(date('m', strtotime($manage_grades->date_uploaded))) >= 1 
					&& intval($tmp_dateD) - intval(date('d', strtotime($manage_grades->date_uploaded))) >= 1) 
				{
					if (strtoupper($manage_grades->grades) === 'NG' && strtoupper($manage_grades->reexam) === '') 
					{
						$data = array(
							$i,
							// '<button class="btn btn-lg btn-primary waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
							'<p class="font-bold col-pink">LAPSED</p>',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}else if (strtoupper($manage_grades->grades) === 'NG' && strtoupper($manage_grades->reexam) === 'NG') 
					{
						$data = array(
							$i,
							// '<button class="btn btn-lg btn-primary waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
							'<p class="font-bold col-pink">LAPSED</p>',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}else if (strtoupper($manage_grades->grades) !== 'NG' && strtoupper($manage_grades->reexam) === '') 
					{
						$data = array(
							$i,
							'CLOSED',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}else if (strtoupper($manage_grades->grades) !== 'NG' && strtoupper($manage_grades->reexam) !== 'NG') 
					{
						$data = array(
							$i,
							'CLOSED',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}
				}else
				{
					if ($manage_grades->status == 'faculty') 
					{
						$data = array(
							$i,
							'<button class="btn btn-lg btn-warning waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}else if ($manage_grades->status == 'department head') 
					{
						$data = array(
							$i,
							// '<button class="btn btn-lg btn-primary waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
							'<p class="font-bold col-teal">PENDING (DEPARTMENT HEAD)</p>',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}else if ($manage_grades->status == 'dean') 
					{
						$data = array(
							$i,
							// '<button class="btn btn-lg btn-primary waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
							'<p class="font-bold col-orange">PENDING (DEAN)</p>',
							$manage_grades->user_id,
							$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
							$manage_grades->semester_name.' '.$manage_grades->semester_year,
							$manage_grades->subject, 
							$manage_grades->units, 
							$manage_grades->grades, 
							$manage_grades->reexam, 
							$manage_grades->remarks, 
							$manage_grades->status, 
							$manage_grades->date_faculty_approve, 
							$manage_grades->date_dept_approve, 
							$manage_grades->date_dean_approve, 
							$manage_grades->date_uploaded
						);
					}else if ($manage_grades->status == 'approved') 
					{
						if (strtoupper($manage_grades->grades) === 'NG' && strtoupper($manage_grades->reexam) === '') 
						{
							$data = array(
								$i,
								'<button class="btn btn-lg btn-warning waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
								$manage_grades->user_id,
								$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
								$manage_grades->semester_name.' '.$manage_grades->semester_year,
								$manage_grades->subject, 
								$manage_grades->units, 
								$manage_grades->grades, 
								$manage_grades->reexam, 
								$manage_grades->remarks, 
								$manage_grades->status, 
								$manage_grades->date_faculty_approve, 
								$manage_grades->date_dept_approve, 
								$manage_grades->date_dean_approve, 
								$manage_grades->date_uploaded
							);
						}else if (strtoupper($manage_grades->grades) === 'NG' && strtoupper($manage_grades->reexam) === 'NG') 
						{
							$data = array(
								$i,
								'<button class="btn btn-lg btn-warning waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
								$manage_grades->user_id,
								$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
								$manage_grades->semester_name.' '.$manage_grades->semester_year,
								$manage_grades->subject, 
								$manage_grades->units, 
								$manage_grades->grades, 
								$manage_grades->reexam, 
								$manage_grades->remarks, 
								$manage_grades->status, 
								$manage_grades->date_faculty_approve, 
								$manage_grades->date_dept_approve, 
								$manage_grades->date_dean_approve, 
								$manage_grades->date_uploaded
							);
						}else
						{
							$data = array(
								$i,
								'CLOSED',
								$manage_grades->user_id,
								$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
								$manage_grades->semester_name.' '.$manage_grades->semester_year,
								$manage_grades->subject, 
								$manage_grades->units, 
								$manage_grades->grades, 
								$manage_grades->reexam, 
								$manage_grades->remarks, 
								$manage_grades->status, 
								$manage_grades->date_faculty_approve, 
								$manage_grades->date_dept_approve, 
								$manage_grades->date_dean_approve, 
								$manage_grades->date_uploaded
							);
						}
						
					}
				}
				

				$output[] = $data;
			}
		}else
		{
			// Fetch member's records
			$manage_grades_data = $this->faculty->get_old_grades($_POST['semid'], $_POST['subject'], $_SESSION['e_id']);
			$i = 0;
			$output = [];
			foreach($manage_grades_data as $manage_grades)
			{
				$i++;
				$data = array(
					$i,
					// '<button class="btn btn-lg btn-primary waves-effect" data-toggle="modal" data-target="#largeModal" onclick="">UPDATE</button>',
					'CLOSED',
					$manage_grades->user_id,
					$manage_grades->lname.', '.$manage_grades->fname.' '.$manage_grades->mname,
					$manage_grades->semester_name.' '.$manage_grades->semester_year,
					$manage_grades->subject, 
					$manage_grades->units, 
					$manage_grades->grades, 
					$manage_grades->reexam, 
					$manage_grades->remarks, 
					$manage_grades->status, 
					$manage_grades->date_faculty_approve, 
					$manage_grades->date_dept_approve, 
					$manage_grades->date_dean_approve, 
					$manage_grades->date_uploaded
				);

				$output[] = $data;
			}
		}

		// Output to JSON format
		echo json_encode(
			array(
				"data"	=>	$output
			)
		);
	}

	public function teaching_load_subject()
	{
		$teaching_load_subject = $this->faculty->get_teaching_load_subjects($_POST['semid']);
		$output = array();
		$i = 1;
		foreach ($teaching_load_subject as $teaching_load) 
		{
			if ($teaching_load->faculty_id != NULL) 
			{
				if ($teaching_load->faculty_id == $_SESSION['e_id']) 
				{
					$data = array(
						$i,
						'<button class="btn btn-lg btn-danger waves-effect" onclick="remove_to_my_loads(\''.$_SESSION['e_id'].'\', \''.$teaching_load->schedid.'\', \''.$_POST['semid'].'\', \''.$i.'\', \''.'NOT YET ASSIGNED'.'\')">REMOVE TO MY LOADS</button>',
						$teaching_load->schedid,
						$teaching_load->semester_name.' '.$teaching_load->semester_year,
						$teaching_load->cat_no,
						$teaching_load->units,
						$teaching_load->day,
						$teaching_load->time,
						$teaching_load->room,
						$teaching_load->section,
						$teaching_load->dept_desc,
						$teaching_load->faculty_id != NULL ? $teaching_load->faculty_id : 'NOT YET ASSIGNED'
					);
				}else
				{
					$data = array(
						$i,
						'<p class="font-bold col-pink">already assigned</p>',
						$teaching_load->schedid,
						$teaching_load->semester_name.' '.$teaching_load->semester_year,
						$teaching_load->cat_no,
						$teaching_load->units,
						$teaching_load->day,
						$teaching_load->time,
						$teaching_load->room,
						$teaching_load->section,
						$teaching_load->dept_desc,
						$teaching_load->faculty_id != NULL ? $teaching_load->faculty_id : 'NOT YET ASSIGNED'
					);
				}
			}else
			{
				$data = array(
					$i,
					'<button class="btn btn-lg btn-primary waves-effect" onclick="add_to_my_loads(\''.$_SESSION['e_id'].'\', \''.$teaching_load->schedid.'\', \''.$_POST['semid'].'\', \''.$i.'\', \''.$_SESSION['e_id'].'\')">ADD TO MY LOADS</button>',
					$teaching_load->schedid,
					$teaching_load->semester_name.' '.$teaching_load->semester_year,
					$teaching_load->cat_no,
					$teaching_load->units,
					$teaching_load->day,
					$teaching_load->time,
					$teaching_load->room,
					$teaching_load->section,
					$teaching_load->dept_desc,
					$teaching_load->faculty_id != NULL ? $teaching_load->faculty_id : 'NOT YET ASSIGNED'
				);
			}

			$i++;

			array_push($output, $data);
		}

		// Output to JSON format
		echo json_encode(array("data"	=>	$output));
	}

	public function remove_to_my_loads()
	{
		$email = $_POST['email'];
		$schedid = $_POST['schedid'];
		$semid = $_POST['semid'];
		$logs_data = array();
		$msg = array();

		$datestring = '%F, %d %Y %H:%i:%s';
		$time = time();

		$get_teaching_loads = $this->faculty->get_teaching_loads($email, $schedid, $semid);
		foreach ($get_teaching_loads as $teaching_loads) 
		{
			$logs = array(
				'user_id'		=>	$teaching_loads->user_id, 
				'semester_id'	=>	$teaching_loads->semester_id, 
				'schedid'		=>	$teaching_loads->schedid,
				'cat_no'		=>	$teaching_loads->cat_no, 
				'date_created'	=>	$teaching_loads->date_created
			);


			array_push($logs_data, $logs);
		}

		$logs_output = array(
			'user_id'		=>	$_POST['email'],
			'action_taken'	=>	'removed',
			'action'		=>	json_encode($logs_data),
			'date_created'	=>	mdate($datestring, $time)
		);

		$condition = array(
			'semester_id'	=>	$semid,
			'user_id'		=>	$email,
			'schedid'		=>	$schedid
		);

		if ($this->faculty->save('tbl_logs', $logs_output) === true)
		{
			if ($this->faculty->delete('tbl_teaching_loads', $condition) === true) 
			{
				$msg = array(
					'sys_msg'	=>	1,
					'msg'		=>	'Success',
					'icon'		=>	'success'
				);
			}else
			{
				$msg = array(
					'sys_msg'	=>	0,
					'msg'		=>	'Failed, please try again',
					'icon'		=>	'error'
				);
			}
		}else
		{
			$msg = array(
				'sys_msg'	=>	0,
				'msg'		=>	'Failed, please try again',
				'icon'		=>	'error'
			);
		}

		echo json_encode($msg);
	}

	public function add_to_my_loads()
	{
		$email = $_POST['email'];
		$schedid = $_POST['schedid'];
		$semid = $_POST['semid'];
		$logs_data = array();
		$msg = array();

		$datestring = '%F, %d %Y %H:%i:%s';
		$time = time();

		$get_teaching_loads = $this->faculty->get_teaching_loads($email, $schedid, $semid);
		foreach ($get_teaching_loads as $teaching_loads) 
		{
			$logs = array(
				'user_id'		=>	$teaching_loads->user_id, 
				'semester_id'	=>	$teaching_loads->semester_id, 
				'schedid'		=>	$teaching_loads->schedid,
				'cat_no'		=>	$teaching_loads->cat_no, 
				'date_created'	=>	$teaching_loads->date_created
			);


			array_push($logs_data, $logs);
		}

		$data = array(
			'semester_id'	=>	$semid,
			'user_id'		=>	$email,
			'schedid'		=>	$schedid,
			'date_created'	=>	mdate($datestring, $time)
		);


		$logs_output = array(
			'user_id'		=>	$_POST['email'],
			'action_taken'	=>	'add',
			'action'		=>	json_encode($data),
			'date_created'	=>	mdate($datestring, $time)
		);

		if ($this->faculty->save('tbl_logs', $logs_output) === true)
		{
			if ($this->faculty->save('tbl_teaching_loads', $data) === true) 
			{
				$msg = array(
					'sys_msg'	=>	1,
					'msg'		=>	'Success',
					'icon'		=>	'success'
				);
			}else
			{
				$msg = array(
					'sys_msg'	=>	0,
					'msg'		=>	'Failed, please try again',
					'icon'		=>	'error'
				);
			}
		}else
		{
			$msg = array(
				'sys_msg'	=>	0,
				'msg'		=>	'Failed, please try again',
				'icon'		=>	'error'
			);
		}

		echo json_encode($msg);
	}

	public function grades_subject_list()
	{
		$sem = $_POST['semid'];
		$schedid = $_POST['schedid'];
		$user_id = $_SESSION['uid'];
		$e_id = $_SESSION['e_id'];
		$usr_arr = array();
		$non_email_user = $this->faculty->get_non_email_user($e_id);
		foreach ($non_email_user as $email) {
			array_push($usr_arr, $email->user_id);
		}

		array_push($usr_arr, $e_id);
		$subject_list = $this->faculty->get_subject($user_id, $sem, $e_id, $usr_arr, $schedid);
		$_SESSION['class_rec_sem_filter']	= $sem;
		$i = 1;
		$output = [];
		foreach($subject_list as $subject){
			$enrolled = $this->faculty->get_enrolled($subject->schedid, $sem);
			$total_enrolled = count($enrolled) > 0 ? count($enrolled) : 0;
			$class_record_id = $this->faculty->get_profile_id($subject->user_id);
			$class_rec_id = count($class_record_id) > 0 ? $class_record_id[0]->profile_id."_".$sem."_".$subject->schedid : "error";
			$cps = count($this->faculty->get_cps($class_rec_id)) > 0 ? $this->faculty->get_cps($class_rec_id)[0]->class_standard : 0;

			if ($subject->class_type == 2) {
				$data = array(
					$i++,
					'<a href="javascript:void(0)" target="_self" class="btn btn-sm btn-default btn-block" onclick="show_rog_tracker(\''.$subject->schedid.'\', \''.$sem.'\')"><i class="fas fa-search"></i> ROG TRACKER</a>',
					$subject->schedid,
					$subject->cat_no,
					$subject->units,
					$subject->day,
					$subject->time,
					$subject->room,
					$subject->section,
					$total_enrolled
				);
			}else{
				$data = array(
					$i++,
					'
					<a href="/star/manage-grades/'.$class_rec_id.'/'.$sem.'" target="_self" class="btn btn-sm bg-green btn-block"><i class="fas fa-edit"></i> MANAGE</a>

					<a href="/star/faculty/export_students/'.$class_rec_id.'/'.$sem.'" target="_self" class="btn btn-sm bg-yellow btn-block"><i class="fas fa-file-export"></i> GRADES TEMPLATE</a>
					
					<a href="javascript:void(0)" target="_self" class="btn btn-sm btn-default btn-block" onclick="show_rog_tracker(\''.$subject->schedid.'\', \''.$sem.'\')"><i class="fas fa-search"></i> ROG TRACKER</a>

					<button class="btn btn-sm btn-default btn-block" onclick="import_grades(\''.$sem.'\', \''.$subject->schedid.'\')"><i class="fas fa-file-import"></i> IMPORT GRADES</button>

					<a href="#'.$class_rec_id.'/'.$sem.'" target="_self" class="btn btn-sm btn-default btn-block"><i class="fas fa-download"></i> GENERATE ROG</a>',
					$subject->schedid,
					$subject->cat_no,
					$subject->units,
					$subject->day,
					$subject->time,
					$subject->room,
					$subject->section,
					$total_enrolled
				);


			}

			$output[] = $data;
		}

		// Output to JSON format
		echo json_encode(array("data"	=>	$output));
	}

	public function grades_subject_list_old()
	{
		$sem = $_POST['semid'];
		$e_id = $_SESSION['e_id'];
		$usr_arr = array();
		$non_email_user = $this->faculty->get_non_email_user($e_id);
		foreach ($non_email_user as $email) {
			array_push($usr_arr, $email->user_id);
		}

		$subject_list = $this->faculty->get_grades_old_system($usr_arr, $sem);
		$_SESSION['class_rec_sem_filter']= $sem;
		$i = 1;
		$output = [];
		
		foreach($subject_list as $subject){
			$enrolled = $this->faculty->get_enrolled($subject->subject, $sem);
			$total_enrolled = count($enrolled) > 0 ? count($enrolled) : 0;
			$class_record_id = $this->faculty->get_profile_id($subject->user_id);
			$class_rec_id = count($class_record_id) > 0 ? $class_record_id[0]->profile_id."_".$sem."_".$subject->subject : "error";
			$cps = count($this->faculty->get_cps($class_rec_id)) > 0 ? $this->faculty->get_cps($class_rec_id)[0]->class_standard : 0;

			$data = array(
				$i++,
				'
				<a href="/star/manage-grades-old/'.$subject->subject.'/'.$sem.'" target="_self" class="btn btn-sm bg-green btn-block"><i class="fas fa-edit"></i> MANAGE</a>

				<a href="/star/faculty/export_students_old/'.$subject->subject.'/'.$sem.'" target="_self" class="btn btn-sm bg-yellow btn-block"><i class="fas fa-file-export"></i> EXPORT GRADES</a>
				
				<a href="javascript:void(0)" target="_self" class="btn btn-sm btn-default btn-block" onclick="show_rog_tracker()"><i class="fas fa-search"></i> ROG TRACKER</a>

				<button class="btn btn-sm btn-default btn-block" onclick="import_grades_old(\''.$sem.'\', \''.$subject->subject.'\')"><i class="fas fa-file-import"></i> IMPORT GRADES</button>

				<a href="#'.$class_rec_id.'/'.$sem.'" target="_self" class="btn btn-sm btn-default btn-block"><i class="fas fa-download"></i> GENERATE ROG</a>',
				$subject->subject,
				$subject->subject,
				$subject->units,
				$subject->day,
				$subject->time,
				'***',
				'***',
				'***'
			);

			$output[] = $data;
		}

		echo json_encode(array("data"	=>	$output));
	}


	public function get_student_grade($semid, $schedid)
	{
		//$class_rec_id = $schedid;
		//$schedid = explode('_', $schedid)[2];
		$enrolled_data = $this->faculty->get_enrolled_student($schedid, $semid);
		$html_data = '';
		$i = 1;

		foreach ($enrolled_data as $data) {
			// Get student grades
			$student_grade = $this->facultylty->get_student_grade($data->reg_id, $schedid,$semid);
			$grade = '';
			$reexam = '';
			$remarks = '';
			$grade_to_post = 1;
			if (count($student_grade) > 0) {
				if ($student_grade[0]->grades == '0.00') {
					$grade = 'NO GRADE SUBMITTED';
					$remarks = '<span class="badge badge-secondary">***</span>';
				}else{
					$grade = $student_grade[0]->grades;
					if (in_array($grade, array('NG', 'IP'))) {
						$remarks = '<span class="badge badge-secondary">'.$student_grade[0]->remarks.'</span>';
					}else{
						if (floatval($grade) <= 3.00) {
							$remarks = '<span class="badge badge-success">'.$student_grade[0]->remarks.'</span>';
						}else{
							if (floatval($grade) == 4.00) {
								$remarks = '<span class="badge badge-warning">'.$student_grade[0]->remarks.'</span>';
							}
							
							if (floatval($grade) == 5.00) {
								$remarks = '<span class="badge badge-danger">'.$student_grade[0]->remarks.'</span>';
							}
							
						}
					}
				}

				if ($student_grade[0]->reexam !== NULL) {
					if ($student_grade[0]->reexam == '0.00') {
						$reexam = 'NO GRADE SUBMITTED';
						$remarks = '<span class="badge badge-secondary">***</span>';
					}else{
						$reexam = $student_grade[0]->reexam;
						if (in_array($reexam, array('NG', 'IP'))) {
							$remarks = '<span class="badge badge-secondary">'.$student_grade[0]->remarks.'</span>';
						}else{
							if (floatval($reexam) <= 3.00) {
								$remarks = '<span class="badge badge-success">'.$student_grade[0]->remarks.'</span>';
							}else{
								if (floatval($reexam) == 4.00) {
									$remarks = '<span class="badge badge-warning">'.$student_grade[0]->remarks.'</span>';
								}
								
								if (floatval($reexam) == 5.00) {
									$remarks = '<span class="badge badge-danger">'.$student_grade[0]->remarks.'</span>';
								}
								
							}
						}
					}
				}

				$grade_to_post = $student_grade[0]->reexam !== NULL ? $student_grade[0]->reexam : $grade;
			}else{
				$grade = 'NO GRADE SUBMITTED';
			}
			
			// Set the html value
			$html_data .= '
				<tr>
					<td>
						'.($i++).'
					</td>
					<td>
						'.($data->user_id == '' ? $data->reg_id : $data->reg_id).'
					</td>
					<td>
						<a>
						'.($data->user_id == '' ? '<span style="color: red;">MISSING PROFILE, PLEASE REPORT TO OAD TO FIX</span>' : $data->lname.', '.$data->fname.' '.$data->mname).'
						</a>
						<br/>
						<small>
							'.$data->email.'
						</small>
					</td>
					<td class="project-state">
					'.$grade.' <span class="badge badge-success"></span>
					</td>
					<td class="project-state">
					'.$reexam.' <span class="badge badge-success"></span>
					</td>
					<td class="project-state">
					'.$remarks.'
					<hr>
					<small>Submission Status: '.(count($student_grade) > 0 ? $student_grade[0]->status : '***').'</small>
					</td>';
					
					if (!in_array(count($student_grade) > 0 ? $student_grade[0]->status : '***', array('approved', 'dean', 'department head')) || (strtoupper($grade) == 'NG' || strtoupper($reexam) == 'NG' || strtoupper($grade) == 'IP' || strtoupper($reexam) == 'IP' || strtoupper($grade) == 'INC' || strtoupper($reexam) == 'INC')) {
						if (explode('_', $class_rec_id)[1] != 1){
							$html_data .= '<td class="project-actions text-center">
											<button class="btn btn-primary btn-lg btn-flat" onclick="update_grade(\''.$data->reg_id.'\', \''.$data->schedid.'\', \''. explode('_', $class_rec_id)[1].'\', \''.(count($student_grade) > 0 ? $student_grade[0]->grade_id : 0).'\', \''.(str_replace('\'','',$data->lname).', '.$data->fname.' '.$data->mname).'\', \''.(count($student_grade) > 0 ? $student_grade[0]->subject : "***").'\', \''.(count($student_grade) > 0 ? "update" : "insert").'\', \''.$grade_to_post.'\')">
												<i class="fas fa-edit">
												</i>
												UPDATE
											</button>
										</td>';
						}
					}else{
						
						$html_data .= '<td class="project-actions text-center">
										<button class="btn btn-primary btn-lg btn-flat disabled animate__animated animate__pulse animate__infinite" onclick="javascript:void(0)">
											UPDATE (not available)
										</button>
									</td>';
					}
				$html_data .= '</tr>';
		}

		echo json_encode($html_data);
	}

	public function get_student_grade_old(){
		$subject = $_POST['subject'];
		$sem = $_POST['sem'];
		$status = $_POST['status'];
		$e_id = $_SESSION['e_id'];
		$usr_arr = array();
		$non_email_user = $this->faculty->get_non_email_user($e_id);
		foreach ($non_email_user as $email) {
			array_push($usr_arr, $email->user_id);
		}
		$enrolled_data = $this->faculty->get_enrolled_student_old($subject, $sem, $usr_arr, $status);
		$html_data = '';
		$faculty = '';
		$i = 1;

		foreach ($enrolled_data as $data) {
			// Get student grades
			// $data = $this->faculty->get_data_old($data->user_id, $subject, $_POST['sem'], $usr_arr);
			$grade = '';
			$reexam = '';
			$remarks = '';
			// if (count($data) > 0) {
				if ($data->grades == '0.00') {
					$grade = 'NO GRADE SUBMITTED';
					$remarks = '<span class="badge badge-secondary">***</span>';
				}else{
					$grade = $data->grades;
					if (in_array($grade, array('NG', 'IP'))) {
						$remarks = '<span class="badge badge-secondary">'.$data->remarks.'</span>';
					}else{
						if (floatval($grade) <= 3.00) {
							$remarks = '<span class="badge badge-success">'.$data->remarks.'</span>';
						}else{
							if (floatval($grade) == 4.00) {
								$remarks = '<span class="badge badge-warning">'.$data->remarks.'</span>';
							}
							
							if (floatval($grade) == 5.00) {
								$remarks = '<span class="badge badge-danger">'.$data->remarks.'</span>';
							}
							
						}
					}
				}

				
				if ($data->reexam !== NULL) {
					if ($data->reexam == '0.00') {
						$reexam = 'NO GRADE SUBMITTED';
						$remarks = '<span class="badge badge-secondary">***</span>';
					}else{
						$reexam = $data->reexam;
						if (in_array($reexam, array('NG', 'IP'))) {
							$remarks = '<span class="badge badge-secondary">'.$data->remarks.'</span>';
						}else{
							if (floatval($reexam) <= 3.00) {
								$remarks = '<span class="badge badge-success">'.$data->remarks.'</span>';
							}else{
								if (floatval($reexam) == 4.00) {
									$remarks = '<span class="badge badge-warning">'.$data->remarks.'</span>';
								}
								
								if (floatval($reexam) == 5.00) {
									$remarks = '<span class="badge badge-danger">'.$data->remarks.'</span>';
								}
								
							}
						}
					}
				}
			// }

			$grade_to_post = $data->reexam !== NULL ? $data->reexam : $grade;
			// Set the html value
			$html_data .= '
				<tr>
					<td>
						'.($i++).'
					</td>
					<td>
						'.$data->user_id.'
					</td>
					<td>
						<a>
						'.($data->user_id == '' ? '<span style="color: red;">MISSING PROFILE, PLEASE REPORT TO OAD TO FIX</span>' : $data->lname.', '.$data->fname.' '.$data->mname).'
						</a>
						<br/>
						<small>
							'.$data->email.'
						</small>
					</td>
					<td class="project-state">
					'.$grade.' <span class="badge badge-success"></span>
					</td>
					<td class="project-state">
					'.$reexam.' <span class="badge badge-success"></span>
					</td>
					<td class="project-state">
					'.$remarks.'
					<hr>
					<small>Submission Status: '.$data->status.'</small>
					</td>
					';
					
					if (!in_array($data->status, array('approved', 'dean', 'department head')) || (strtoupper($grade) == 'NG' || strtoupper($reexam) == 'NG')) {
						if ($sem != 1)
						{
							$html_data .= '<td class="project-actions text-center">
										<button class="btn btn-primary btn-lg btn-flat" onclick="update_grade_old(\''.$data->user_id.'\', \''.$subject.'\', \''.$sem.'\', \''.$data->grade_id.'\', \''.($data->lname.', '.$data->fname.' '.$data->mname).'\', \''.$grade_to_post.'\', \''.$data->units.'\', \''.$data->day.'\', \''.$data->time.'\')">
											<i class="fas fa-edit">
											</i>
											UPDATE
										</button>
									</td>';
						}
					}else{
						$html_data .= '<td class="project-actions text-center">
										<button class="btn btn-primary btn-lg btn-flat disabled animate__animated animate__pulse animate__infinite" onclick="javascript:void(0)">
											UPDATE (not available)
										</button>
									</td>';
					}
			$html_data .='</tr>';
			$faculty = $data->faculty_id;
		}

		echo json_encode(array('data' => $html_data, 'faculty'	=>	$faculty));
	}

}

/* End of file Faculty.php */
/* Location: ./application/controllers/Faculty.php */