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
		}else if ($_POST['semid'] >= 6)
		{

		}else
		{
			$subject_filter_data = $this->faculty->get_subjects_old_grades($_POST['semid'], $_SESSION['e_id']);
			$htmlContent = '<option value="#">-- SELECT SUBJECT --</option>';

			foreach ($subject_filter_data as $subject_filter) 
			{
				$htmlContent .= '<option value="'.$subject_filter->subject.'">'.$subject_filter->subject.'</option>';
			}
		}

		echo json_encode(array(
			'content'	=>	$htmlContent
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
		}else if ($_POST['semid'] >= 6)
		{
			
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

}

/* End of file Faculty.php */
/* Location: ./application/controllers/Faculty.php */