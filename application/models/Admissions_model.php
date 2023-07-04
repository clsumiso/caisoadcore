<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Model Admissions_model
 *
 * This Model for ...
 * 
 * @package		CodeIgniter
 * @category	Model
 * @author    Setiawan Jodi <jodisetiawan@fisip-untirta.ac.id>
 * @link      https://github.com/setdjod/myci-extension/
 * @param     ...
 * @return    ...
 *
 */

class Admissions_model extends CI_Model {

  	// ------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getApplicants($postData=null)
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
			$search_arr[] = " (tbl_profile.applicant_id like '%".$searchValue."%' OR tbl_profile.fname like '%".$searchValue."%' OR tbl_profile.mname like'%".$searchValue."%' OR tbl_profile.lname like'%".$searchValue."%' OR tbl_letterType.name like'%".$searchValue."%' OR tbl_program.program_name like'%".$searchValue."%' OR tbl_confirmation.confirmation_status like'%".$searchValue."%' OR tbl_confirmation.confirmation_date like'%".$searchValue."%' ) ";
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
		$applicantDB->join('tbl_letterType', 'tbl_profile.qualifier_type = tbl_letterType.id', 'inner');
		$applicantDB->join('tbl_program', 'tbl_profile.program_id = tbl_program.program_id', 'inner');
		$applicantDB->join('tbl_confirmation', 'tbl_profile.applicant_id = tbl_confirmation.confirmation_id', 'inner');
		// $applicantDB->where('tbl_enrollment.semester_id', $searchSemester);
		if($searchQuery != '')
			$applicantDB->where($searchQuery);
		$records = $applicantDB->get('tbl_profile')->result();
		$totalRecords = $records[0]->allcount;

		## Total number of record with filtering
		$applicantDB->select('count(*) as allcount');
		$applicantDB->join('tbl_letterType', 'tbl_profile.qualifier_type = tbl_letterType.id', 'inner');
		$applicantDB->join('tbl_program', 'tbl_profile.program_id = tbl_program.program_id', 'inner');
		$applicantDB->join('tbl_confirmation', 'tbl_profile.applicant_id = tbl_confirmation.confirmation_id', 'inner');
		if($searchQuery != '')
			$applicantDB->where($searchQuery);
		$records = $applicantDB->get('tbl_profile')->result();
		$totalRecordwithFilter = $records[0]->allcount;

		## Fetch records

		$applicantDB->select('tbl_profile.applicant_id, tbl_profile.fname, tbl_profile.mname, tbl_profile.lname, tbl_letterType.id, tbl_letterType.name, tbl_letterType.code, tbl_program.program_id, tbl_program.program_name, tbl_confirmation.confirmation_date, tbl_confirmation.confirmation_status');
		$applicantDB->join('tbl_letterType', 'tbl_profile.qualifier_type = tbl_letterType.id', 'inner');
		$applicantDB->join('tbl_program', 'tbl_profile.program_id = tbl_program.program_id', 'inner');
		$applicantDB->join('tbl_confirmation', 'tbl_profile.applicant_id = tbl_confirmation.confirmation_id', 'inner');

		if($searchQuery != '')
			$applicantDB->where($searchQuery);

		$applicantDB->order_by($columnName, $columnSortOrder);
		$applicantDB->limit($rowperpage, $start);
		$records = $applicantDB->get('tbl_profile')->result();

		$data = array();
		$ctr = 1;

