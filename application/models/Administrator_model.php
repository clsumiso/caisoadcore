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
		$this->db->where('semester_id > 2');
		// $this->db->where('semester_id <= 6');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	// Get DataTable data
   function getSchedule($postData=null){

		$response = array();

		## Read value
		$draw = $postData['draw'];
		$start = $postData['start'];
		$rowperpage = $postData['length']; // Rows display per page
		$columnIndex = $postData['order'][0]['column']; // Column index
		$columnName = $postData['columns'][$columnIndex + 2]['data']; // Column name
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
				"atl"				=>	$record->atl
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

   public function getOfficiallyEnroll($semester, $course = array())
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
			$query = $this->db->get();
		}

		return $query->result();
   }

}

/* End of file Administrator_model.php */
/* Location: ./application/models/Administrator_model.php */