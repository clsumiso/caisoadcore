<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

  // ------------------------------------------------------------------------

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->table = '';
  }

  // ------------------------------------------------------------------------

  public function getRole($userID = "")
  {
		$this->db->select("role");
		$this->db->from("tbl_role");
		$this->db->where("user_id", $userID);
		$query = $this->db->get();

		return $query->result();
  }

  // ------------------------------------------------------------------------
  public function getGraduateApplicants($postData=null, $role = "")
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
		// $searchSemester = $postData['semester'];
		// $searchCourse = $postData['course'];

		## Search 
		$search_arr = array();
		$searchQuery = "";

		if($searchValue != '')
		{
			$search_arr[] = " (oad0001.lname like '%".$searchValue."%' OR oad0001.fname like '%".$searchValue."%' OR oad0001.mname like'%".$searchValue."%' OR tbl_course.course_desc like'%".$searchValue."%' OR oad0001.degree_program_applied like'%".$searchValue."%') ";
		}

		// if($searchSemester != '')
		// {
		// 	$search_arr[] = " tbl_enrollment.semester_id='".$searchSemester."' AND tbl_profile.course_id='".$searchCourse."' ";
		// }

		if(count($search_arr) > 0)
		{
			$searchQuery = implode(" AND ",$search_arr);
		}
		
		$applicantDB = $this->load->database('applicantDB', TRUE);
		## Total number of records without filtering
		$applicantDB->select('count(*) as allcount');
		$applicantDB->join('tbl_course', 'oad0001.field_of_study = tbl_course.course_id', 'inner');
		$applicantDB->join('oad0003', 'oad0001.application_id = oad0003.application_id', 'inner');
		$applicantDB->where_in("oad0003.department_remarks", array("pending", "approved_regular", "approved_probationary"));
		$applicantDB->where("tbl_course.department_id", $role);
		$applicantDB->group_by(array('oad0003.application_id'));
		// $applicantDB->where('tbl_enrollment.semester_id', $searchSemester);
		if($searchQuery != '')
			$applicantDB->where($searchQuery);
		$records = $applicantDB->get('oad0001')->result();
		$totalRecords = count($records);

		## Total number of record with filtering
		$applicantDB->select('count(*) as allcount');
		$applicantDB->join('tbl_course', 'oad0001.field_of_study = tbl_course.course_id', 'inner');
		$applicantDB->join('oad0003', 'oad0001.application_id = oad0003.application_id', 'inner');
		$applicantDB->where_in("oad0003.department_remarks", array("pending", "approved_regular", "approved_probationary"));
		$applicantDB->where("tbl_course.department_id", $role);
		$applicantDB->group_by(array('oad0003.application_id'));
		if($searchQuery != '')
			$applicantDB->where($searchQuery);
		$records = $applicantDB->get('oad0001')->result();
		$totalRecordwithFilter = count($records);

		## Fetch records

		$applicantDB->select('oad0001.application_id, oad0001.lname, oad0001.fname, oad0001.mname, tbl_course.course_desc, oad0001.degree_program_applied, oad0001.date_created, oad0001.gwa_file, oad0001.img_file, oad0001.proficiency_file, oad0001.tor_file');
		$applicantDB->join('tbl_course', 'oad0001.field_of_study = tbl_course.course_id', 'inner');
		$applicantDB->join('oad0003', 'oad0001.application_id = oad0003.application_id', 'inner');
		$applicantDB->where_in("oad0003.department_remarks", array("pending", "approved_regular", "approved_probationary"));
		$applicantDB->where("tbl_course.department_id", $role);
		$applicantDB->group_by(array('oad0003.application_id'));

		if($searchQuery != '')
			$applicantDB->where($searchQuery);

		$applicantDB->order_by($columnName, $columnSortOrder);
		$applicantDB->limit($rowperpage, $start);
		$records = $applicantDB->get('oad0001')->result();

		$data = array();
		$ctr = 1;

		foreach($records as $record)
		{
			$referenceHtml = "";
			$actionBtn = "";
			/**
			 * Get reference
			 */
				foreach ($this->getReference($record->application_id) as $reference) 
				{
					$referenceHtml .= '<ul>';
						$referenceHtml .= '<li>'.$reference->reference_email.'</li>';
						$referenceHtml .= '<li>'.date("F d, Y H:i:s", strtotime($reference->reference_status)).' ('.$reference->reference_remarks.')</li>';
					$referenceHtml .= '</ul><hr>';
				}
			/**
			 * End of get reference
			 */

			switch (strtoupper($record->degree_program_applied)) 
			{
				case 'PHD':
					if (in_array($this->getApprovalStatus($record->application_id)[0]->department_remarks, array("approved_regular", "approved_probationary")))
					{
						$actionBtn = count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-amber btn-block waves-effect disabled" style="margin-top: 5px;">ENDORSED - REGULAR</button>' : '';	

						$actionBtn .= count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-amber btn-block waves-effect disabled" style="margin-top: 5px;">ENDORSED - PROBATIONARY</button>' : '';	

						$actionBtn .= count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-amber btn-block waves-effect disabled" style="margin-top: 5px;">ADVISED TO WITHDRAW</button>' : '';	

						$actionBtn .= count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-red btn-block waves-effect disabled" style="margin-top: 5px;">RETURN TO OAD</button>' : '';	
					}else
					{
						$actionBtn = count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="endorsedToDean(\''.$record->application_id.'\')">ENDORSED - REGULAR</button>' : '';

						$actionBtn .= count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="endorsedToDeanProbationary(\''.$record->application_id.'\')">ENDORSED - PROBATIONARY</button>' : '';

						$actionBtn .= count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="adiviseWithdraw(\''.$record->application_id.'\')">ADVISED TO WITHDRAW</button>' : '';

						$actionBtn .= count($this->getReference($record->application_id)) == 3 ? '<button class="btn btn-sm bg-red btn-block waves-effect" style="margin-top: 5px;" onclick="returnApplication(\''.$record->application_id.'\')">RETURN TO OAD</button>' : '';
					}
					
					break;
				case 'MASTER':
					if (in_array($this->getApprovalStatus($record->application_id)[0]->department_remarks, array("approved_regular", "approved_probationary")))
					{
						$actionBtn = count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-amber btn-block waves-effect disabled" style="margin-top: 5px;">ENDORSED - REGULAR</button>' : '';	

						$actionBtn .= count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-amber btn-block waves-effect disabled" style="margin-top: 5px;">ENDORSED - PROBATIONARY</button>' : '';	

						$actionBtn .= count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-amber btn-block waves-effect disabled" style="margin-top: 5px;">ADVISED TO WITHDRAW</button>' : '';	

						$actionBtn .= count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-red btn-block waves-effect disabled" style="margin-top: 5px;">RETURN TO OAD</button>' : '';
					}else
					{
						$actionBtn = count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="endorsedToDean(\''.$record->application_id.'\')">ENDORSED - REGULAR</button>' : '';

						$actionBtn .= count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="endorsedToDeanProbationary(\''.$record->application_id.'\')">ENDORSED - PROBATIONARY</button>' : '';
						
						$actionBtn .= count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="adiviseWithdraw(\''.$record->application_id.'\')">ADVISED TO WITHDRAW</button>' : '';

						$actionBtn .= count($this->getReference($record->application_id)) == 2 ? '<button class="btn btn-sm bg-red btn-block waves-effect" style="margin-top: 5px;" onclick="returnApplication(\''.$record->application_id.'\')">RETURN TO OAD</button>' : '';	
					}
					break;
			}

			$referenceForm = $this->getReferenceAnswer($record->application_id);
			$referenceCtr = 1;
			$referenceBTN = '';
			foreach ($referenceForm as $refForm) 
			{
				$referenceBTN .= '<button type="button" class="btn btn-sm bg-blue-grey btn-block waves-effect" style="margin-top: 5px;" onclick="viewReferenceForm(\''.$refForm->reference_id.'\')">Reference '.($referenceCtr++).'</button>';
			}

			$data[] = array( 
				"numRows"				=>	($ctr++),
				"action"				=>	$actionBtn,
				"requirements"			=>	'
				
				'.$referenceBTN.'

				<button type="button" class="btn btn-sm bg-teal btn-block waves-effect" style="margin-top: 5px;" onclick="viewApplicationForm(\''.$record->application_id.'\')">Application Form</button>

				<button type="button" class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;" onclick="viewRequirements(\''.$this->getFileInfo($record->gwa_file, "GWA")['link'].'\')">GWA</button>

				<button type="button" class="btn btn-sm bg-orange btn-block waves-effect" style="margin-top: 5px;" onclick="viewRequirements(\''.$this->getFileInfo($record->proficiency_file, "PROFICIENCY")['link'].'\')">PROFICIENCY</button>

				<button type="button" class="btn btn-sm bg-teal btn-block waves-effect" style="margin-top: 5px;" onclick="viewRequirements(\''.$this->getFileInfo($record->tor_file, "TOR")['link'].'\')">TOR</button>
				
				',
				"fname"					=>	$record->fname,
				"mname"					=>	$record->mname,
				"lname"					=>	$record->lname,
				"degree_programm"		=>	$record->course_desc,
				"level_applied"			=>	$record->degree_program_applied,
				"date_applied"			=>	date("F d, Y H:i:s", strtotime($record->date_created)),
				"department"			=>	count($this->getApprovalStatus($record->application_id)) > 0 ? $this->getApprovalStatus($record->application_id)[0]->department_remarks : "****",
				"dean"			=>	count($this->getApprovalStatus($record->application_id)) > 0 ? $this->getApprovalStatus($record->application_id)[0]->dean_note : "****"
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

  // ------------------------------------------------------------------------
  /**
	 * Other functions
	 */
	public function getReference($applicationID = "")
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select("reference_email, reference_status, reference_remarks");
		$applicantDB->from("oad0003");
		$applicantDB->where("application_id", $applicationID);
		$query = $applicantDB->get();

		return $query->result();
	}

  public function getReferenceAnswer($applicationID = "")
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select("reference_id");
		$applicantDB->from("oad0002");
		$applicantDB->where("applicant_id", $applicationID);
		$query = $applicantDB->get();

		return $query->result();
	}

 	public function getFileInfo($filename = "", $directory = "")
	{
		if ($filename == "")
		{
			return array("link"	=>	"", "target"	=>	"_TOP");
		}else
		{
			switch ($directory) 
			{
				case 'GWA':
					return array("link"	=>	"/office-of-admissions/uploads/graduate_level_requirements/GWA/".$filename, "target"	=>	"_BLANK");
					break;
				
				case 'IMG':
					return array("link"	=>	"/office-of-admissions/uploads/graduate_level_requirements/IMG/".$filename, "target"	=>	"_BLANK");
					break;
			
				case 'PROFICIENCY':
					return array("link"	=>	"/office-of-admissions/uploads/graduate_level_requirements/PROFICIENCY/".$filename, "target"	=>	"_BLANK");
					break;
		
				case 'TOR':
					return array("link"	=>	"/office-of-admissions/uploads/graduate_level_requirements/TOR/".$filename, "target"	=>	"_BLANK");
					break;
				
				default:
					# code...
					break;
			}
		}
	}

  	public function getApprovalStatus($applicationID = "")
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select("*");
		$applicantDB->from("oad0003");
		$applicantDB->where("application_id", $applicationID);
		$applicantDB->group_by("application_id", array("application_id"));
		$query = $applicantDB->get();

		return $query->result();
	}

	public function check_user_info($user_id)
    {
        $this->db->select("dept_id");
        $this->db->from('tbl_profile');
		$this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_subject($semester, $department_id)
    {
        $this->db->select("tbl_class_schedule.*");
        $this->db->from('tbl_class_schedule');
		$this->db->where('department_id', $department_id);
		$this->db->where('semester_id', $semester);
		$this->db->where_in('class_type', array(1, 4, 5));
        $query = $this->db->get();
        return $query->result();
    }

    public function get_teaching_loads($department_id, $schedid)
    {
        $this->db->select("tbl_profile.user_id, tbl_profile.lname, tbl_profile.fname, tbl_teaching_loads.schedid");
        $this->db->from('tbl_teaching_loads');
        $this->db->join('tbl_profile', 'tbl_teaching_loads.user_id = tbl_profile.user_id', 'inner');
        $this->db->join('tbl_class_schedule', 'tbl_teaching_loads.schedid = tbl_class_schedule.schedid', 'inner');
        $this->db->where('tbl_class_schedule.department_id', $department_id);
        $this->db->where('tbl_teaching_loads.schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_rog_status($students = array(), $sem = 0, $faculty_id = "", $subject = "")
    {
        $this->db->select("status");
        $this->db->from('tbl_grades');
        $this->db->where_in('user_id', $students);
        $this->db->where_in('status', array('pending', 'faculty', 'department head', 'dean', 'approved'));
        $this->db->where('faculty_id', $faculty_id);
        $this->db->where('semester_id', $sem);
        $this->db->where('subject', $subject);
        $query = $this->db->get();
        return $query->result();
    }
}

/* End of file Department_model.php */
/* Location: ./application/models/Department_model.php */