		foreach($records as $record)
		{
			if ($record->program_id != 0)
			{
				$simple_string = $record->applicant_id;
				$ciphering = "AES-128-CTR";
				$iv_length = openssl_cipher_iv_length($ciphering);
				$options = 0;
				$encryption_iv = '1234567891011121';
				$encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
				$encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
				$decryption_iv = '1234567891011121';
				$decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
				$decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

				$data[] = array( 
					"numRows"				=>	($ctr++),
					"action"				=>	'<a href="/office-of-admissions/app-dl-enrollment-form/'.$record->applicant_id.'" class="btn bg-teal btn-block waves-effect">DOWNLOAD ENROLLMENT FORM</a><a href="/office-of-admissions/app-dl-osa-form/'.$record->applicant_id.'/'.urlencode($encryption).'" class="btn bg-amber btn-block waves-effect">DOWNLOAD OSA FORM</a><a href="/office-of-admissions/app-dl-request-form137/'.$record->applicant_id.'" class="btn bg-blue-grey btn-block waves-effect">Request Form137</a>',
					"applicant_id"			=>	$record->applicant_id,
					"fname"					=>	$record->fname,
					"mname"					=>	$record->mname,
					"lname"					=>	$record->lname,
					"program_name"			=>	$record->program_name,
					"qualifier_type"		=>	$record->name,
					"confirmation_status"	=>	$record->confirmation_status,
					"confirmation_date"		=>	$record->confirmation_date
				); 
			}
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

  	public function getGraduateApplicants($postData=null)
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
		$approvalStatus = $postData['status'];
		$filterVal = array();

		switch ($approvalStatus) 
		{
			case 'pending':
				$filterVal = array("", "");
				break;
			
			case 'pending_department':
				$filterVal = array("pending", "");
				break;
			
			case 'pending_dean':
				$filterVal = array("", "pending");
				break;
		
			case 'approved_regular':
				$filterVal = array("approved_regular", "pending");
				break;
			
			case 'approved_probationary':
				$filterVal = array("approved_probationary", "pending");
				break;
			
			case 'approved':
				$filterVal = array("", "approved");
				break;
			
			case 'show_all':
				$filterVal = array("_all", "_all");
				break;
				
			default:
				# code...
				break;
		}

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
		$applicantDB->select('DISTINCT(application_id) as allcount');
		$applicantDB->group_by('application_id');

		// $applicantDB->where('tbl_enrollment.semester_id', $searchSemester);
		if($searchQuery != '')
			$applicantDB->where($searchQuery);
		$records = $applicantDB->get('oad0003')->result();
		$totalRecords = count($records);
		

		## Total number of record with filtering
		$applicantDB->select('DISTINCT(application_id) as allcount');
		$applicantDB->group_by('application_id');

		if($searchQuery != '')
		{
			$applicantDB->where($searchQuery);
		}

		if ($filterVal[0] == "" && $filterVal[1] != "")
		{
			$applicantDB->where('oad0003.dean_remarks', $filterVal[1]);
		}else if ($filterVal[0] == "_all" && $filterVal[1] == "_all")
		{
			// NO WHERE CLAUSE
		}else
		{
			if ($filterVal[0] == "")
			{
				$applicantDB->group_start();
					$applicantDB->where('oad0003.department_remarks', $filterVal[0]);
					$applicantDB->or_where('oad0003.department_remarks IS NULL');
				$applicantDB->group_end();
			}else
			{
				$applicantDB->where('oad0003.department_remarks', $filterVal[0]);
			}

			if ($filterVal[1] == "")
			{
				$applicantDB->group_start();
					$applicantDB->where('oad0003.dean_remarks', $filterVal[1]);
					$applicantDB->or_where('oad0003.dean_remarks IS NULL');
				$applicantDB->group_end();
			}else
			{
				$applicantDB->group_start();
					$applicantDB->where('oad0003.dean_remarks', $filterVal[1]);
				$applicantDB->group_end();
			}
		}
		$records = $applicantDB->get('oad0003')->result();
		$totalRecordwithFilter = count($records);
		

		## Fetch records
		$applicantDB->select('oad0001.application_id, oad0001.lname, oad0001.fname, oad0001.mname, tbl_course.course_desc, oad0001.degree_program_applied, oad0001.date_created, oad0001.gwa_file, oad0001.img_file, oad0001.proficiency_file, oad0001.tor_file, oad0003.department_remarks, oad0003.dean_remarks, oad0003.department_note, oad0003.dean_note');
		$applicantDB->join('tbl_course', 'oad0001.field_of_study = tbl_course.course_id', 'inner');
		$applicantDB->join('oad0003', 'oad0001.application_id = oad0003.application_id', 'inner');
		$applicantDB->group_by('oad0003.application_id');

		if($searchQuery != '')
		{
			$applicantDB->where($searchQuery);
		}

		if ($filterVal[0] == "" && $filterVal[1] != "")
		{
			$applicantDB->where('oad0003.dean_remarks', $filterVal[1]);
		}else if ($filterVal[0] == "_all" && $filterVal[1] == "_all")
		{
			// NO WHERE CLAUSE
		}else
		{
			if ($filterVal[0] == "")
			{
				$applicantDB->group_start();
					$applicantDB->where('oad0003.department_remarks', $filterVal[0]);
					$applicantDB->or_where('oad0003.department_remarks IS NULL');
				$applicantDB->group_end();
			}else
			{
				$applicantDB->where('oad0003.department_remarks', $filterVal[0]);
			}

			if ($filterVal[1] == "")
			{
				$applicantDB->group_start();
					$applicantDB->where('oad0003.dean_remarks', $filterVal[1]);
					$applicantDB->or_where('oad0003.dean_remarks IS NULL');
				$applicantDB->group_end();
			}else
			{
				$applicantDB->group_start();
					$applicantDB->where('oad0003.dean_remarks', $filterVal[1]);
				$applicantDB->group_end();
			}
		}

		$applicantDB->order_by($columnName, $columnSortOrder);
		$applicantDB->limit($rowperpage, $start);
		$records = $applicantDB->get('oad0001')->result();

		$data = array();
		$ctr = 1;
		$pageCtr = 0;

		$tmp = array();

		foreach($records as $record)
		{
			$referenceHtml = "";
			$actionBtn = "";
			$noaBtn = "";
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
					$actionBtn = count($this->getReference($record->application_id)) == 3 && $this->getApprovalStatus($record->application_id)[0]->department_remarks == "" && $this->getApprovalStatus($record->application_id)[0]->dean_remarks == "" ? 

					'<button class="btn btn-sm bg-green btn-block waves-effect" style="margin-top: 5px;" onclick="endorsedToDepartment(\''.$record->application_id.'\')">ENDORSE TO DEPARTMENT</button>' : 
					
					'<button class="btn btn-sm bg-green btn-block waves-effect disabled" style="margin-top: 5px;">ENDORSE TO DEPARTMENT</button>';

					// NOA BTN
					$noaBtn = count($this->getReference($record->application_id)) == 3 && $this->getApprovalStatus($record->application_id)[0]->dean_remarks == "approved" ? 
					
					'<button type="button" class="btn btn-lg bg-orange btn-block waves-effect" style="font-size: 24px;" onclick="generateNOA(\''.$record->application_id.'\')">
						NOA
					</button>' : 
					
					'<button type="button" class="btn btn-lg bg-orange btn-block waves-effect disabled" style="font-size: 24px;">
						NOA
					</button>';
					// END OF NOA BTN
					break;
				case 'MASTER':
					$actionBtn = count($this->getReference($record->application_id)) == 2 && $this->getApprovalStatus($record->application_id)[0]->department_remarks == "" && $this->getApprovalStatus($record->application_id)[0]->dean_remarks == "" ? 
					
					'<button class="btn btn-sm bg-green btn-block waves-effect" style="margin-top: 5px;" onclick="endorsedToDepartment(\''.$record->application_id.'\')">ENDORSE TO DEPARTMENT</button>' : 
					
					'<button class="btn btn-sm bg-green btn-block waves-effect disabled" style="margin-top: 5px;">ENDORSE TO DEPARTMENT</button>';

					// NOA BTN
					$noaBtn = count($this->getReference($record->application_id)) == 2 && $this->getApprovalStatus($record->application_id)[0]->dean_remarks == "approved" ? 
					
					'<button type="button" class="btn btn-lg bg-orange btn-block waves-effect" style="font-size: 24px;" onclick="generateNOA(\''.$record->application_id.'\')">
						NOA
					</button>' : 
					
					'<button type="button" class="btn btn-lg bg-orange btn-block waves-effect disabled" style="font-size: 24px;">
						NOA
					</button>';
					// END OF NOA BTN
					break;
			}

			$actionBtn .= '<a href="/office-of-admissions/admission_application/applicationInfo/'.$record->application_id.'" class="btn btn-sm bg-teal btn-block waves-effect" target="_BLANK" style="margin-top: 5px;">Application Form</a>';

			$referenceForm = $this->getReferenceAnswer($record->application_id);
			$referenceCtr = 1;
			foreach ($referenceForm as $refForm) 
			{
				$actionBtn .= '<a href="/office-of-admissions/admissions/exportReferenceForm/'.$refForm->reference_id.'" class="btn btn-sm bg-blue-grey btn-block waves-effect" target="_BLANK" style="margin-top: 5px;">Reference '.($referenceCtr++).'</a>';
			}

			$data[] = array( 
				"numRows"				=>	($ctr++),
				"action"				=>	$actionBtn,
				"requirements"			=>	'

					<a href="'.$this->getFileInfo($record->gwa_file, "GWA")['link'].'" target="'.$this->getFileInfo($record->gwa_file, "GWA")['target'].'" class="btn btn-sm bg-amber btn-block waves-effect" style="margin-top: 5px;">GWA</a>

					<a href="'.$this->getFileInfo($record->img_file, "IMG")['link'].'" target="'.$this->getFileInfo($record->img_file, "IMG")['target'].'" class="btn btn-sm bg-blue-grey btn-block waves-effect" style="margin-top: 5px;">PICTURE</a>

					<a href="'.$this->getFileInfo($record->proficiency_file, "PROFICIENCY")['link'].'" target="'.$this->getFileInfo($record->proficiency_file, "PROFICIENCY")['target'].'" class="btn btn-sm bg-orange btn-block waves-effect" style="margin-top: 5px;">PROFICIENCY</a>

					<a href="'.$this->getFileInfo($record->tor_file, "TOR")['link'].'" target="'.$this->getFileInfo($record->tor_file, "TOR")['target'].'" class="btn btn-sm bg-teal btn-block waves-effect" style="margin-top: 5px;">TOR</a>

				',
				"fname"					=>	$record->fname,
				"mname"					=>	$record->mname,
				"lname"					=>	$record->lname,
				"degree_programm"		=>	$record->course_desc,
				"level_applied"			=>	$record->degree_program_applied,
				"date_applied"			=>	date("F d, Y H:i:s", strtotime($record->date_created)),
				"reference"				=>	$referenceHtml,
				"department"			=>	$record->department_remarks,
				"dean"					=>	$record->dean_remarks,
				"department_remarks"	=>	$record->department_remarks."<hr> Note: ".($record->department_note == "" ? "n/a" : $record->department_note),
				"dean_remarks"			=>	$record->dean_remarks."<hr> Note: ".($record->dean_note == "" ? "n/a" : $record->dean_note),
				"referenceCtr"			=>	count($referenceForm),
				"noa"					=>	$noaBtn
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
		$applicantDB->select("reference_id, applicant_id");
		$applicantDB->from("oad0002");
		$applicantDB->where("applicant_id", $applicationID);
		$query = $applicantDB->get();

		return $query->result();
	}

	public function getApprovalStatus($applicationID = "")
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select("*");
		$applicantDB->from("oad0003");
		$applicantDB->where("application_id", $applicationID);
		$applicantDB->group_by(array("application_id"));
		$query = $applicantDB->get();

		return $query->result();
	}

