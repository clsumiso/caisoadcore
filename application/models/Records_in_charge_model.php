<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Records_in_charge_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_semester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_evaluation($course_id, $semester_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name');
		$this->db->from('tbl_profile');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->join('tbl_users', 'tbl_profile.user_id = tbl_users.user_id', 'inner');
		$this->db->where('tbl_profile.course_id', $course_id);
		$this->db->where('tbl_users.user_type', 'student');
		$this->db->group_by(array('tbl_profile.user_id'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_evaluation($user_id, $semester_id)
	{
		$this->db->select('tbl_evaluation.evaluation_id, tbl_evaluation.section, tbl_evaluation.date_admitted, tbl_evaluation.no_stay, tbl_evaluation.entrance_credential, tbl_evaluation.inc_cond_grades, tbl_evaluation.lapse, tbl_evaluation.no_grades, tbl_evaluation.force_drop, tbl_evaluation.behind_subjects, tbl_evaluation.other_concern, tbl_evaluation.ins_from_ric, tbl_evaluation.max_units_allowed');
		$this->db->from('tbl_evaluation');
		$this->db->where('tbl_evaluation.semester_id', $semester_id);
		$this->db->where('tbl_evaluation.studid', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_force_drop($user_id, $semester_id)
	{
		$this->db->select('tbl_class_schedule.cat_no, tbl_registration.registration_id');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$this->db->where('tbl_registration.user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_registration($user_id, $semester_id)
	{
		$this->db->select('tbl_registration.schedid, tbl_class_schedule.cat_no, tbl_class_schedule.units, tbl_class_schedule.time, tbl_class_schedule.day, tbl_class_schedule.room, tbl_class_schedule.section, tbl_class_schedule.weight, tbl_registration.force_drop');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$this->db->where('tbl_registration.user_id', $user_id);
		if ($semester_id == 3) 
		{
			$this->db->where('tbl_registration.status', 2);
		}else
		{
			$this->db->where('tbl_registration.ra_status', "approved");
		}
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_registration_per_sem($course_id, $semester_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_course.course_name, tbl_evaluation.evaluation_id, tbl_evaluation.section, tbl_evaluation.date_admitted, tbl_evaluation.no_stay, tbl_evaluation.entrance_credential, tbl_evaluation.inc_cond_grades, tbl_evaluation.lapse, tbl_evaluation.no_grades, tbl_evaluation.force_drop, tbl_evaluation.behind_subjects, tbl_evaluation.other_concern, tbl_evaluation.ins_from_ric, tbl_evaluation.max_units_allowed');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_evaluation', 'tbl_registration.user_id = tbl_evaluation.studid', 'left');
		$this->db->join('tbl_profile', 'tbl_registration.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->where('tbl_evaluation.semester_id', $semester_id);
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$this->db->where('tbl_profile.course_id', $course_id);
		$this->db->group_by(array('tbl_registration.user_id'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_role($user_id)
	{
		$this->db->select('role');
		$this->db->from('tbl_role');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_course($course_id = array())
	{
		$this->db->select('*');
		$this->db->from('tbl_course');
		$this->db->where_in('course_id', $course_id);
		$this->db->order_by('course_desc', 'asc');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_course_info($course_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_course');
		$this->db->where('course_id', $course_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_class_schedule_section($course_id, $semester_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_class_schedule');
		$this->db->where('semester_id', $semester_id);
		$this->db->where('course_id', $course_id);
		$this->db->group_by(array("section")); 
		$query = $this->db->get();

		return $query->result();
	}

	public function get_enrollment($user_id, $semester_id)
	{
		$this->db->select('section');
		$this->db->from('tbl_enrollment');
		$this->db->where('user_id', $user_id);
		$this->db->where('semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_profile($user_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_profile');
		$this->db->where('user_id', $user_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_student_major($course_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_major');
		$this->db->where('course_id', $course_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function getActiveSemester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		$this->db->where('semester_status', 1);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_students($course_id, $year_level, $semester_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_profile.mname, tbl_profile.student_type, tbl_course.course_name, tbl_enrollment.section');
		$this->db->from('tbl_profile');
		$this->db->join('tbl_enrollment', 'tbl_profile.user_id = tbl_enrollment.user_id', 'left');
		$this->db->join('tbl_course', 'tbl_profile.course_id = tbl_course.course_id', 'inner');
		$this->db->where('tbl_profile.course_id', $course_id);
		$this->db->where('tbl_profile.year_level', $year_level);
		$this->db->where('tbl_enrollment.semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	/**
	 * LOGS metadata
	 */
	public function getGradesOldData($condition = array())
	{
		$this->db->select("subject, grades, reexam");
		$this->db->from("tbl_grades");
		$this->db->where("subject", $condition['subject']);
		$this->db->where("semester_id", $condition['semester_id']);
		$this->db->where("user_id", $condition['user_id']);
		$query = $this->db->get();

		return $query->result();
	}
	/**
	 * END of logs metadata
	 */

	/**
	* Grades Module Functions
	*/

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

	public function getStudentGrade($userID = "", $semesterID = 0, $cat_no = "")
	{
		$this->db->select('tbl_registration.user_id, tbl_registration.schedid, tbl_class_schedule.cat_no, tbl_teaching_loads.user_id as teaching_faculty_id');
		$this->db->from('tbl_registration');
		$this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->join('tbl_teaching_loads', 'tbl_class_schedule.schedid = tbl_teaching_loads.schedid', 'inner');
		$this->db->where('tbl_registration.user_id', $userID);
		$this->db->where('tbl_registration.semester_id', $semesterID);
		$this->db->where('tbl_class_schedule.semester_id', $semesterID);
		$this->db->where('tbl_class_schedule.class_type !=', 2);
		$this->db->order_by('tbl_registration.schedid', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function checkGrades($user_id = "", $cat_no = "", $semesterID = "", $faculty_id = "")
	{
		$this->db->select('*');
		$this->db->from('tbl_grades');
		$this->db->where('user_id', $user_id);
		$this->db->where('subject', $cat_no);
		$this->db->where('semester_id', $semesterID);
		$query = $this->db->get();

		return $query->result();
	}

	public function getDropping($user_id = "", $schedid = "", $semester = "")
	{
		$this->db->select('schedid');
		$this->db->from('tbl_dropping');
		$this->db->where('studid', $user_id);
		$this->db->where('schedid', $schedid);
		$this->db->where('semester_id', $semester);
		$query = $this->db->get();

		return $query->result();
	}
	/**
	* End Grades Module Functions
	*/

	public function save($data = array(), $con = array(), $profileData = array(), $table = array(), $profileDataCon = array())
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->insert($table[0], $data);
    		$this->db->update($table[1], $profileData, $profileDataCon);
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

	public function update($data = array(), $con = array(), $profileData = array(), $table = array(), $profileDataCon = array())
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->update($table[0], $data, $con);
    		$this->db->update($table[1], $profileData, $profileDataCon);
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

	public function update_single_table($data = array(), $con = array(), $table)
	{
		if(!empty($data)){
			$this->db->trans_begin();
	    	$this->db->trans_strict(TRUE);

            // Insert member data
           	$this->db->update($table, $data, $con);
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

	public function delete($table, $condition = array())
	{
		$this->db->trans_begin();
	    $this->db->trans_strict(TRUE);
        $this->db->delete($table, $condition);

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

}

/* End of file Records_in_charge_model.php */
/* Location: ./application/models/Records_in_charge_model.php */