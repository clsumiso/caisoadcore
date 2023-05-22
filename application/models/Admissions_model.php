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
				"numRows"				      =>	($ctr++),
				"action"				      =>	'<a href="/office-of-admissions/app-dl-enrollment-form/'.$record->applicant_id.'" class="btn bg-teal waves-effect">DOWNLOAD ENROLLMENT FORM</a> | <a href="/office-of-admissions/app-dl-osa-form/'.$record->applicant_id.'/'.urlencode($encryption).'" class="btn bg-amber waves-effect">DOWNLOAD OSA FORM</a>',
				"applicant_id"			  =>	$record->applicant_id,
				"fname"					      =>	$record->fname,
				"mname"					      =>	$record->mname,
				"lname"					      =>	$record->lname,
				"program_name"			  =>	$record->program_name,
				"qualifier_type"		  =>	$record->name,
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
	// End of DataTable data

  // ------------------------------------------------------------------------

}

/* End of file Admissions_model.php */
/* Location: ./application/models/Admissions_model.php */