	public function getFileInfo($filename = "", $directory = "")
	{
		if ($filename == "")
		{
			return array("link"	=>	"javascript:alert('No file found')", "target"	=>	"_TOP");
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

	public function getReferenceInfo($referenceID = "")
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select("oad0002.*, tbl_college.college_desc, oad0001.lname, oad0001.fname, oad0001.mname");
		$applicantDB->from("oad0002");
		$applicantDB->join("oad0001", "oad0002.applicant_id = oad0001.application_id", "inner");
		$applicantDB->join("tbl_course", "oad0001.field_of_study = tbl_course.course_id", "inner");
		$applicantDB->join("tbl_college", "tbl_course.college_id = tbl_college.college_id", "inner");
		$applicantDB->where("oad0002.reference_id", $referenceID);
		$query = $applicantDB->get();

		return $query->result();
	}

	public function getReferenceEmail($referenceName, $applicationID)
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		$applicantDB->select("email");
		$applicantDB->from("oad0004");
		$applicantDB->like('reference_name', $referenceName, 'both');
		$applicantDB->where("application_id", $applicationID);
		$query = $applicantDB->get();

		return $query->result();
	}
	/**
	 * End of Other functions
	 */


	/**
	 * CRUD
	 */
	public function update($data = array(), $con = array(), $table = array())
	{
		$applicantDB = $this->load->database('applicantDB', TRUE);
		if(!empty($data)){
			$applicantDB->trans_begin();
	    	$applicantDB->trans_strict(TRUE);

            // Insert member data
           	$applicantDB->update($table[0], $data, $con);
            if ($applicantDB->trans_status() === FALSE) 
            {
		        $applicantDB->trans_rollback();
		        return false;
		    } else 
		    {
		        $applicantDB->trans_commit();
		        return true;
		    }
        }
        return false;
	}

	/**
	 * END OF CRUD
	 */

}

/* End of file Admissions_model.php */
/* Location: ./application/models/Admissions_model.php */
