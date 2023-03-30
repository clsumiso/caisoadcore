<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administrator_model extends CI_Model {

	public $table;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSemester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		$this->db->where('semester_id > 3');
		// $this->db->where('semester_id <= 6');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function getCollege()
	{
		$this->db->select('college_id, college_name');
        $this->db->from('tbl_college');
		$this->db->where('college_id < 11');
        $query = $this->db->get();

		return $query->result();
	}

	public function getCourse($college)
	{
		$this->db->select('course_id, course_name, course_desc');
        $this->db->from('tbl_course');
		$this->db->where('college_id', $college);
		$this->db->where_in('course_type', array('BS', 'B', 'C', 'D', 'MS', 'PhD'));
		$this->db->order_by('course_name', 'asc');
        $query = $this->db->get();

		return $query->result();
	}

	// Get DataTable data
   	function getSchedule($postData=null)
	{

		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		if (!in_array($columnIndex, array(0,1)))
		{
			$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		}else
		{
			$columnName = "";
		}
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		// Custom search filter 
		$searchSemester = $postData['semester'];

		## Search 
		$search_arr = array();
		$searchQuery = "";

		if($searchValue != '')
		{
			$search_arr[] = " (tbl_class_schedule.schedid like '%".$searchValue."%' OR tbl_class_schedule.cat_no like '%".$searchValue."%' OR tbl_class_schedule.subject_title like'%".$searchValue."%' ) ";
		}

		if($searchSemester != '')
		{
			$search_arr[] = " tbl_class_schedule.semester_id='".$searchSemester."' ";
		}

		// if($searchGender != '')
		// {
		// 	$search_arr[] = " gender='".$searchGender."' ";
		// }

		// if($searchName != '')
		// {
		// 	$search_arr[] = " name like '%".$searchName."%' ";
		// }

		if(count($search_arr) > 0)
		{
			$searchQuery = implode(" AND ",$search_arr);
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('semester_id', $searchSemester);
		$records = $this->db->get('tbl_class_schedule')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if($searchQuery != '')
		$this->db->where($searchQuery);
		$records = $this->db->get('tbl_class_schedule')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('tbl_class_schedule.schedid, tbl_semester.semester_name, tbl_semester.semester_year, tbl_class_schedule.cat_no, tbl_class_schedule.subject_title, tbl_class_schedule.units, tbl_class_schedule.day, tbl_class_schedule.time, tbl_class_schedule.room, tbl_class_schedule.section, tbl_class_schedule.atl');
		$this->db->join('tbl_semester', 'tbl_class_schedule.semester_id = tbl_semester.semester_id', 'inner');

		if($searchQuery != '')
			$this->db->where($searchQuery);

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('tbl_class_schedule')->result();

		$data = array();
		$ctr = 1;
		foreach($records as $record)
		{
			$data[] = array( 
				"numRows"			=>	($ctr++),
				"action"			=>	'<button class="btn btn-lg btn-flat btn-warning waves-effect" onclick="updateSchedule(\''.$record->schedid.'\', \''.$searchSemester.'\')">EDIT</button>',
				"schedid"			=>	$record->schedid,
				"semester_name"		=>	$record->semester_name." ".$record->semester_year,
				"cat_no"			=>	$record->cat_no,
				"subject_title"		=>	$record->subject_title,
				"units"				=>	$record->units,
				"day"				=>	$record->day,
				"time"				=>	$record->time,
				"room"				=>	$record->room,
				"section"			=>	$record->section,
				"atl"				=>	$record->atl,
				"total_enrolled"	=>	$this->getTotal('tbl_registration', $searchSemester, ($searchSemester == 3 ? 2 : "approved"))
			); 
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response; 
	}

   	function getClassMonitoring($postData=null)
	{

		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		if (!in_array($columnIndex, array(0,11)))
		{
			$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		}else
		{
			$columnName = "";
		}
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		// Custom search filter 
		$searchSemester = $postData['semester'];

		## Search 
		$search_arr = array();
		$searchQuery = "";

		if($searchValue != '')
		{
			$search_arr[] = " (tbl_class_schedule.schedid like '%".$searchValue."%' OR tbl_class_schedule.cat_no like '%".$searchValue."%' OR tbl_class_schedule.subject_title like'%".$searchValue."%' ) ";
		}

		if($searchSemester != '')
		{
			$search_arr[] = " tbl_class_schedule.semester_id='".$searchSemester."' ";
		}

		// if($searchGender != '')
		// {
		// 	$search_arr[] = " gender='".$searchGender."' ";
		// }

		// if($searchName != '')
		// {
		// 	$search_arr[] = " name like '%".$searchName."%' ";
		// }

		if(count($search_arr) > 0)
		{
			$searchQuery = implode(" AND ",$search_arr);
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->where('semester_id', $searchSemester);
		$records = $this->db->get('tbl_class_schedule')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		if($searchQuery != '')
		$this->db->where($searchQuery);
		$records = $this->db->get('tbl_class_schedule')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records
		$this->db->select('tbl_class_schedule.schedid, tbl_semester.semester_name, tbl_semester.semester_year, tbl_class_schedule.cat_no, tbl_class_schedule.subject_title, tbl_class_schedule.units, tbl_class_schedule.day, tbl_class_schedule.time, tbl_class_schedule.room, tbl_class_schedule.section, tbl_class_schedule.atl');
		$this->db->join('tbl_semester', 'tbl_class_schedule.semester_id = tbl_semester.semester_id', 'inner');

		if($searchQuery != '')
			$this->db->where($searchQuery);

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('tbl_class_schedule')->result();

		$data = array();
		$ctr = 1;
		foreach($records as $record)
		{
			$data[] = array( 
				"numRows"			=>	($ctr++),
				// "action"			=>	'<button class="btn btn-lg btn-flat btn-warning waves-effect" onclick="updateSchedule(\''.$record->schedid.'\', \''.$searchSemester.'\')">EDIT</button>',
				"schedid"			=>	$record->schedid,
				"semester_name"		=>	$record->semester_name." ".$record->semester_year,
				"cat_no"			=>	$record->cat_no,
				"subject_title"		=>	$record->subject_title,
				"units"				=>	$record->units,
				"day"				=>	$record->day,
				"time"				=>	$record->time,
				"room"				=>	$record->room,
				"section"			=>	$record->section,
				"atl"				=>	$record->atl,
				"total_enrolled"	=>	$this->getTotal('tbl_registration', $searchSemester, ($searchSemester == 3 ? 2 : "approved"), $record->schedid)
			); 
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response; 
   	}

	public function getAccounting($postData=null)
	{
		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		if (!in_array($columnIndex, array(0,1)))
		{
			$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		}else
		{
			$columnName = "";
		}
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		// Custom search filter 
		$searchSemester = $postData['semester'];

		## Search 
		$search_arr = array();
		$searchQuery = "";

		if($searchValue != '')
		{
			$search_arr[] = " (tbl_enrollment.user_id like '%".$searchValue."%' OR tbl_profile.fname like '%".$searchValue."%' OR tbl_profile.mname like'%".$searchValue."%' OR tbl_profile.lname like'%".$searchValue."%' ) ";
		}

		if($searchSemester != '')
		{
			$search_arr[] = " tbl_enrollment.semester_id='".$searchSemester."' ";
		}

		if(count($search_arr) > 0)
		{
			$searchQuery = implode(" AND ",$search_arr);
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');
		$this->db->where('tbl_enrollment.semester_id', $searchSemester);
		$records = $this->db->get('tbl_enrollment')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');
		if($searchQuery != '')
		$this->db->where($searchQuery);
		$records = $this->db->get('tbl_enrollment')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records

		$this->db->select('tbl_enrollment.user_id, tbl_semester.semester_name, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name, tbl_enrollment.section, tbl_semester.semester_id, tbl_semester.semester_year');

		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');

		if($searchQuery != '')
			$this->db->where($searchQuery);

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('tbl_enrollment')->result();

		$data = array();
		$ctr = 1;
		foreach($records as $record)
		{
			$data[] = array( 
				"numRows"			=>	($ctr++),
				"action"			=>	'<button class="btn btn-sm btn-flat btn-primary waves-effect" onclick="assessPayment(\''.$record->user_id.'\', \''.$record->semester_id.'\')"><i class="material-icons">account_box</i>Assess Fees</button>',
				"user_id"			=>	$record->user_id,
				"semester_name"		=>	$record->semester_name." ".$record->semester_year,
				"fname"				=>	$record->fname,
				"mname"				=>	$record->mname,
				"lname"				=>	$record->lname,
				"course_name"		=>	$record->course_name,
				"section"			=>	$record->section,
				"trasaction_id"		=>	$this->getOR($record->user_id, $searchSemester),
				"amount"			=>	$this->getAmountPaid($record->user_id, $record->semester_id)
			); 
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response; 
	}

	public function getGrades($postData=null)
	{
		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		if (!in_array($columnIndex, array(0,1,9)))
		{
			$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		}else
		{
			$columnName = "";
		}
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		// Custom search filter 
		$searchSemester = $postData['semester'];
		$searchCourse = $postData['course'];

		## Search 
		$search_arr = array();
		$searchQuery = "";

		if($searchValue != '')
		{
			$search_arr[] = " (tbl_enrollment.user_id like '%".$searchValue."%' OR tbl_profile.fname like '%".$searchValue."%' OR tbl_profile.mname like'%".$searchValue."%' OR tbl_profile.lname like'%".$searchValue."%' ) ";
		}

		if($searchSemester != '')
		{
			$search_arr[] = " tbl_enrollment.semester_id='".$searchSemester."' AND tbl_profile.course_id='".$searchCourse."' ";
		}

		if(count($search_arr) > 0)
		{
			$searchQuery = implode(" AND ",$search_arr);
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');
		// $this->db->where('tbl_enrollment.semester_id', $searchSemester);
		if($searchQuery != '')
			$this->db->where($searchQuery);
		$records = $this->db->get('tbl_enrollment')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');
		if($searchQuery != '')
			$this->db->where($searchQuery);
		$records = $this->db->get('tbl_enrollment')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records

		$this->db->select('tbl_enrollment.user_id, tbl_semester.semester_name, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name, tbl_enrollment.section, tbl_semester.semester_id, tbl_semester.semester_year');

		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');

		if($searchQuery != '')
			$this->db->where($searchQuery);

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('tbl_enrollment')->result();

		$data = array();
		$ctr = 1;
		foreach($records as $record)
		{
			$data[] = array( 
				"numRows"			=>	($ctr++),
				"action"			=>	'<button type="button" class="btn bg-green waves-effect" onclick="gradeDetails(\''.$record->user_id.'\', \''.$record->semester_id.'\')">
											<i class="material-icons">assignment</i> view grades
										</button>',
				"user_id"			=>	$record->user_id,
				"semester_name"		=>	$record->semester_name." ".$record->semester_year,
				"fname"				=>	$record->fname,
				"mname"				=>	$record->mname,
				"lname"				=>	$record->lname,
				"course_name"		=>	$record->course_name,
				"section"			=>	$record->section
			); 
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response; 
	}

	public function getApplicants($postData=null)
	{
		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		if (!in_array($columnIndex, array(0,1,9)))
		{
			$columnName = $postData['columns'][$columnIndex]['data']; // Column name
		}else
		{
			$columnName = "";
		}
		$columnSortOrder = $postData['order'][0]['dir']; // asc or desc
		$searchValue = $postData['search']['value']; // Search value

		// Custom search filter 
		$searchSemester = $postData['semester'];
		$searchCourse = $postData['course'];

		## Search 
		$search_arr = array();
		$searchQuery = "";

		if($searchValue != '')
		{
			$search_arr[] = " (tbl_enrollment.user_id like '%".$searchValue."%' OR tbl_profile.fname like '%".$searchValue."%' OR tbl_profile.mname like'%".$searchValue."%' OR tbl_profile.lname like'%".$searchValue."%' ) ";
		}

		if($searchSemester != '')
		{
			$search_arr[] = " tbl_enrollment.semester_id='".$searchSemester."' AND tbl_profile.course_id='".$searchCourse."' ";
		}

		if(count($search_arr) > 0)
		{
			$searchQuery = implode(" AND ",$search_arr);
		}

		## Total number of records without filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');
		// $this->db->where('tbl_enrollment.semester_id', $searchSemester);
		if($searchQuery != '')
			$this->db->where($searchQuery);
		$records = $this->db->get('tbl_enrollment')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$this->db->select('count(*) as allcount');
		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');
		if($searchQuery != '')
			$this->db->where($searchQuery);
		$records = $this->db->get('tbl_enrollment')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records

		$this->db->select('tbl_profile');

		$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_enrollment.semester_id = tbl_semester.semester_id', 'inner');

		if($searchQuery != '')
			$this->db->where($searchQuery);

		$this->db->order_by($columnName, $columnSortOrder);
		$this->db->limit($rowperpage, $start);
		$records = $this->db->get('tbl_enrollment')->result();

		$data = array();
		$ctr = 1;
		foreach($records as $record)
		{
			$data[] = array( 
				"numRows"			=>	($ctr++),
				"action"			=>	'<button type="button" class="btn bg-green waves-effect" onclick="gradeDetails(\''.$record->user_id.'\', \''.$record->semester_id.'\')">
											<i class="material-icons">assignment</i> view grades
										</button>',
				"user_id"			=>	$record->user_id,
				"semester_name"		=>	$record->semester_name." ".$record->semester_year,
				"fname"				=>	$record->fname,
				"mname"				=>	$record->mname,
				"lname"				=>	$record->lname,
				"course_name"		=>	$record->course_name,
				"section"			=>	$record->section
			); 
		}

		## Response
		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);

		return $response; 
	}
	// End of DataTable data

	public function getTotal($tableName, $semester, $status, $schedid = "")
	{
		$statusCheck = ($semester == 3 ? 'status' : "ra_status");

		$this->db->select('user_id, status, ra_status');
        $this->db->from($tableName);
		$this->db->where('semester_id', $semester);
		$this->db->where('schedid', $schedid);
		$this->db->where($statusCheck, $status);
        $query = $this->db->get();

		return $query->num_rows();
	}

	/** 
	 * Accounting Get Data Functions
	 * 
	*/
	public function getAmountPaid($user_id = null, $semester = 0)
	{
		$this->db->select('amount');
		$this->db->where('user_id', $user_id);
		$this->db->where('semester_id', $semester);
		$records = $this->db->get('tbl_payment')->result();

		$total = 0;

		foreach ($records as $record) 
		{
			$total += $record->amount;
		}

		return $total;
	}

	public function getOR($user_id = null, $semester = 0)
	{
		$this->db->select('payment_id, transaction_id, amount');
		$this->db->where('user_id', $user_id);
		$this->db->where('semester_id', $semester);
		$records = $this->db->get('tbl_payment')->result();

		$htmlData = '';

		foreach ($records as $record) 
		{
			$htmlData .= '<a class="col-teal font-bold" href="javascript:void(0)" onclick="updateOR(\''.$record->payment_id.'\', \''.$record->transaction_id.'\', \''.$user_id.'\', \''.$semester.'\', \''.$record->amount.'\')">'.$record->transaction_id.'</a> |';
		}

		return $htmlData;
	}
	/**
	 * End of Accounting Get Data Functions
	 */

	
	/**
	 * Data analytics Functions
	 */
   	public function getEnrollPerCollege($semester, $course = array())
   	{
		if($semester == 3)
        {
            $this->db->select('tbl_registration.user_id, tbl_profile.course_id, tbl_college.college_id, tbl_college.college_name');
			$this->db->from('tbl_registration');
			$this->db->join('tbl_profile', 'tbl_registration.user_id = tbl_profile.user_id', 'left');
			$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
			$this->db->join('tbl_college', 'tbl_course.college_id = tbl_college.college_id', 'inner');
			$this->db->where('tbl_registration.semester_id', $semester);
			$this->db->where('tbl_registration.status', 2);
			if (count($course) > 0) 
			{
				$this->db->where_in('tbl_profile.course_id', $course);
			}
			$this->db->group_by('tbl_registration.user_id', array('tbl_registration.user_id'));
			$query = $this->db->get();
        }else
		{
			$this->db->select('tbl_enrollment.user_id, tbl_profile.course_id, tbl_college.college_id, tbl_college.college_name');
			$this->db->from('tbl_enrollment');
			$this->db->join('tbl_profile', 'tbl_enrollment.user_id = tbl_profile.user_id', 'left');
			$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
			$this->db->join('tbl_college', 'tbl_course.college_id = tbl_college.college_id', 'inner');
			$this->db->where('tbl_enrollment.semester_id', $semester);
			if (count($course) > 0) 
			{
				$this->db->where_in('tbl_profile.course_id', $course);
			}
			$query = $this->db->get();
		}

		return $query->result();
   	}
	/**
     * End of Data Analytics Functions
     */

	public function getTestDatabase2()
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select('*');
		$applicantDB->from('tbl_profile');
		$query = $applicantDB->get();

		return $query->result();
	}

	/**
	* Grades Module Functions
	*/

	public function getStudentGrade($userID = "", $semesterID = 0, $cat_no = "")
	{
		$this->db->select('tbl_registration.user_id, tbl_registration.schedid, tbl_class_schedule.cat_no, tbl_grades.faculty_id, tbl_grades.grades, tbl_grades.reexam, tbl_grades.status');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->join('tbl_grades', 'tbl_class_schedule.cat_no = tbl_grades.subject', 'inner');
		$this->db->where('tbl_registration.user_id', $userID);
		$this->db->where('tbl_grades.user_id', $userID);
		$this->db->where('tbl_registration.semester_id', $semesterID);
		$this->db->order_by('tbl_registration.schedid', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	/**
    * End of Grades Module Functions
    */

	/**
	 * LOGS metadata
	 */
	public function getGradesOldData($condition = array())
	{
		$this->db->select("subject, grades, reexam");
		$this->db->from("tbl_grades");
		$this->db->where("subject", $condition['subject']);
		$this->db->where("semester_id", $condition['semester']);
		$this->db->where("user_id", $condition['user_id']);
		$query = $this->db->get();

		return $query->result();
	}
	/**
	 * END of logs metadata
	 */
	/**
	 * CRUD
	 */
	public function save($table, $data = array())
	{
		$this->db->trans_begin();
        $this->db->trans_strict(TRUE);

        $this->db->insert($table, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
	}

	public function update($data = array(), $con = array(), $table = array())
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->update($table[0], $data, $con);
            if ($this->db->trans_status() === FALSE) 
            {
		        $this->db->trans_rollback();
		        return false;
		    } else 
		    {
		        $this->db->trans_commit();
		        return true;
		    }
        }
        return false;
	}
	/**
	 * END OF CRUD
	 */
}

/* End of file Administrator_model.php */
/* Location: ./application/models/Administrator_model.php */