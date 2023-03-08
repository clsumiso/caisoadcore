<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounting extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('accounting_model', 'accounting');
        $this->load->model('enrollment_model', 'enrollment');
        $this->load->library('computation');
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
			'name'		=>	$_SESSION['account_name'],
			'user_type'	=>	strtoupper($_SESSION['utype']),
			'email'		=>	$_SESSION['e_id'],
			'get_time'	=>	$this->get_time(),
            'semester'  =>  $this->get_semester()
		);
		$this->load->view('accounting/_header', $data);
	    $this->load->view('accounting/_css', $data);
	    $this->load->view('accounting/accounting_view', $data);
	    $this->load->view('accounting/_footer', $data);
	    $this->load->view('accounting/_js', $data);
	}

	public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

    public function get_semester()
    {
        $semesterData = $this->accounting->getSemester();
        $htmlData = '<option value="-1" selected>--- SELECT SEMESTER ---</option>';

        foreach ($semesterData as $semester) 
        {
            $htmlData .= '<option value="'.$semester->semester_id.'">'.($semester->semester_name." ".$semester->semester_year).'</option>';
        }

        return $htmlData;
    }

	public function stundentEnrollment()
	{
        if (!isset($_SESSION['uid'])) 
        {
            redirect('/');
        }

		$nonFreeTuitionStudent = $this->accounting->getNonFreeTuition();

		$courseType = array('MS','MA','PhD');
		$gradStudent = $this->accounting->getGradStudent($courseType);

		$studentID = array();

		foreach ($nonFreeTuitionStudent as $fts) 
		{
			array_push($studentID, $fts->user_id);
		}

		foreach ($gradStudent as $gs) 
		{
			array_push($studentID, $gs->user_id);
		}

		$output = array();
        

        /* SUBJECT DATA & REGISTRATION DATA */
        	$activeSem = $this->enrollment->getActiveSemester();
        /* END SUBJECT DATA */

	    $ctr = 1;
        $updateORrow = 0;
        $assessRow = 0;
		for ($i=0; $i < count($studentID); $i++) 
		{ 
			$enrollData = $this->enrollment->getRegistration($studentID[$i], $_POST['semester']);
            $scholarship = $this->enrollment->check_scholarship($studentID[$i], $_POST['semester']);
            $paymentData = $this->accounting->getPayment($studentID[$i], $_POST['semester']);

            $firstname = "No Profile";
            $middlename = "No Profile";
            $lastname = "No Profile";
            $course = "No Data";
            $section = "No Data";

            $OR = '';
            $amountPaid = 0;
            foreach ($paymentData as $payment) 
            {
                $OR .= '<a href="javascript:void(0)" class="col-teal font-bold" onclick="updateOR(\''.$payment->payment_id.'\', \''.$updateORrow.'\')">'.$payment->transaction_id.'</a>'." [".$payment->date_of_payment."] | ";
                $amountPaid += $payment->amount;
                $updateORrow++;
            }

            if (count($enrollData) > 0) 
            {
                // $profileData = $this->enrollment->getStudentInfo($studentID[$i], $_POST['semester']);
                $firstname = htmlentities($enrollData[0]->fname);
                $middlename = htmlentities($enrollData[0]->mname);
                $lastname = htmlentities($enrollData[0]->lname);
                $course = $enrollData[0]->course_name;
                $section = $enrollData[0]->section;
            }
			

            $scholarship = $this->enrollment->check_scholarship($studentID[$i], $_POST['semester']);

			if (count($enrollData) > 0) 
			{
				$data = array(
					($ctr),
					'<button class="btn btn-md bg-teal waves-effect" onclick="assess(\''.$studentID[$i].'\', \''.$_POST['semester'].'\', \''.$assessRow.'\')">ASSESS</button>',
					$studentID[$i],
					$lastname,
					$firstname,
					$middlename,
					$course,
					$section,
					$OR, // $this->computeFee($studentID[$i], $activeSem[0]->semester_id)[0]['to_pay'],
					floatval($amountPaid)
				);
				$ctr++;
                $assessRow++;
				array_push($output, $data);
			}
		}

		echo json_encode(array("data"	=>	$output));
	}

	public function accountingComponents()
	{
        if (!isset($_SESSION['uid'])) 
        {
            redirect('/');
        }

		$studentID = $_POST['studentID'];
		$semester = $_POST['semester'];
        $feeData = $this->computeFee($studentID, $semester);
        $htmlData = '';
        /*
            $data = array(
                "student_id"            =>  $student_profile[0]->user_id,
                "lname"                 =>  $student_profile[0]->lname,
                "fname"                 =>  $student_profile[0]->fname,
                "mname"                 =>  $student_profile[0]->mname,
                "sex"                   =>  $student_profile[0]->sex,
                "student_type"          =>  $student_profile[0]->student_type,
                "enroll_status"         =>  $student_profile[0]->enroll_status,
                "section"               =>  $section_data[0]->section,
                "degree"                =>  $student_profile[0]->course_name,
                "college"               =>  $student_profile[0]->college_name,
                "tuition"               =>  $tuition_fee,
                "admission_entrance"    =>  $entrance,
                "admission_med_screen"  =>  $med_screen,
                "recreation"            =>  $recreation,
                "scuaa"                 =>  $scuaa,
                "athletic"              =>  $athletic,
                "computer_fee"          =>  $computer,
                "field_study"           =>  $field_study,
                "bridging_fee"          =>  $bridging,
                "scientific_journal"    =>  $sj,
                "student_news_organ"    =>  $sno,
                "field_trip"            =>  0,
                "entrance_new"          =>  $entrance_new,
                "pta"                   =>  $pta,
                "cgc"                   =>  $cgc,
                "class_org"             =>  $class_org,
                "charity"               =>  $charity,
                "laboratory_fee"        =>  $laboratory_fee,
                "audio_visual"          =>  $audio_visual,
                "library_fee"           =>  $library_fee,
                "medical_dental"        =>  $md_fee,
                "insurance"             =>  $insurance,
                "registration"          =>  $registration,
                "school_id"             =>  $school_id,
                "for_billing"           =>  $for_billing,
                "to_pay"                =>  $to_pay,
                "total_for_billing"     =>  $total_for_billing,
                "total_to_pay"          =>  $total_to_pay,
                "regular_units"         =>  $regular_units,
                "saturday_units"        =>  $saturday_units,
                "scholar_code"          =>  count($scholarship) > 0 ? $scholarship[0]->scholarship_code : ''
            );
        */

        $htmlData .= '<tr>';
            $htmlData .= '<td colspan="3"><b>TUITION FEE</b></td>';
        $htmlData .= '</tr>';
        $htmlData .= '<tr>';
            $htmlData .= '<td></td>';
            $htmlData .= '<td>1. Tuition Fee</td>';
            $htmlData .= '<td>'.floatval($feeData[0]['tuition']).'</td>';
        $htmlData .= '</tr>';

        $htmlData .= '<tr>';
            $htmlData .= '<td colspan="3"><b>MISCELLANEOUS AND OTHER SCHOOL FEES</b></td>';
        $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>1. ADMISSION FEES</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Entrance Fee</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['admission_entrance']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Medical Screening</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['admission_med_screen']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>2. ATHLETIC FEES</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Recreation</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['recreation']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">SCUAA</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['scuaa']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Athletic</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['athletic']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>3. COMPUTER FEE</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Computer Fee</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['computer_fee']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>4. DEVELOPMENT FEES</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Field Study</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['field_study']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Bridging</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['bridging_fee']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Scientific Journal</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['scientific_journal']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Student News Organ</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['student_news_organ']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>5. ENTRANCE FEE</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Entrance Fee</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['entrance_new']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>6. GUIDANCE FEES</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Parent  Teacher Association</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['pta']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Career Guidance and Counseling</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['cgc']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Class Organization</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['class_org']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Charity</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['charity']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>7. LABORATORY FEES</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Laboratory Fee</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['laboratory_fee']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Audio-Visual</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['audio_visual']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>8. LIBRARY FEE</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Library Fee</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['library_fee']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>9. MEDICAL AND DENTAL FEES</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Medical and Dental</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['medical_dental']).'</td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">Insurance</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['insurance']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>10. REGISTRATION FEE</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">REGISTRATION FEE</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['registration']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td>11. SCHOOL ID</td>';
                $htmlData .= '<td></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td style="text-indent: 10%;">School ID Fee</td>';
                $htmlData .= '<td>'.floatval($feeData[0]['school_id']).'</td>';
            $htmlData .= '</tr>';

            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td><b>FOR BILLING</b></td>';
                $htmlData .= '<td><input type="text" id="forBilling" class="form-control" value="'.floatval($feeData[0]['total_for_billing']).'" readonly /></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td><b>TO PAY</b></td>';
                $htmlData .= '<td><input type="text" id="toPay" class="form-control" value="'.floatval($feeData[0]['total_to_pay']).'" readonly /></td>';
            $htmlData .= '</tr>';
            $htmlData .= '<tr>';
                $htmlData .= '<td></td>';
                $htmlData .= '<td><b>SCHOLARSHIP</b></td>';
                $htmlData .= '<td><input type="text" class="form-control" value="'.$feeData[0]['scholar_code'].'" readonly /></td>';
            $htmlData .= '</tr>';


		echo json_encode(array("fees" =>  $feeData, "htmlData"  =>  $htmlData, "fullname" =>  ($feeData[0]['lname'].", ".$feeData[0]['fname']." ".$feeData[0]['mname'])));
	}

	public function computeFee($studentID, $semesterID)
	{
        $computation = new Computation();
        $total_for_billing = 0;
        $total_to_pay = 0;
		/* FEE DATA */
            $tuition_fee_data = $this->enrollment->get_tuition(3);
            $admissions_entrance_fee_data = $this->enrollment->get_admission_entrance_fee(3);
            $athletic_fee_data = $this->enrollment->get_athletic_fee();
            $computer_fee_data = $this->enrollment->get_computer_fee();
            $development_fee_data = $this->enrollment->get_development_fee();
            $entrance_fee_new_data = $this->enrollment->get_entrance_fee_new();
            $laboratory_fee_data = $this->enrollment->get_laboratory_fee();
            $guidance_fee_data = $this->enrollment->get_guidance_fee();
            $library_fee_data = $this->enrollment->get_library_fee();
            $medical_dental_data = $this->enrollment->get_medical_dental();
            $registration_fee_data = $this->enrollment->get_registration_fee();
            $school_id_fee_data = $this->enrollment->get_school_id_fee();
        /* END OF FEE DATA */

        /* SUBJECT DATA & REGISTRATION DATA */
        	$activeSem = $this->enrollment->getActiveSemester();
        /* END SUBJECT DATA */

        $output = array();
        // INITIALIZE FEES VALUE
        $tuition_fee = $entrance = $med_screen = $recreation = $scuaa = $athletic = $computer = $field_study = $bridging = $sj = $sno = $field_trip = $entrance_new = $lab_fee = $av = $library_fee = $md_fee = $insurance = $registration = $school_id = $pta = $class_org = $cgc = $charity = $school_id = 0;
        $regular = 0;
        $regular_ctr = 0;
        $regular_units = 0;
        $saturday = 0;
        $saturday_ctr = 0;
        $saturday_units = 0;
        $computer_ctr = 0;
        $field_study_ctr = 0;
        $bstm_bshm_bshrm_lab_ctr = 0;
        $dvm_mvst_lab = 0;
        $regular_lab = 0;
        $for_billing = 0;
        $to_pay = 0;

        $enrollData = $this->enrollment->get_student_enrollment($studentID, $semesterID);

        $student_profile = $this->enrollment->get_student_information($studentID);
        $semester_info = $this->enrollment->get_semester($semesterID);
        $check_no_tosf = $this->enrollment->get_no_tosf($studentID);
        $scholarship = $this->enrollment->check_scholarship($studentID, $semesterID);
        $section_data =  $this->enrollment->get_student_section($studentID, $semesterID);
        // foreach ($enrollData as $enroll) 
        // {
        // 	if ($enroll->weight == 1) 
        // 	{
        // 		// code...
        // 	}
        // }

        foreach ($enrollData as $registration) 
        {
            $class_schedule = $this->enrollment->get_class_schedule($registration->schedid, $semesterID);

            $tuition_fee = $computation->_tuitionFee($student_profile[0]->course_type, $student_profile[0]->course_id, (count($class_schedule) > 0 ? $class_schedule[0]->day : ''), $tuition_fee_data);
            // $test = json_encode($registration_data);
            if (strpos((count($class_schedule) > 0 ? $class_schedule[0]->day : ''), 'S') !== false) 
            {
                $saturday = $tuition_fee;
                $saturday_ctr++;
                if ((count($class_schedule) > 0 ? $class_schedule[0]->weight : 0) != 0)
                {
                    $saturday_units += (count($class_schedule) > 0 ? $class_schedule[0]->units : 0);
                }
            }else
            {
                $regular = $tuition_fee;
                $regular_ctr++;
                if ((count($class_schedule) > 0 ? $class_schedule[0]->weight : 0) != 0)
                {
                    $regular_units += (count($class_schedule) > 0 ? $class_schedule[0]->units : 0);
                }
            }

            if ((count($class_schedule) > 0 ? $class_schedule[0]->class_type : 0) == 2 && (count($class_schedule) > 0 ? $class_schedule[0]->lab_type : 0) == 2)  
            {
                $computer_ctr++;
            }

            if ((count($class_schedule) > 0 ? $class_schedule[0]->class_type : 0) == 5 && (count($class_schedule) > 0 ? $class_schedule[0]->lab_type : 0) == 0) 
            {
                $field_study_ctr++;
            }

            if ((count($class_schedule) > 0 ? $class_schedule[0]->class_type : 0) && (count($class_schedule) > 0 ? $class_schedule[0]->lab_type : 0) == 1) 
            {
                $regular_lab++;
            }

            if ((count($class_schedule) > 0 ? $class_schedule[0]->class_type : 0) == 2 && (count($class_schedule) > 0 ? $class_schedule[0]->lab_type : 0) == 3) 
            {
                $dvm_mvst_lab++;
            }

            if ((count($class_schedule) > 0 ? $class_schedule[0]->class_type : 0) == 2 && (count($class_schedule) > 0 ? $class_schedule[0]->lab_type : 0) == 4) 
            {
                $bstm_bshm_bshrm_lab_ctr++;
            }
        }

        /* TUITION FEE */
            $tuition_fee = (($regular * $regular_units) + ($saturday * $saturday_units));
        /* END OF TUITION FEE */

        /* ADMISSION FEE */
            $entrance = $computation->_entrance($student_profile[0]->year_level, $semester_info[0]->semester_number, count($this->enrollment->get_enroll_count($studentID)), $admissions_entrance_fee_data);

            $med_screen = $computation->_medical_screening(count($this->enrollment->get_enroll_count($studentID)), $student_profile[0]->student_type, $admissions_entrance_fee_data);
        /* END OF ADMISISON FEE */

        /* ATHLETIC FEE */
            $recreation = $computation->_athletic_fee($athletic_fee_data)['recreation'];
            $scuaa = $computation->_athletic_fee($athletic_fee_data)['scuaa'];
            $athletic = $computation->_athletic_fee($athletic_fee_data)['athletic'];
        /* END OF ATHLETIC FEE */

        /* COMPUTER FEE */
            $computer = $computation->_computer_fee($computer_fee_data, $computer_ctr);
        /* END OF COMPUTER FEE */

        /* DEVELOPMENT FEE */
            $field_study = $computation->_field_study($development_fee_data, $field_study_ctr);
            $bridging = $computation->_bridging_fee($development_fee_data, $student_profile[0]->course_id, count($this->enrollment->get_enroll_count($studentID)), $student_profile[0]->year_level);
            $sj = $computation->_scientific_journal($development_fee_data);

            if (!in_array($student_profile[0]->course_type, array('MS','MA','PhD')))
            {
                $sno = $computation->_student_news_organ($development_fee_data);
            }
        /* END OF DEVELOPMENT FEE */

        /* ENTRANCE FEE */
            $entrance_new = $computation->_entrance_new(count($this->enrollment->get_enroll_count($studentID)), $student_profile[0]->student_type, $student_profile[0]->year_level, $entrance_fee_new_data);
        /* END OF ENTRANCE FEE */

        /* GUIDANCE FEE */
            $pta = $computation->_guidance_fee($student_profile[0]->course_type, $guidance_fee_data)['pta'];
            $cgc = $computation->_guidance_fee($student_profile[0]->course_type, $guidance_fee_data)['cgc'];
            $class_org = $computation->_guidance_fee($student_profile[0]->course_type, $guidance_fee_data)['class_org'];
            $charity = $computation->_guidance_fee($student_profile[0]->course_type, $guidance_fee_data)['charity'];
        /* END OF GUIDANCE FEE */
        
        /* LABORATORY FEE */
            $laboratory_enrolled = array($regular_lab, $dvm_mvst_lab, $bstm_bshm_bshrm_lab_ctr);
            $laboratory_fee = $computation->_laboratory_fee($laboratory_enrolled, $laboratory_fee_data);
            $audio_visual = $computation->_audio_visual($laboratory_fee_data);
        /* END OF LABORATORY FEE */
        
        /* LIBRARY FEE */
            $library_fee = $computation->_library_fee($student_profile[0]->course_type, $semester_info[0]->semester_number, $library_fee_data);
        /* END OF LIBRARY FEE */
        
        /* MEDICAL DENTAL FEE */
            $md_fee = $computation->_medical_dental($semester_info[0]->semester_number, $medical_dental_data);
            $insurance = $computation->_insurance($semester_info[0]->semester_number, $medical_dental_data);
        /* END OF MEDICAL DENTAL FEE */
        
        /* REGISTRATION FEE */
            $registration = $computation->_registration_fee($registration_fee_data);
        /* END OF REGISTRATION FEE */
        
        /* SCHOOL ID FEE */
            $school_id = $computation->_school_id($student_profile[0]->student_type, $school_id_fee_data);
        /* END OF SCHOOL ID FEE */

        /* For Billing */
        if (count($check_no_tosf) > 0) 
        {

        }else
        {
            if (in_array($student_profile[0]->course_type, array('BS', 'B', 'D', 'BA'))) 
            {
                $for_billing = $tuition_fee + ($entrance + $med_screen) + ($recreation + $scuaa + $athletic) + $computer + ($field_study + $bridging + $sj + $sno) + $entrance_new + ($pta + $cgc + $class_org + $charity) + ($laboratory_fee + $audio_visual) + $library_fee + ($md_fee + $insurance) + $registration + $school_id;

                $total_for_billing += $for_billing;
            }
        }
        /* End For Billing */

        /* For Total amount to pay */
            if (!in_array($student_profile[0]->course_type, array('BS', 'B', 'D', 'BA'))) 
            {
                $to_pay = $tuition_fee + ($entrance + $med_screen) + ($recreation + $scuaa + $athletic) + $computer + ($field_study + $bridging + $sj + $sno) + $entrance_new + ($pta + $cgc + $class_org + $charity) + ($laboratory_fee + $audio_visual) + $library_fee + ($md_fee + $insurance) + $registration + $school_id;

                $total_to_pay += $to_pay;
            }else{
                if (count($check_no_tosf) > 0) 
                {
                    $to_pay = $tuition_fee + ($entrance + $med_screen) + ($recreation + $scuaa + $athletic) + $computer + ($field_study + $bridging + $sj + $sno) + $entrance_new + ($pta + $cgc + $class_org + $charity) + ($laboratory_fee + $audio_visual) + $library_fee + ($md_fee + $insurance) + $registration + $school_id;

                    $total_to_pay += $to_pay;
                }
            }
        /* END For Total amount to pay */

        /* CHECK SCHOLARSHIP */
        if (count($scholarship) > 0) {
            if ($scholarship[0]->scholarship_covered == "FULL") 
            {
                $total_for_billing = $total_to_pay;
                $total_to_pay = 0;
            }else if ($scholarship[0]->scholarship_covered == "TUITION FEE")
            {
                $total_to_pay -= $tuition_fee;
            }
        }
        /* END OF CHECK SCHOLARSHIP */

        $data = array(
            "student_id"            =>  $student_profile[0]->user_id,
            "lname"                 =>  $student_profile[0]->lname,
            "fname"                 =>  $student_profile[0]->fname,
            "mname"                 =>  $student_profile[0]->mname,
            "sex"                   =>  $student_profile[0]->sex,
            "student_type"          =>  $student_profile[0]->student_type,
            "enroll_status"         =>  $student_profile[0]->enroll_status,
            "section"               =>  count($section_data) > 0 ? $section_data[0]->section : "****",
            "degree"                =>  $student_profile[0]->course_name,
            "college"               =>  $student_profile[0]->college_name,
            "tuition"               =>  $tuition_fee,
            "admission_entrance"    =>  $entrance,
            "admission_med_screen"  =>  $med_screen,
            "recreation"            =>  $recreation,
            "scuaa"                 =>  $scuaa,
            "athletic"              =>  $athletic,
            "computer_fee"          =>  $computer,
            "field_study"           =>  $field_study,
            "bridging_fee"          =>  $bridging,
            "scientific_journal"    =>  $sj,
            "student_news_organ"    =>  $sno,
            "field_trip"            =>  0,
            "entrance_new"          =>  $entrance_new,
            "pta"                   =>  $pta,
            "cgc"                   =>  $cgc,
            "class_org"             =>  $class_org,
            "charity"               =>  $charity,
            "laboratory_fee"        =>  $laboratory_fee,
            "audio_visual"          =>  $audio_visual,
            "library_fee"           =>  $library_fee,
            "medical_dental"        =>  $md_fee,
            "insurance"             =>  $insurance,
            "registration"          =>  $registration,
            "school_id"             =>  $school_id,
            "for_billing"           =>  $for_billing,
            "to_pay"                =>  $to_pay,
            "total_for_billing"     =>  $total_for_billing,
            "total_to_pay"          =>  $total_to_pay,
            "regular_units"         =>  $regular_units,
            "saturday_units"        =>  $saturday_units,
            "scholar_code"          =>  count($scholarship) > 0 ? $scholarship[0]->scholarship_code : ''
        );
        array_push($output, $data);

        return $output;
	}

    public function savePayment()
    {
        $studentID  =   $_POST['studentID'];
        $semester   =   $_POST['semester'];
        $orNumber   =   strtoupper($_POST['orNumber']);
        $amount     =   floatval($_POST['amount']);
        $msg = array();

        $data = array(
            "transaction_id"    =>  $orNumber,
            "semester_id"       =>  $semester,
            "user_id"           =>  $studentID,
            "amount"            =>  $amount,
            "date_of_payment"   =>  date("Y-m-d H:i:s")
        );

        if ($this->accounting->save('tbl_payment', $data)) 
        {
            $msg = array(
                "sys_msg"   =>  "success",
                "msg"       =>  "SUCCESSFULLY SAVED!!!",
                "icon"      =>  "success"
            );
        }else
        {
            $msg = array(
                "sys_msg"   =>  "failed",
                "msg"       =>  "SAVE FAILED!!!",
                "icon"      =>  "error"
            );
        }

        echo json_encode($msg);
    }
}

/* End of file Accounting.php */
/* Location: ./application/controllers/Accounting.php */