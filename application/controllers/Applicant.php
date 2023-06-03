<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Applicant extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
		$this->load->helper('date');
    $this->load->library('form_validation');
    $this->load->model('applicant_model', 'applicant');
		$this->load->model('administrator_model', 'administrator');
  }

  public function index()
  {
    $data = array(
      "code"  =>  "404",
      "msg"   =>  "Page not Found!",
      "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
      "homepageBTN" =>  "GO TO CTEC"
    );
    $this->load->view('err/custom_error', $data);
  }

  public function testEncrypt($applicantID = "")
  {
    $simple_string = $applicantID;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
    $decryption_iv = '1234567891011121';
    $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

    echo urlencode($encryption);
  }

  public function get_time()
	{
		$datestring = '%Y-%m-%d %H:%i:%s';
		$time = time();
		return mdate($datestring, $time);
	}

  public function check_data_privacy()
	{
		$studid = $_POST['uid'];
		$confirm = $this->applicant->get_data_privacy($studid);
		if (count($confirm) > 0) 
		{
			echo json_encode(array('confirm'	=>	1));
		}else
		{
			echo json_encode(array('confirm'	=>	0));
		}
	}

  public function agree_to_data_privacy()
	{
		$studid = $_POST['uid'];

    $data = array(
      'semester_id'		=>	6,
      'user_id'			=>	$studid,
      'date_created'		=>	date('Y-m-d H:m:s')
    );

    $vaccineData = array(
      "user_id"           =>  $_POST['uid'],
      "semester_id"       =>  9,
      "vaccine_remarks"   =>  $_POST['vaccine'],
      "status"            =>  1,
      "date_created"      =>  date("Y-m-d H:i:s")
    );

    $res = $this->applicant->save('tbl_data_privacy_logs', $data);
    if ($res !== false) 
    {
      $this->applicant->save('tbl_vaccine_survey', $vaccineData);
      echo json_encode(array('sys_msg' => 'success'));
    }else
    {
      echo json_encode(array('sys_msg' => 'failed'));
    }
	}

  public function applicant_form($applicantID, $securityCode)
  {
    $simple_string = $applicantID;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
    $decryption_iv = '1234567891011121';
    $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
    if (urlencode($encryption)  == $securityCode)
    {
      $profileData = $this->applicant->getApplicantInfo($applicantID);

      $data = array(
        'appID'             =>  $applicantID,
        'lastname'          =>  count($profileData) > 0 ? $profileData[0]->lname : "",
        'firstname'         =>  count($profileData) > 0 ? $profileData[0]->fname : "",
        'middlename'        =>  count($profileData) > 0 ? $profileData[0]->mname : "",
        'program'           =>  count($profileData) > 0 ? $profileData[0]->program_name : "",
        'applicantProgram'  =>  $this->applicantProgram()
      );

      $this->load->view('applicants/_header', $data);
      $this->load->view('applicants/_css', $data);
      $this->load->view('applicants/applicant_enrollment_form_view', $data);
      $this->load->view('applicants/_footer', $data);
      $this->load->view('applicants/_js', $data);
    }else
    {
      $data = array(
        "code"  =>  "OFFICE OF ADMISSIONS",
        "msg"   =>  "Forbidden Access",
        "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
        "homepageBTN" =>  "GO TO CTEC"
      );
      $this->load->view('err/custom_error', $data);
    }

    
  }

  public function update_applicant_form($appID, $securityCode)
  {
    $simple_string = $appID;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
    $decryption_iv = '1234567891011121';
    $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);
    $data = array();

    if (urlencode($encryption)  == $securityCode)
    {
      $applicant_id = $appID;
      $ctr = 1;
      $applicant_info = $this->applicant->get_applicant_info($applicant_id);
      $test = '';
      foreach ($applicant_info as $applicant) 
      {
        $html = '';
        $program = '';
        $college = '';
        $department = '';
        $clsu2_email = '';

        $college_vocational = "";
        // '.$applicant->vocational_school_address.','.$applicant->vocational_school_year.','.$applicant->vocational_awads.'|'.$applicant->college_school_address.','.$applicant->college_school_year.','.$applicant->college_awards.'
        if ($applicant->vocational_school_address != "")
        {
          $college_vocational .= $applicant->vocational_school_address;
        }

        if ($applicant->vocational_school_address != "")
        {
          $college_vocational .= ",".$applicant->vocational_school_year;
        }

        if ($applicant->vocational_awads != "")
        {
          $college_vocational .= ",".$applicant->vocational_awads;
        }

        if ($applicant->college_school_address != "")
        {
          $college_vocational .= "|".$applicant->college_school_address;
        }

        if ($applicant->college_school_year != "")
        {
          $college_vocational .= ",".$applicant->college_school_year;
        }

        if ($applicant->college_awards != "")
        {
          $college_vocational .= ",".$applicant->college_awards;
        }

        $student_info = $this->applicant->get_student_info($applicant_id);
        foreach ($student_info as $student) 
        {
          $program = $student->program_name;
          $college = $student->college_desc;
          $clsu2_email = $student->student_email;
        }

        $data = array(
          "applicant_id"                  =>  $applicant_id, 
          "lastname"                      =>  $applicant->lname, 
          "firstname"                     =>  $applicant->fname, 
          "middlename"                    =>  $applicant->mname, 
          "age"                           =>  $applicant->age, 
          "permanent_address"             =>  $applicant->permanent_address, 
          "zipcode"                       =>  $applicant->zipcode, 
          "country"                       =>  $applicant->country, 
          "date_of_birth"                 =>  $applicant->date_of_birth, 
          "place_of_birth"                =>  $applicant->place_of_birth, 
          "course_program"                =>  $program, 
          "gender"                        =>  $applicant->gender, 
          "civil_status"                  =>  $applicant->civil_status, 
          "student_tel_contact"           =>  $applicant->student_tel_contact, 
          "student_mobile_contact"        =>  $applicant->student_mobile_contact, 
          "student_email"                 =>  $clsu2_email, 
          "clsu_address"                  =>  $applicant->clsu_address,
          "senior_high_address"           =>  $applicant->senior_high_address,
          "type_of_school"                =>  $applicant->type_of_school, 
          "high_school_grad_year"         =>  $applicant->high_school_grad_year, 
          "father_name"                   =>  $applicant->father_name, 
          "father_age"                    =>  $applicant->father_age, 
          "father_occupation"             =>  $applicant->father_occupation, 
          "father_education"              =>  $applicant->father_education, 
          "mother_name"                   =>  $applicant->mother_name, 
          "mother_age"                    =>  $applicant->mother_age, 
          "mother_occupation"             =>  $applicant->mother_occupation, 
          "mother_education"              =>  $applicant->mother_education, 
          "birth_order"                   =>  $applicant->birth_order, 
          "no_brother"                    =>  $applicant->no_brother, 
          "no_sister"                     =>  $applicant->no_sister, 
          "family_income"                 =>  $applicant->family_income, 
          "elementary_school_address"     =>  $applicant->elementary_school_address, 
          "elementary_year"               =>  $applicant->elementary_year, 
          "high_school_address"           =>  $applicant->high_school_address, 
          "high_school_year"              =>  $applicant->high_school_year, 
          "vocational_school_address"     =>  $applicant->vocational_school_address, 
          "vocational_school_year"        =>  $applicant->vocational_school_year, 
          "college_school_address"        =>  $applicant->college_school_address, 
          "college_school_year"           =>  $applicant->college_school_year, 
          "extra_curricular"              =>  $applicant->extra_curricular, 
          "emergency_person"              =>  $applicant->emergency_person, 
          "emergency_relationship"        =>  $applicant->emergency_relationship, 
          "emergency_contact"             =>  $applicant->emergency_contact, 
          "emergency_address"             =>  $applicant->emergency_address, 
          "scholarship"                   =>  $applicant->scholarship, 
          "first_generation"              =>  $applicant->first_generation, 
          "disability"                    =>  $applicant->disability, 
          "family_doctor"                 =>  $applicant->family_doctor,
          "family_doctor_contact"         =>  $applicant->family_doctor_contact,
          "senior_high_school_awards"     =>  $applicant->senior_high_school_awards,
          "father_contact"                =>  $applicant->father_contact,
          "mother_contact"                =>  $applicant->mother_contact,
          "father_address"                =>  $applicant->father_address,
          "mother_address"                =>  $applicant->mother_address,
          "elem_awards"                   =>  $applicant->elem_awards,
          "high_school_awards"            =>  $applicant->high_school_awards,
          "vocational_awads"              =>  $applicant->vocational_awads,
          "college_awards"                =>  $applicant->college_awards,
          "guardian_name"                 =>  $applicant->guardian_name,
          "guardian_age"                  =>  $applicant->guardian_age,
          "guardian_occupation"           =>  $applicant->guardian_occupation,
          "guardian_education"            =>  $applicant->guardian_education,
          "guardian_contact"              =>  $applicant->guardian_contact,
          "guardian_address"              =>  $applicant->guardian_address,
          "four_p"                        =>  $applicant->four_p,
          "listahanan"                    =>  $applicant->listahanan,
          "strand"                        =>  $applicant->strand,
          "parent_marriage_status"        =>  $applicant->parent_marriage_status,
          "guardian_relationship"         =>  $applicant->guardian_relationship,
          "guardian_email"                =>  $applicant->guardian_email,
          "study_habit"                   =>  $applicant->study_habit,
          "study_habit_hours"             =>  $applicant->study_habit_hours,
          "reason_to_enroll"              =>  $applicant->reason_to_enroll,
          "vision_health"                 =>  $applicant->vision_health,
          "allergy"                       =>  $applicant->allergy,
          "medicine_take"                 =>  $applicant->medicine_take,
          "guidance_councilor"            =>  $applicant->guidance_councilor,
          "visit_guidance_councilor"      =>  $applicant->visit_guidance_councilor,
          "guidance_councilor_assistance" =>  $applicant->guidance_councilor_assistance
        );
      }
      $this->load->view('applicants/_header', $data);
      $this->load->view('applicants/_css', $data);
      $this->load->view('applicants/update_applicant_enrollment_form_view', $data);
      $this->load->view('applicants/_footer', $data);
      $this->load->view('applicants/_js', $data);
    }else
    {
      $data = array(
        "code"  =>  "OFFICE OF ADMISSIONS",
        "msg"   =>  "Forbidden Access",
        "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
        "homepageBTN" =>  "GO TO CTEC"
      );
      $this->load->view('err/custom_error', $data);
    }
  }

  public function applicantVerification($applicantID = "", $securityCode = "")
  {
      $simple_string = $applicantID;
      $ciphering = "AES-128-CTR";
      $iv_length = openssl_cipher_iv_length($ciphering);
      $options = 0;
      $encryption_iv = '1234567891011121';
      $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
      $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
      $decryption_iv = '1234567891011121';
      $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
      $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

      if (urlencode($encryption)  == $securityCode)
      {

        if ($this->letterContent($applicantID) == "not_scheduled_today")
        {
          $data = array(
            "code"  =>  "OFFICE OF ADMISSIONS",
            "msg"   =>  "You are not scheduled today",
            "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
            "homepageBTN" =>  "GO TO CTEC"
          );
          $this->load->view('err/custom_error', $data);
        }else if ($this->letterContent($applicantID) == "profile_not_found")
        {
          $data = array(
            "code"  =>  "OFFICE OF ADMISSIONS",
            "msg"   =>  "Profile not found, please contact CLSU Testing and Evaluation Center (CTEC)",
            "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
            "homepageBTN" =>  "GO TO CTEC"
          );
          $this->load->view('err/custom_error', $data);
        }else
        {
          $data = array(
            "appID"               =>  $applicantID,
            "securityCode"        =>  $securityCode,
            "letterContent"       =>  $this->letterContent($applicantID),
            "confirmationStatus"  =>  $this->verifyConfirmation($applicantID)
          );

          $view_logs = array(
            "user_id"       =>  $applicantID,
            "semester_id"   =>  9,
            "action"        =>  "view",
            "old_data"      =>  "",
            "new_data"      =>  "",
            "date_created"  =>  $this->get_time()
          );
    
          $this->applicant->save("metadata", $view_logs);
  
          $this->load->view('applicants/_header', $data);
          $this->load->view('applicants/_css', $data);
          $this->load->view('applicants/applicant_view', $data);
          $this->load->view('applicants/_footer', $data);
          $this->load->view('applicants/_data_privacy_modal', $data);
          $this->load->view('applicants/_js', $data);
        }
      }else
      {
        $data = array(
          "code"  =>  "401",
          "msg"   =>  "Unauthorized Access",
          "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
          "homepageBTN" =>  "GO TO CTEC"
        );
        $this->load->view('err/custom_error', $data);
      }
  }

  public function verifyConfirmation($applicantID = "")
  {
    $confirmationData = $this->applicant->getConfirmation($applicantID);
    $confirmationDate = "";
    foreach ($confirmationData as $confirmation) 
    {
      $confirmationDate = $confirmation->confirmation_date;
    }

    return $confirmationDate;
  }

  public function letterContent($applicantID = "")
  {

    $profileData = $this->applicant->getApplicantInfo($applicantID);
    $appType = "";
    $htmlData = "";

    if (count($profileData) > 0)
    {
      $appType = $profileData[0]->qualifier_type;
      $releaseData = $this->applicant->getReleaseDate($appType);
      if (count($releaseData) > 0)
      {
        $simple_string = $applicantID;
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
        $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
        $decryption_iv = '1234567891011121';
        $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
        $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

        // if (strtotime($releaseData[0]->release_date) >= strtotime("2023-04-28 16:11:44"))
        // {

        // }else
        // {

        // }

        if (strtotime($this->get_time()) >= strtotime($releaseData[0]->date_from)  && strtotime($this->get_time()) <= strtotime($releaseData[0]->date_to))
        {
          $letterData = $this->applicant->getLetterContent($applicantID, $appType);
          $confirmationData = $this->applicant->getConfirmation($applicantID);

          foreach ($letterData as $letter) 
          {
            $htmlData = $letter->content;
          }
          
          if (count($confirmationData) > 0)
          {
            // $htmlData .= '
            //     <div class="row clearfix" style="border: 5px dashed #27ae60; margin: 20px;">
            //         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            //           <h2>You have accepted the offer</h2>
            //           <p style="color: #2c3e50; font-size: 30px;">Kindly wait for a while; just keep monitoring your CTEC portal. The Admission form and OSA form will be downloadable soon.</p>
            //         </div>
            //     </div>
            // ';

            if ($appType == 2)
            {
              $max = 0;
              $min = 0;
              $ctr = 0;

              $initialProgram = $this->applicant->getInitialProgram($applicantID);
              // $newProgram = $this->applicant->getNewProgram($applicantID);
              $applicantProgramID = count($initialProgram) > 0 ? $initialProgram[0]->program_id : $profileData[0]->program_id;

              if (count($this->applicant->checkTotalEnroll($applicantProgramID)) < $this->applicant->checkSlot($applicantProgramID)[0]->slot) 
              {
                $letterData = $this->applicant->getLetterContent($applicantID, 15);

                foreach ($letterData as $letter) 
                {
                  $htmlData = $letter->content;
                }

                // $topRank = $this->applicant->checkSlot($applicantProgramID)[0]->slot - count($this->applicant->checkTotalEnroll($applicantProgramID));

                $topRank = count($this->applicant->getRemainingSlot($applicantProgramID)) > 0 ? intval($this->applicant->getRemainingSlot($applicantProgramID)[0]->remaining_slot) : 0;
                
                $rankings = $this->applicant->getApplicantRank($applicantProgramID);
                foreach ($rankings as $rank) 
                {
                  if ($ctr == 0) 
                  {
                    $max = $rank->percentile_rank;
                  }
                  
                  $topRank--;
                  if ($topRank == 0)
                  {
                    $min = $rank->percentile_rank;
                    break;
                  }
                  $ctr++;
                }

                $applicantPercentileRank = $this->applicant->getApplicantIndividualRank($applicantID);
                if (count($applicantPercentileRank) > 0)
                {
                  if (floatval($applicantPercentileRank[0]->percentile_rank) >= $min)
                  {
                    // $htmlData .= '<a href="javascript:void(0)" class="btn btn-success btn-lg btn-block waves-effect" onclick="data_privacy(\''.$applicantID.'\')">ACCEPT</a>';
                  }else
                  {
                    // Not qualified in the top ranks
                    $letterData = $this->applicant->getLetterContent($applicantID, 17);

                    foreach ($letterData as $letter) 
                    {
                      $htmlData = $letter->content;
                    }
                  }
                }else
                {
                  $htmlData = "profile_not_found";
                }
                
                // $htmlData = '<p>'.$max.'</p>|<p>'.$min.'</p>|<p>'.$topRank.'</p>';
              }else
              {
                // $htmlData = "profile_not_found";
                $letterData = $this->applicant->getLetterContent($applicantID, 14);

                foreach ($letterData as $letter) 
                {
                  $htmlData = $letter->content;
                }
              }
            }
            $htmlData .= '
              <a href="javascript:void(0)" class="btn bg-blue-grey btn-lg btn-block waves-effect" onclick="updateIndividualForm(\''.$applicantID.'\', \''.urlencode($encryption).'\')">UPDATE INDIVIDUAL RECORD FORM</a>

              <a href="/office-of-admissions/app-dl-enrollment-form/'.$applicantID.'" class="btn bg-green btn-lg btn-block waves-effect">DOWNLOAD ENROLLMENT FORM <small>(Date Confirmed: '.$confirmationData[0]->confirmation_date.')</small></a>

              <a href="/office-of-admissions/app-dl-osa-form/'.$applicantID.'/'.urlencode($encryption).'" class="btn bg-amber btn-lg btn-block waves-effect">DOWNLOAD OSA FORM <small>(Date Confirmed: '.$confirmationData[0]->confirmation_date.')</small></a>';
          }else
          {
            if (strtotime($this->get_time()) >= strtotime($releaseData[0]->date_from) && strtotime($this->get_time()) <= strtotime($releaseData[0]->date_to))
            {
              if ($appType == 1)
              {
                if (in_array($applicantID, array("23-06755")))
                {
                  $htmlData .= '<a href="javascript:void(0)" class="btn btn-success btn-lg btn-block waves-effect" onclick="data_privacy(\''.$applicantID.'\', \''.urlencode($encryption).'\')">ACCEPT</a>';
                }
                // $htmlData .= '<a href="javascript:void(0)" class="btn btn-success btn-lg btn-block waves-effect" onclick="data_privacy(\''.$applicantID.'\', \''.urlencode($encryption).'\')">ACCEPT</a>';
              }

              if ($appType == 2)
              {
                $max = 0;
                $min = 0;
                $ctr = 0;
                $initialProgram = $this->applicant->getInitialProgram($applicantID);
                // $newProgram = $this->applicant->getNewProgram($applicantID);
                $applicantProgramID = count($initialProgram) > 0 ? $initialProgram[0]->program_id : $profileData[0]->program_id;

                if (count($this->applicant->checkTotalEnroll($applicantProgramID)) < $this->applicant->checkSlot($applicantProgramID)[0]->slot) 
                {
                  $letterData = $this->applicant->getLetterContent($applicantID, 15);

                  foreach ($letterData as $letter) 
                  {
                    $htmlData = $letter->content;
                  }

                  // $topRank = $this->applicant->checkSlot($applicantProgramID)[0]->slot - count($this->applicant->checkTotalEnroll($applicantProgramID));

                  $topRank = count($this->applicant->getRemainingSlot($applicantProgramID)) > 0 ? intval($this->applicant->getRemainingSlot($applicantProgramID)[0]->remaining_slot) : 0;
                  
                  $rankings = $this->applicant->getApplicantRank($applicantProgramID);
                  foreach ($rankings as $rank) 
                  {
                    if ($ctr == 0) 
                    {
                      $max = $rank->percentile_rank;
                    }
                    
                    $topRank--;
                    if ($topRank == 0)
                    {
                      $min = $rank->percentile_rank;
                      break;
                    }
                    $ctr++;
                  }

                  $applicantPercentileRank = $this->applicant->getApplicantIndividualRank($applicantID);
                  if (count($applicantPercentileRank) > 0)
                  {
                    if (floatval($applicantPercentileRank[0]->percentile_rank) >= $min)
                    {
                      $htmlData .= '<a href="javascript:void(0)" class="btn btn-success btn-lg btn-block waves-effect" onclick="data_privacy(\''.$applicantID.'\', \''.urlencode($encryption).'\')">ACCEPT</a>';
                    }else
                    {
                      // Not qualified in the top ranks
                      $letterData = $this->applicant->getLetterContent($applicantID, 17);

                      foreach ($letterData as $letter) 
                      {
                        $htmlData = $letter->content;
                      }
                    }
                  }else
                  {
                    $htmlData = "profile_not_found";
                  }
                  
                  // $htmlData = '<p>'.$max.'</p>|<p>'.$min.'</p>|<p>'.$topRank.'</p>';
                }else
                {
                  // $htmlData = "profile_not_found";
                  $letterData = $this->applicant->getLetterContent($applicantID, 14);

                  foreach ($letterData as $letter) 
                  {
                    $htmlData = $letter->content;
                  }
                }
              }
            }else
            {
              // Write something if non
              $htmlData = "not_scheduled_today";
            }
          }
          
          // $htmlData = strtotime($releaseData[0]->date_from)." | ".strtotime($this->get_time())."<br>";
          // $htmlData .= strtotime($releaseData[0]->date_to)." | ".strtotime($this->get_time())."<br>";
        }else
        {
          // $data = array(
          //   "code"  =>  "401",
          //   "msg"   =>  "You are not scheduled today",
          //   "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/"
          // );
          // $this->load->view('err/custom_error', $data);
          $htmlData = "not_scheduled_today";
        }
      }else
      {
        $htmlData = "not_scheduled_today";
      }

      
    }else
    {
      // $data = array(
      //   "code"  =>  "404",
      //   "msg"   =>  "Profile not found, please contact CLSU Testing and Evaluation Center (CTEC)",
      //   "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/"
      // );
      // $this->load->view('err/custom_error', $data);
      $htmlData = "profile_not_found";
    }

    return $htmlData;
  }

  public function applicantProgram()
	{
		$programData = $this->administrator->getList("tbl_program", array(), "");
		$htmlData = '<option value="-1">-- SELECT PROGRAM --</option>';

		foreach ($programData as $program) 
		{
			$htmlData .= '<option value="'.$program->program_id.'">'.$program->program_name.'</option>';
		}

		return $htmlData;
	}

  public function applicantInfo()
  {
    $appID = $_POST['appID'];
    $profileData = $this->applicant->getApplicantInfo($appID);
    
    $releaseData = $this->applicant->getReleaseDate($profileData[0]->qualifier_type);
    $applicant_id = "";
    $name = "";
    $program = "";
    $output = array();
    foreach ($profileData as $profile) 
    {
      $output = array(
        "appID"             =>  $profile->applicant_id,
        "name"              =>  $profile->lname.", ".$profile->fname." ".$profile->mname,
        "program"           =>  $profile->program_name,
        "releaseDate"       =>  date("d F Y", strtotime($releaseData[0]->date_from)),
        "dateFrom"          =>  date("d F Y", strtotime($releaseData[0]->date_from)),
        "dateTo"            =>  date("d F Y", strtotime($releaseData[0]->date_to)),
        "nonqoutaprograms"  =>  $this->nonQoutaPrograms($profile->applicant_id, $profile->qualifier_type)
      );
    }

    echo json_encode(array("profile"  =>  $output));
  }

  public function changeProgram()
  {
    
    $applicantID = $_POST['appID'];
    $programID = $_POST['programID'];
    $msg = array();

    $simple_string = $applicantID;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
    $decryption_iv = '1234567891011121';
    $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

    $data = array(
      "program_id"  =>  $programID
    );

    $condition = array(
      "applicant_id"  =>  $applicantID
    );

    $updateProgram = $this->applicant->updateForm($data, $condition, array("tbl_profile"));
    if ($updateProgram !== false)
    {
      $msg = array(
        "sys_msg"       =>  "success",
        "msg"           =>  "",
        "securityCode"  =>  urlencode($encryption)
      );
    }else
    {
      $msg = array(
        "sys_msg"       =>  "failed",
        "msg"           =>  "Something went wrong, please try again",
        "securityCode"  =>  urlencode($encryption)
      );
    }

    echo json_encode($msg);
  }

  public function nonQoutaPrograms($applicantID, $qualifier_type)
  {
    $programData = $this->applicant->getProgram(0);

    $initialProgram = $this->applicant->getInitialProgram($applicantID);
    $newProgram = $this->applicant->getNewProgram($applicantID);

    $confirmationData = $this->applicant->getConfirmation($applicantID);
    $applicantProgram = $this->applicant->getReleaseDate($qualifier_type);;
    $htmlData = '';

    $simple_string = $applicantID;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
    $decryption_iv = '1234567891011121';
    $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

    foreach ($programData as $program) 
    {
      if (in_array($program->program_id, explode("|", $applicantProgram[0]->program_id)))
      {
        // $topRank = $this->applicant->checkSlot($program->program_id)[0]->slot - count($this->applicant->checkTotalEnroll($program->program_id));
        if (strtotime($this->get_time()) >= strtotime($applicantProgram[0]->release_date) && strtotime($this->get_time()) <= strtotime($applicantProgram[0]->release_date_to))
        {
          // ' <button class="btn bg-teal">ACCEPT</button></li>'
          if (count($this->applicant->checkTotalEnroll($program->program_id)) <= $this->applicant->checkSlot($program->program_id)[0]->slot)
          {
            if (count($initialProgram) > 0)
            {
              if ($initialProgram[0]->program_id != $program->program_id)
              {
                if (count($confirmationData) > 0)
                {
                  if ($newProgram[0]->program_id == $program->program_id)
                  {
                    $htmlData .= '<li>'.$program->program_name.'</li>';
                  }
                }else
                {
                  if ($initialProgram[0]->program_id == $newProgram[0]->program_id)
                  {
                    $htmlData .= '<li>'.$program->program_name.' | <button class="btn bg-teal" onclick="acceptChoiceProgram(\''.$program->program_id.'\', \''.$program->program_name.'\', \''.$applicantID.'\', \''.urlencode($encryption).'\')">ACCEPT</button></li>';
                  }else
                  {
                    if ($newProgram[0]->program_id == $program->program_id)
                    {
                      $htmlData .= '<li>'.$program->program_name.' | <button class="btn bg-teal" onclick="acceptChoiceProgram(\''.$program->program_id.'\', \''.$program->program_name.'\', \''.$applicantID.'\', \''.urlencode($encryption).'\')">GO TO INDIVIDUAL RECORD FORM</button></li>';
                    }
                  }
                }
              }
            }
          }
          
        }else
        {
          // $htmlData .= '<li>'.$program->program_name.'</li>';  
        }
        
      }
    }

    return $htmlData;
  }

  public function enrollmentForm()
  {
    if ($_POST['applicantID'] == "")
    {
      redirect("https://ctec.clsu2.edu.ph/clsucat/");
    }
    $config = array(
      array(
              'field' => 'applicantID',
              'label' => 'APPLICANT ID',
              'rules' => 'required'
      ),
      array(
              'field' => 'lastname',
              'label' => 'LASTNAME',
              'rules' => 'required'
      ),
      array(
              'field' => 'firstname',
              'label' => 'FIRSTNAME',
              'rules' => 'required'
      ),
      array(
              'field' => 'middlename',
              'label' => 'MIDDLENAME',
              'rules' => 'required'
      ),
      array(
              'field' => 'age',
              'label' => 'AGE',
              'rules' => 'required'
      ),
      array(
              'field' => 'sex',
              'label' => 'SEX',
              'rules' => 'required'
      ),
      array(
              'field' => 'religion',
              'label' => 'RELIGION',
              'rules' => 'required'
      ),
      array(
              'field' => 'citizenship',
              'label' => 'CITIZENSHIP',
              'rules' => 'required'
      ),
      array(
              'field' => 'street1',
              'label' => 'Permanent Address (House No., Street Name, Building)',
              'rules' => 'required'
      ),
      array(
              'field' => 'date_of_birth',
              'label' => 'DATE OF BIRTH',
              'rules' => 'required'
      ),
      array(
              'field' => 'course_year',
              'label' => 'COURSE & YEAR',
              'rules' => 'required'
      ),
      array(
              'field' => 'gender',
              'label' => 'GENDER',
              'rules' => 'required'
      ),
      array(
              'field' => 'civilStatus',
              'label' => 'CIVIL STATUS',
              'rules' => 'required'
      ),
      array(
              'field' => 'tel_no',
              'label' => 'TELEPHONE NUMBER',
              'rules' => 'required'
      ),
      array(
              'field' => 'mobile_no',
              'label' => 'MOBILE NUMBER',
              'rules' => 'required'
      ),
      array(
              'field' => 'email_address',
              'label' => 'EMAIL ADDRESS',
              'rules' => 'required'
      ),
      array(
              'field' => 'street3',
              'label' => 'Senior High School where Graduated',
              'rules' => 'required'
      ),
      array(
              'field' => 'schoolType',
              'label' => 'Type of School',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_name',
              'label' => 'Name of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_age',
              'label' => 'Age of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_occupation',
              'label' => 'Occupation of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_education',
              'label' => 'Educational Attainment of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_name',
              'label' => 'Name of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_age',
              'label' => 'Age of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_occupation',
              'label' => 'Occupation of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_education',
              'label' => 'Educational Attainment of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'birth_order',
              'label' => 'Birth Order in the Family',
              'rules' => 'required'
      ),
      array(
              'field' => 'number_of_brother',
              'label' => 'No. of Brothers',
              'rules' => 'required'
      ),
      array(
              'field' => 'number_of_sister',
              'label' => 'No. of Sisters',
              'rules' => 'required'
      ),
      array(
              'field' => 'familyIncome',
              'label' => 'Annual Family Income',
              'rules' => 'required'
      ),
      array(
              'field' => 'elementary_schoolName',
              'label' => 'Elementary School and Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'elementary_year',
              'label' => 'Elementary Inclusive Years',
              'rules' => 'required'
      ),
      array(
              'field' => 'highSchool_schoolName',
              'label' => 'High School and Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'highSchool_year',
              'label' => 'High School and Address',
              'label' => 'High School Inclusive Years',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_person',
              'label' => 'Name of Person to be notified in case of emergency',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_relationship',
              'label' => 'Relationship',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_contact',
              'label' => 'Emergency Tel. / Cell No',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_address',
              'label' => 'Emergency Person Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'indigenous',
              'label' => 'indigenous groups',
              'rules' => 'required'
      ),
      array(
              'field' => 'firstGeneration',
              'label' => 'First Generation College Student',
              'rules' => 'required'
      ),
      array(
              'field' => 'disability',
              'label' => 'disability',
              'rules' => 'required'
      ),
      array(
              'field' => 'zipcode',
              'label' => 'Postal/Zip Code',
              'rules' => 'required'
      ),
      array(
              'field' => 'country',
              'label' => 'Country',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_contact',
              'label' => 'Father Contact',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_address',
              'label' => 'Father Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_contact',
              'label' => 'Mother Contact',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_address',
              'label' => 'Mother Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'region1',
              'label' => 'Permanent Address (Region)',
              'rules' => 'required'
      ),
      array(
              'field' => 'province1',
              'label' => 'Permanent Address (Province)',
              'rules' => 'required'
      ),
      array(
              'field' => 'municipality1',
              'label' => 'Permanent Address (Municipality)',
              'rules' => 'required'
      ),
      array(
              'field' => 'barangay1',
              'label' => 'Permanent Address (Barangay)',
              'rules' => 'required'
      ),
      array(
              'field' => 'region3',
              'label' => 'Senior High School where Graduated (Region)',
              'rules' => 'required'
      ),
      array(
              'field' => 'province3',
              'label' => 'Senior High School where Graduated (Province)',
              'rules' => 'required'
      ),
      array(
              'field' => 'municipality3',
              'label' => 'Senior High School where Graduated (Municipality)',
              'rules' => 'required'
      ),
      array(
              'field' => 'barangay3',
              'label' => 'Senior High School where Graduated (Barangay)',
              'rules' => 'required'
      ),
      array(
              'field' => 'signatories',
              'label' => 'Signatories',
              'rules' => (isset($_POST['signatories'])) ? "" : "required"
      ),
      array(
              'field' => 'four_p',
              'label' => '4P\'s',
              'rules' => 'required'
      ),
      array(
              'field' => 'listahanan',
              'label' => 'Listahanan',
              'rules' => 'required'
      ),
      array(
              'field' => 'strand',
              'label' => 'Strand',
              'rules' => 'required'
      ),
      array(
              'field' => 'parent_marriage_status',
              'label' => 'Parents marriage status',
              'rules' => 'required'
      ),
      array(
              'field' => 'living_with_parent',
              'label' => 'Living with your parents',
              'rules' => 'required' 
      ),
      array(
              'field' => 'living_with_parent_remarks',
              'label' => 'Reason why your not Living with your parents',
              'rules' => (isset($_POST['living_with_parent'])) ? $_POST['living_with_parent'] == "no" ? 'required' : '' : ''
      ),
      array(
              'field' => 'companions_at_home',
              'label' => 'Companions at home',
              'rules' => (isset($_POST['companions_at_home'])) ? "" : "required"
      ),
      array(
              'field' =>  'working_student',
              'label' =>  'Part-time working student',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'working_student_remarks',
              'label' =>  'Part-time working student',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guardian_relationship',
              'label' =>  'Relationship to your guardian',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guardian_email',
              'label' =>  'Email Address of your Guardian',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'study_habit',
              'label' =>  'Study habit',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'current_event',
              'label' =>  'Current events?',
              'rules' => (isset($_POST['current_event'])) ? "" : "required"
      ),
      array(
              'field' =>  'reason_to_enroll',
              'label' =>  'Why did you enroll in CLSU',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'allergy',
              'label' =>  'Allergy',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'medicine_take',
              'label' =>  'Medicine for maintenance of health condition',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'mental_health',
              'label' =>  'Existing mental health condition',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guidance_councilor',
              'label' =>  'Guidance counselor for assistance',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'visit_guidance_councilor',
              'label' =>  'Plan to visit your guidance counselor',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guidance_councilor_assistance',
              'label' =>  'Guidance counselor assistance',
              'rules' =>  'required'
      )
    );

    $this->form_validation->set_rules($config);

    if ($this->form_validation->run() == FALSE)
    {

      $data = array(
        'applicantProgram'  =>  $this->applicantProgram()
      );
  
      $this->load->view('applicants/_header', $data);
      $this->load->view('applicants/_css', $data);
      $this->load->view('applicants/applicant_enrollment_form_view', $data);
      $this->load->view('applicants/_footer', $data);
      $this->load->view('applicants/_js', $data);
    }
    else
    {
      // $this->load->view('formsuccess');
      $enrollmentFormData = array(
        "applicant_id"                  =>  $_POST['applicantID'], 
        "lastname"                      =>  $_POST['lastname'], 
        "firstname"                     =>  $_POST['firstname'], 
        "middlename"                    =>  $_POST['middlename'], 
        "age"                           =>  $_POST['age'], 
        "sex"                           =>  $_POST['sex'], 
        "religion_id"                   =>  $_POST['religion'], 
        "citizenship_id"                =>  $_POST['citizenship'], 
        "multiple_citizenship_id"       =>  $_POST['multi_citizenship'], 
        "permanent_address"             =>  $_POST['street1'], 
        "permanent_cluster"             =>  $_POST['region1']."|".$_POST['province1']."|".$_POST['municipality1']."|".$_POST['barangay1'], 
        "zipcode"                       =>  $_POST['zipcode'], 
        "country"                       =>  $_POST['country'], 
        "date_of_birth"                 =>  $_POST['date_of_birth'], 
        "place_of_birth"                =>  $_POST['place_of_birth'], 
        "course_program"                =>  $_POST['course_year'], 
        "gender"                        =>  $_POST['gender'] == "other" ? $_POST['gender']>"|".$_POST['gender6'] : $_POST['gender'], 
        "civil_status"                  =>  $_POST['civilStatus'] == "other" ? $_POST['civilStatus']>"|".$_POST['civilStatus4'] : $_POST['civilStatus'], 
        "student_tel_contact"           =>  $_POST['tel_no'], 
        "student_mobile_contact"        =>  $_POST['mobile_no'], 
        "student_email"                 =>  $_POST['email_address'], 
        "clsu_address"                  =>  $_POST['street2'], 
        "clsu_cluster"                  =>  $_POST['region2']."|".$_POST['province2']."|".$_POST['municipality2']."|".$_POST['barangay2'], 
        "senior_high_address"           =>  $_POST['street3'], 
        "senior_high_cluster"           =>  $_POST['region3']."|".$_POST['province3']."|".$_POST['municipality3']."|".$_POST['barangay3'],  
        "type_of_school"                =>  $_POST['schoolType'], 
        "high_school_grad_year"         =>  $_POST['highSchoolYearGraduated'], 
        "father_name"                   =>  $_POST['father_name'], 
        "father_age"                    =>  $_POST['father_age'], 
        "father_occupation"             =>  $_POST['father_occupation'], 
        "father_education"              =>  $_POST['father_education'], 
        "mother_name"                   =>  $_POST['mother_name'], 
        "mother_age"                    =>  $_POST['mother_age'], 
        "mother_occupation"             =>  $_POST['mother_occupation'], 
        "mother_education"              =>  $_POST['mother_education'], 
        "birth_order"                   =>  $_POST['birth_order'], 
        "no_brother"                    =>  $_POST['number_of_brother'], 
        "no_sister"                     =>  $_POST['number_of_sister'], 
        "family_income"                 =>  $_POST['familyIncome'], 
        "elementary_school_address"     =>  $_POST['elementary_schoolName'], 
        "elementary_year"               =>  $_POST['elementary_year'], 
        "high_school_address"           =>  $_POST['highSchool_schoolName'], 
        "high_school_year"              =>  $_POST['highSchool_year'], 
        "vocational_school_address"     =>  $_POST['vocational_schoolName'], 
        "vocational_school_year"        =>  $_POST['vocational_year'], 
        "college_school_address"        =>  $_POST['college_schoolName'], 
        "college_school_year"           =>  $_POST['college_year'], 
        "extra_curricular"              =>  $_POST['extra_curricular'], 
        "emergency_person"              =>  $_POST['emergency_person'], 
        "emergency_relationship"        =>  $_POST['emergency_relationship'], 
        "emergency_contact"             =>  $_POST['emergency_contact'], 
        "emergency_address"             =>  $_POST['emergency_address'], 
        "clsu_cat"                      =>  $_POST['admission_test'], 
        "scholarship"                   =>  $_POST['scholarship_name'], 
        "program_id"                    =>  $_POST['intendedProgram'], 
        "activities"                    =>  (isset($_POST['participateActivity'])) ? $this->getArr($_POST['participateActivity']).($_POST['participateActivityOther'] != "" ? "|".$_POST['participateActivityOther'] : "") : "", 
        "indigenous"                    =>  $_POST['indigenous'] == "yes" ? $_POST['indigenous']."|".$_POST['indigenousType'] : $_POST['indigenous'], 
        "first_generation"              =>  $_POST['firstGeneration'], 
        "disability"                    =>  $_POST['disability'], 
        "disability_type"               =>  isset($_POST['disabilityType']) ? $this->getArr($_POST['disabilityType']) : "",
        "family_doctor"                 =>  $_POST['family_doctor'],
        "family_doctor_contact"         =>  $_POST['family_doctor_contact'],
        "senior_high_school_awards"     =>  $_POST['senior_high_school_awards'],
        "father_contact"                =>  $_POST['father_contact'],
        "mother_contact"                =>  $_POST['mother_contact'],
        "father_address"                =>  $_POST['father_address'],
        "mother_address"                =>  $_POST['mother_address'],
        "elem_awards"                   =>  $_POST['elem_awards'],
        "high_school_awards"            =>  $_POST['high_school_awards'],
        "vocational_awads"              =>  $_POST['vocational_awads'],
        "college_awards"                =>  $_POST['college_awards'],
        "guardian_name"                 =>  $_POST['guardian_name'],
        "guardian_age"                  =>  $_POST['guardian_age'],
        "guardian_occupation"           =>  $_POST['guardian_occupation'],
        "guardian_education"            =>  $_POST['guardian_education'],
        "guardian_contact"              =>  $_POST['guardian_contact'],
        "guardian_address"              =>  $_POST['guardian_address'],
        "signatories"                   =>  $this->getArr($_POST['signatories']),
        "four_p"                        =>  $_POST['four_p'],
        "listahanan"                    =>  $_POST['listahanan'],
        "strand"                        =>  $_POST['strand'],
        "parent_marriage_status"        =>  $_POST['parent_marriage_status'],
        "living_with_parent"            =>  $_POST['living_with_parent'] == 'yes' ? $_POST['living_with_parent'] : $_POST['living_with_parent']."|".$_POST['living_with_parent_remarks'],
        "companions_at_home"            =>  (isset($_POST['companions_at_home'])) ? $this->getArr($_POST['companions_at_home']).($_POST['companions_at_home_other'] != "" ? "|".$_POST['companions_at_home_other'] : "") : "",
        "guardian_relationship"         =>  $_POST['guardian_relationship'],
        "guardian_email"                =>  $_POST['guardian_email'],
        "study_habit"                   =>  $_POST['study_habit'],
        "study_habit_hours"             =>  $_POST['study_habit_hours'],
        "current_event"                 =>  (isset($_POST['current_event'])) ? $this->getArr($_POST['current_event']).($_POST['current_event_other'] != "" ? "|".$_POST['current_event_other'] : "") : "",
        "reason_to_enroll"              =>  $_POST['reason_to_enroll'],
        "vision_health"                 =>  $_POST['vision_health'],
        "allergy"                       =>  $_POST['allergy'] == 'yes' ? $_POST['allergy']."|".$_POST['allergy_remarks'] : $_POST['allergy'],
        "medicine_take"                 =>  $_POST['medicine_take'],
        "mental_health"                 =>  $_POST['mental_health'] == 'yes' ? $_POST['mental_health']."|".$_POST['mental_health_remarks'] : $_POST['mental_health'],
        "guidance_councilor"            =>  $_POST['guidance_councilor'],
        "visit_guidance_councilor"      =>  $_POST['visit_guidance_councilor'],
        "guidance_councilor_assistance" =>  $_POST['guidance_councilor_assistance'],
        "working_student"               =>  $_POST['working_student']."|".$_POST['working_student_remarks']
      );

      $confirmationData = array(
        "confirmation_id"     =>  $_POST['applicantID'],
        "program_id"          =>  0,
        "confirmation_status" =>  1,
        "confirmation_date"   =>  $this->get_time()
      );

      if ($this->applicant->save("tbl_enrollment_form", $enrollmentFormData) !== false && $this->applicant->save("tbl_confirmation", $confirmationData) !== false) 
      {
        
        // redirect("https://ctec.clsu2.edu.ph/clsucat/");
        $data = array(
          "confirmationStatus"  =>  "You have accepted the offer",
          "msg"                 =>  "You can now download the OSA Form and Enrollment Form. Go to CTEC Portal and click View Result Button.",
          "link"                =>  "https://ctec.clsu2.edu.ph/clsucat/",
          "homepageBTN" =>  "GO TO CTEC"
        );
        $this->load->view('custom_confirmation/confirmation', $data);
      }else
      {
        $data = array(
          'applicantProgram'  =>  $this->applicantProgram()
        );
    
        $this->load->view('applicants/_header', $data);
        $this->load->view('applicants/_css', $data);
        $this->load->view('applicants/applicant_enrollment_form_view', $data);
        $this->load->view('applicants/_footer', $data);
        $this->load->view('applicants/_js', $data);
      }
    }
  }

  public function checkSuccess()
  {
    $data = array(
      "confirmationStatus"  =>  "Updated Successfully",
      "msg"                 =>  "You can now download the OSA Form and Enrollment Form. Go to CTEC Portal and click View Result Button.",
      "link"                =>  "https://ctec.clsu2.edu.ph/clsucat/",
      "homepageBTN" =>  "GO TO CTEC"
    );
    $this->load->view('custom_confirmation/confirmation', $data);
  }

  public function updateEnrollmentForm()
  {
    if ($_POST['applicantID'] == "")
    {
      redirect("https://ctec.clsu2.edu.ph/clsucat/");
    }
    $config = array(
      array(
              'field' => 'applicantID',
              'label' => 'APPLICANT ID',
              'rules' => 'required'
      ),
      array(
              'field' => 'lastname',
              'label' => 'LASTNAME',
              'rules' => 'required'
      ),
      array(
              'field' => 'firstname',
              'label' => 'FIRSTNAME',
              'rules' => 'required'
      ),
      array(
              'field' => 'middlename',
              'label' => 'MIDDLENAME',
              'rules' => 'required'
      ),
      array(
              'field' => 'age',
              'label' => 'AGE',
              'rules' => 'required'
      ),
      array(
              'field' => 'sex',
              'label' => 'SEX',
              'rules' => 'required'
      ),
      array(
              'field' => 'religion',
              'label' => 'RELIGION',
              'rules' => 'required'
      ),
      array(
              'field' => 'citizenship',
              'label' => 'CITIZENSHIP',
              'rules' => 'required'
      ),
      array(
              'field' => 'street1',
              'label' => 'Permanent Address (House No., Street Name, Building)',
              'rules' => 'required'
      ),
      array(
              'field' => 'date_of_birth',
              'label' => 'DATE OF BIRTH',
              'rules' => 'required'
      ),
      array(
              'field' => 'course_year',
              'label' => 'COURSE & YEAR',
              'rules' => 'required'
      ),
      array(
              'field' => 'gender',
              'label' => 'GENDER',
              'rules' => 'required'
      ),
      array(
              'field' => 'civilStatus',
              'label' => 'CIVIL STATUS',
              'rules' => 'required'
      ),
      array(
              'field' => 'tel_no',
              'label' => 'TELEPHONE NUMBER',
              'rules' => 'required'
      ),
      array(
              'field' => 'mobile_no',
              'label' => 'MOBILE NUMBER',
              'rules' => 'required'
      ),
      array(
              'field' => 'email_address',
              'label' => 'EMAIL ADDRESS',
              'rules' => 'required'
      ),
      array(
              'field' => 'street3',
              'label' => 'Senior High School where Graduated',
              'rules' => 'required'
      ),
      array(
              'field' => 'schoolType',
              'label' => 'Type of School',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_name',
              'label' => 'Name of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_age',
              'label' => 'Age of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_occupation',
              'label' => 'Occupation of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_education',
              'label' => 'Educational Attainment of Father',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_name',
              'label' => 'Name of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_age',
              'label' => 'Age of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_occupation',
              'label' => 'Occupation of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_education',
              'label' => 'Educational Attainment of Mother',
              'rules' => 'required'
      ),
      array(
              'field' => 'birth_order',
              'label' => 'Birth Order in the Family',
              'rules' => 'required'
      ),
      array(
              'field' => 'number_of_brother',
              'label' => 'No. of Brothers',
              'rules' => 'required'
      ),
      array(
              'field' => 'number_of_sister',
              'label' => 'No. of Sisters',
              'rules' => 'required'
      ),
      array(
              'field' => 'familyIncome',
              'label' => 'Annual Family Income',
              'rules' => 'required'
      ),
      array(
              'field' => 'elementary_schoolName',
              'label' => 'Elementary School and Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'elementary_year',
              'label' => 'Elementary Inclusive Years',
              'rules' => 'required'
      ),
      array(
              'field' => 'highSchool_schoolName',
              'label' => 'High School and Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'highSchool_year',
              'label' => 'High School and Address',
              'label' => 'High School Inclusive Years',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_person',
              'label' => 'Name of Person to be notified in case of emergency',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_relationship',
              'label' => 'Relationship',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_contact',
              'label' => 'Emergency Tel. / Cell No',
              'rules' => 'required'
      ),
      array(
              'field' => 'emergency_address',
              'label' => 'Emergency Person Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'indigenous',
              'label' => 'indigenous groups',
              'rules' => 'required'
      ),
      array(
              'field' => 'firstGeneration',
              'label' => 'First Generation College Student',
              'rules' => 'required'
      ),
      array(
              'field' => 'disability',
              'label' => 'disability',
              'rules' => 'required'
      ),
      array(
              'field' => 'zipcode',
              'label' => 'Postal/Zip Code',
              'rules' => 'required'
      ),
      array(
              'field' => 'country',
              'label' => 'Country',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_contact',
              'label' => 'Father Contact',
              'rules' => 'required'
      ),
      array(
              'field' => 'father_address',
              'label' => 'Father Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_contact',
              'label' => 'Mother Contact',
              'rules' => 'required'
      ),
      array(
              'field' => 'mother_address',
              'label' => 'Mother Address',
              'rules' => 'required'
      ),
      array(
              'field' => 'region1',
              'label' => 'Permanent Address (Region)',
              'rules' => 'required'
      ),
      array(
              'field' => 'province1',
              'label' => 'Permanent Address (Province)',
              'rules' => 'required'
      ),
      array(
              'field' => 'municipality1',
              'label' => 'Permanent Address (Municipality)',
              'rules' => 'required'
      ),
      array(
              'field' => 'barangay1',
              'label' => 'Permanent Address (Barangay)',
              'rules' => 'required'
      ),
      array(
              'field' => 'region3',
              'label' => 'Senior High School where Graduated (Region)',
              'rules' => 'required'
      ),
      array(
              'field' => 'province3',
              'label' => 'Senior High School where Graduated (Province)',
              'rules' => 'required'
      ),
      array(
              'field' => 'municipality3',
              'label' => 'Senior High School where Graduated (Municipality)',
              'rules' => 'required'
      ),
      array(
              'field' => 'barangay3',
              'label' => 'Senior High School where Graduated (Barangay)',
              'rules' => 'required'
      ),
      array(
              'field' => 'signatories',
              'label' => 'Signatories',
              'rules' => (isset($_POST['signatories'])) ? "" : "required"
      ),
      array(
              'field' => 'four_p',
              'label' => '4P\'s',
              'rules' => 'required'
      ),
      array(
              'field' => 'listahanan',
              'label' => 'Listahanan',
              'rules' => 'required'
      ),
      array(
              'field' => 'strand',
              'label' => 'Strand',
              'rules' => 'required'
      ),
      array(
              'field' => 'parent_marriage_status',
              'label' => 'Parents marriage status',
              'rules' => 'required'
      ),
      array(
              'field' => 'living_with_parent',
              'label' => 'Living with your parents',
              'rules' => 'required' 
      ),
      array(
              'field' => 'living_with_parent_remarks',
              'label' => 'Reason why your not Living with your parents',
              'rules' => (isset($_POST['living_with_parent'])) ? $_POST['living_with_parent'] == "no" ? 'required' : '' : ''
      ),
      array(
              'field' => 'companions_at_home',
              'label' => 'Companions at home',
              'rules' => (isset($_POST['companions_at_home'])) ? "" : "required"
      ),
      array(
              'field' =>  'working_student',
              'label' =>  'Part-time working student',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'working_student_remarks',
              'label' =>  'Part-time working student',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guardian_relationship',
              'label' =>  'Relationship to your guardian',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guardian_email',
              'label' =>  'Email Address of your Guardian',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'study_habit',
              'label' =>  'Study habit',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'current_event',
              'label' =>  'Current events?',
              'rules' => (isset($_POST['current_event'])) ? "" : "required"
      ),
      array(
              'field' =>  'reason_to_enroll',
              'label' =>  'Why did you enroll in CLSU',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'allergy',
              'label' =>  'Allergy',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'medicine_take',
              'label' =>  'Medicine for maintenance of health condition',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'mental_health',
              'label' =>  'Existing mental health condition',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guidance_councilor',
              'label' =>  'Guidance counselor for assistance',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'visit_guidance_councilor',
              'label' =>  'Plan to visit your guidance counselor',
              'rules' =>  'required'
      ),
      array(
              'field' =>  'guidance_councilor_assistance',
              'label' =>  'Guidance counselor assistance',
              'rules' =>  'required'
      )
    );

    $this->form_validation->set_rules($config);

    if ($this->form_validation->run() == FALSE)
    {

      $data = array(
        'applicantProgram'  =>  $this->applicantProgram()
      );
  
      $this->load->view('applicants/_header', $data);
      $this->load->view('applicants/_css', $data);
      $this->load->view('applicants/update_applicant_enrollment_form_view', $data);
      $this->load->view('applicants/_footer', $data);
      $this->load->view('applicants/_js', $data);
    }
    else
    {
      $enrollmentFormData = array(
        "applicant_id"                  =>  $_POST['applicantID'], 
        "lastname"                      =>  $_POST['lastname'], 
        "firstname"                     =>  $_POST['firstname'], 
        "middlename"                    =>  $_POST['middlename'], 
        "age"                           =>  $_POST['age'], 
        "sex"                           =>  $_POST['sex'], 
        "religion_id"                   =>  $_POST['religion'], 
        "citizenship_id"                =>  $_POST['citizenship'], 
        "multiple_citizenship_id"       =>  $_POST['multi_citizenship'], 
        "permanent_address"             =>  $_POST['street1'], 
        "permanent_cluster"             =>  $_POST['region1']."|".$_POST['province1']."|".$_POST['municipality1']."|".$_POST['barangay1'], 
        "zipcode"                       =>  $_POST['zipcode'], 
        "country"                       =>  $_POST['country'], 
        "date_of_birth"                 =>  $_POST['date_of_birth'], 
        "place_of_birth"                =>  $_POST['place_of_birth'], 
        "course_program"                =>  $_POST['course_year'], 
        "gender"                        =>  $_POST['gender'] == "other" ? $_POST['gender']>"|".$_POST['gender6'] : $_POST['gender'], 
        "civil_status"                  =>  $_POST['civilStatus'] == "other" ? $_POST['civilStatus']>"|".$_POST['civilStatus4'] : $_POST['civilStatus'], 
        "student_tel_contact"           =>  $_POST['tel_no'], 
        "student_mobile_contact"        =>  $_POST['mobile_no'], 
        "student_email"                 =>  $_POST['email_address'], 
        "clsu_address"                  =>  $_POST['street2'], 
        "clsu_cluster"                  =>  $_POST['region2']."|".$_POST['province2']."|".$_POST['municipality2']."|".$_POST['barangay2'], 
        "senior_high_address"           =>  $_POST['street3'], 
        "senior_high_cluster"           =>  $_POST['region3']."|".$_POST['province3']."|".$_POST['municipality3']."|".$_POST['barangay3'],  
        "type_of_school"                =>  $_POST['schoolType'], 
        "high_school_grad_year"         =>  $_POST['highSchoolYearGraduated'], 
        "father_name"                   =>  $_POST['father_name'], 
        "father_age"                    =>  $_POST['father_age'], 
        "father_occupation"             =>  $_POST['father_occupation'], 
        "father_education"              =>  $_POST['father_education'], 
        "mother_name"                   =>  $_POST['mother_name'], 
        "mother_age"                    =>  $_POST['mother_age'], 
        "mother_occupation"             =>  $_POST['mother_occupation'], 
        "mother_education"              =>  $_POST['mother_education'], 
        "birth_order"                   =>  $_POST['birth_order'], 
        "no_brother"                    =>  $_POST['number_of_brother'], 
        "no_sister"                     =>  $_POST['number_of_sister'], 
        "family_income"                 =>  $_POST['familyIncome'], 
        "elementary_school_address"     =>  $_POST['elementary_schoolName'], 
        "elementary_year"               =>  $_POST['elementary_year'], 
        "high_school_address"           =>  $_POST['highSchool_schoolName'], 
        "high_school_year"              =>  $_POST['highSchool_year'], 
        "vocational_school_address"     =>  $_POST['vocational_schoolName'], 
        "vocational_school_year"        =>  $_POST['vocational_year'], 
        "college_school_address"        =>  $_POST['college_schoolName'], 
        "college_school_year"           =>  $_POST['college_year'], 
        "extra_curricular"              =>  $_POST['extra_curricular'], 
        "emergency_person"              =>  $_POST['emergency_person'], 
        "emergency_relationship"        =>  $_POST['emergency_relationship'], 
        "emergency_contact"             =>  $_POST['emergency_contact'], 
        "emergency_address"             =>  $_POST['emergency_address'], 
        "clsu_cat"                      =>  $_POST['admission_test'], 
        "scholarship"                   =>  $_POST['scholarship_name'], 
        "program_id"                    =>  $_POST['intendedProgram'], 
        "activities"                    =>  (isset($_POST['participateActivity'])) ? $this->getArr($_POST['participateActivity']).($_POST['participateActivityOther'] != "" ? "|".$_POST['participateActivityOther'] : "") : "", 
        "indigenous"                    =>  $_POST['indigenous'] == "yes" ? $_POST['indigenous']."|".$_POST['indigenousType'] : $_POST['indigenous'], 
        "first_generation"              =>  $_POST['firstGeneration'], 
        "disability"                    =>  $_POST['disability'], 
        "disability_type"               =>  isset($_POST['disabilityType']) ? $this->getArr($_POST['disabilityType']) : "",
        "family_doctor"                 =>  $_POST['family_doctor'],
        "family_doctor_contact"         =>  $_POST['family_doctor_contact'],
        "senior_high_school_awards"     =>  $_POST['senior_high_school_awards'],
        "father_contact"                =>  $_POST['father_contact'],
        "mother_contact"                =>  $_POST['mother_contact'],
        "father_address"                =>  $_POST['father_address'],
        "mother_address"                =>  $_POST['mother_address'],
        "elem_awards"                   =>  $_POST['elem_awards'],
        "high_school_awards"            =>  $_POST['high_school_awards'],
        "vocational_awads"              =>  $_POST['vocational_awads'],
        "college_awards"                =>  $_POST['college_awards'],
        "guardian_name"                 =>  $_POST['guardian_name'],
        "guardian_age"                  =>  $_POST['guardian_age'],
        "guardian_occupation"           =>  $_POST['guardian_occupation'],
        "guardian_education"            =>  $_POST['guardian_education'],
        "guardian_contact"              =>  $_POST['guardian_contact'],
        "guardian_address"              =>  $_POST['guardian_address'],
        "signatories"                   =>  $this->getArr($_POST['signatories']),
        "four_p"                        =>  $_POST['four_p'],
        "listahanan"                    =>  $_POST['listahanan'],
        "strand"                        =>  $_POST['strand'],
        "parent_marriage_status"        =>  $_POST['parent_marriage_status'],
        "living_with_parent"            =>  $_POST['living_with_parent'] == 'yes' ? $_POST['living_with_parent'] : $_POST['living_with_parent']."|".$_POST['living_with_parent_remarks'],
        "companions_at_home"            =>  (isset($_POST['companions_at_home'])) ? $this->getArr($_POST['companions_at_home']).($_POST['companions_at_home_other'] != "" ? "|".$_POST['companions_at_home_other'] : "") : "",
        "guardian_relationship"         =>  $_POST['guardian_relationship'],
        "guardian_email"                =>  $_POST['guardian_email'],
        "study_habit"                   =>  $_POST['study_habit'],
        "study_habit_hours"             =>  $_POST['study_habit_hours'],
        "current_event"                 =>  (isset($_POST['current_event'])) ? $this->getArr($_POST['current_event']).($_POST['current_event_other'] != "" ? "|".$_POST['current_event_other'] : "") : "",
        "reason_to_enroll"              =>  $_POST['reason_to_enroll'],
        "vision_health"                 =>  $_POST['vision_health'],
        "allergy"                       =>  $_POST['allergy'] == 'yes' ? $_POST['allergy']."|".$_POST['allergy_remarks'] : $_POST['allergy'],
        "medicine_take"                 =>  $_POST['medicine_take'],
        "mental_health"                 =>  $_POST['mental_health'] == 'yes' ? $_POST['mental_health']."|".$_POST['mental_health_remarks'] : $_POST['mental_health'],
        "guidance_councilor"            =>  $_POST['guidance_councilor'],
        "visit_guidance_councilor"      =>  $_POST['visit_guidance_councilor'],
        "guidance_councilor_assistance" =>  $_POST['guidance_councilor_assistance'],
        "working_student"               =>  $_POST['working_student']."|".$_POST['working_student_remarks']
      );

      $con = array(
        "applicant_id"  =>  $_POST['applicantID']
      );

      if ($this->applicant->updateForm($enrollmentFormData, $con, array("tbl_enrollment_form")) !== false) 
      {
        $data = array(
          "confirmationStatus"  =>  "Updated Successfully",
          "msg"                 =>  "You can now download the OSA Form and Enrollment Form. Go to CTEC Portal and click View Result Button.",
          "link"                =>  "https://ctec.clsu2.edu.ph/clsucat/",
          "homepageBTN" =>  "GO TO CTEC"
        );
        $this->load->view('custom_confirmation/confirmation', $data);
      }else
      {
        $data = array(
          'applicantProgram'  =>  $this->applicantProgram()
        );
    
        $this->load->view('applicants/_header', $data);
        $this->load->view('applicants/_css', $data);
        $this->load->view('applicants/update_applicant_enrollment_form_view', $data);
        $this->load->view('applicants/_footer', $data);
        $this->load->view('applicants/_js', $data);
      }
    }
  }

  public function getArr($arr = array())
  {
    $arrData = array();
    $delimetedData = "";
    for ($i=0; $i < count($arr); $i++) 
    { 
      if ($arr[$i] != "")
      {
        array_push($arrData, $arr[$i]);
      }
    }

    for ($i=0; $i < count($arrData); $i++) 
    { 
      $delimetedData .= $arrData[$i];
      if ($i < (count($arrData) - 1))
      {
        $delimetedData .= "||";
      }
    }

    return $delimetedData;
  }

  public function donwloadOSAForm($appID = "", $securityCode = "")
  {

    $simple_string = $appID;
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $encryption = openssl_encrypt($simple_string, $ciphering,$encryption_key, $options, $encryption_iv);
    $decryption_iv = '1234567891011121';
    $decryption_key = "c3ntr411uz0n5t4t3un1v3rs1ty";
    $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

    if (urlencode($encryption)  == $securityCode)
    {
      // ini_set('memory_limit', '-1');
      // ini_set('max_execution_time', 0);
      $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $mpdf = new \Mpdf\Mpdf([
        'mode'          =>  'utf-8',
        'format'        =>  "Legal", //in cm
        'orientation'   =>  'P',
        'margin_top'    =>  '6',
        'margin_left'   =>  '6',
        'margin_right'  =>  '6',
        'margin_bottom' =>  '20',
        'fontDir'       =>  array_merge($fontDirs, [
                                'custom/font/directory',
                            ]),
        'fontdata'      => $fontData + [
                            'roboto' => [
                              'R' => 'Roboto-Regular.ttf'
                            ]
                          ],
        'default_font'  => 'roboto'
      ]
      );

      $mpdf->showWatermarkImage = true;
      $mpdf->use_kwt = true;

      $stylesheet = "
        .right {
            float: right;
            width: 40%;
            margin-right: 60px;
        }

        .left {
            float: left;
            width: 45%;
        }

        .right1 {
            float: right;
          width: 60%;
        }

        .left1 {
            float: left;
            width: 40%;
        }

        .custom-thumbnail
        {
          border: 1px solid #000;
          border-radius: 60px;
          height: 2in;
          width: 2in;
        }
      ";

      $applicant_id = $appID;
      $ctr = 1;
      $applicant_info = $this->applicant->get_applicant_info($applicant_id);
      $test = '';
      foreach ($applicant_info as $applicant) 
      {
        $html = '';
        $program = '';
        $college = '';
        $department = '';
        $clsu2_email = '';

        $college_vocational = "";
        // '.$applicant->vocational_school_address.','.$applicant->vocational_school_year.','.$applicant->vocational_awads.'|'.$applicant->college_school_address.','.$applicant->college_school_year.','.$applicant->college_awards.'
        if ($applicant->vocational_school_address != "")
        {
          $college_vocational .= $applicant->vocational_school_address;
        }

        if ($applicant->vocational_school_address != "")
        {
          $college_vocational .= ",".$applicant->vocational_school_year;
        }

        if ($applicant->vocational_awads != "")
        {
          $college_vocational .= ",".$applicant->vocational_awads;
        }

        if ($applicant->college_school_address != "")
        {
          $college_vocational .= "|".$applicant->college_school_address;
        }

        if ($applicant->college_school_year != "")
        {
          $college_vocational .= ",".$applicant->college_school_year;
        }

        if ($applicant->college_awards != "")
        {
          $college_vocational .= ",".$applicant->college_awards;
        }

        $student_info = $this->applicant->get_student_info($applicant_id);
        foreach ($student_info as $student) 
        {
          $program = $student->program_name;
          $college = $student->college_desc;
          $clsu2_email = $student->student_email;
        }
        
        /*Header*/
        $html .=  '
          <table border="" style="text-align: center; margin: 0 auto;">
            <tr>
              <td rowspan="5">
                <img src="'.base_url('assets/images/logo.bmp').'" width="100"/>
              </td>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                    Republic of the Philippines
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 18px; font-weight: bold;">
                  CENTRAL LUZON STATE UNIVERSITY
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  Science City of Muñoz, Nueva Ecija
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 30px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px; font-weight: bold;">
                  OFFICE OF STUDENT AFFAIRS
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px; font-weight: regular;">
                  Guidance Service Unit
                </p>
              </td>
            </tr>
            <tr>
            <td style="padding-top: 30px;">
              
            </td>
            <td style="padding-top: 30px;">
              <p style="text-align: center; font-family: roboto; font-size: 15px; font-weight: bold;">
                INDIVIDUAL RECORD FORM
              </p>
            </td>
            </tr>
          </table>
        ';

        /*Sub header*/
        $html .=  '
          <h4 style="margin-top: 20px;">PERSONAL INFORMATION</h4>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 20px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Name:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 500px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->lname.', '.$applicant->fname.' '.$applicant->mname.'
                </p>
              </td>
              <td style="width: 20px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Age:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 30px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->age.'
                </p>
              </td>
              <td style="width: 20px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Sex:</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->sex == "M" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Male
                  <span style="font-size: 8px;'.($applicant->sex == "F" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Female
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="margin-top: 2px; width: 100%;">
            <tr>
              <td style="width: 160px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">House Number/Street:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 150px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->permanent_address.'
                </p>
              </td>
              <td style="width: 160px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Barangay/Subdivision/Village:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.(explode("|", $applicant->permanent_cluster)[3]).'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">City/Municipality:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 190px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.(explode("|", $applicant->permanent_cluster)[2]).'
                </p>
              </td>
              <td style="width: 70px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Province:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.(explode("|", $applicant->permanent_cluster)[1]).'
                </p>
              </td>
              <td style="width: 50px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Region:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.(explode("|", $applicant->permanent_cluster)[0]).'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 110px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">CLSU Address:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->clsu_address.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 95px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Date of Birth:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 160px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.date("F d, Y", strtotime($applicant->date_of_birth)).'
                </p>
              </td>
              <td style="width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Place of Birth:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->place_of_birth.'
                </p>
              </td>
              <td style="width: 80px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Year Level:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$this->calculateYearLevel(date("y"), $applicant->applicant_id)." Year".'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 20px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Gender:</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->gender == "straight" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Straight
                  <span style="font-size: 8px;'.($applicant->gender == "lesbian" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Lesbian
                  <span style="font-size: 8px;'.($applicant->gender == "gay" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Gay
                  <span style="font-size: 8px;'.($applicant->gender == "bisexual" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Bisexual
                  <span style="font-size: 8px;'.($applicant->gender == "transgender" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Transgender
                  <span style="font-size: 8px;'.($applicant->gender == "queer" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Queer
                  <span style="font-size: 8px;'.($applicant->gender == "prefer not to say" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Prefer not to say
                  <span style="font-size: 8px;'.(explode("|", $applicant->gender)[0] == "other" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Others: '.(explode("|", $applicant->gender)[0] == "other" ? explode("|", $applicant->gender)[1] : "").'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 90px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Civil Status:</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->civil_status == "single" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Single
                  <span style="font-size: 8px;'.($applicant->civil_status == "married" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Married
                  <span style="font-size: 8px;'.($applicant->civil_status == "single-parent" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Single-Parent
                  <span style="font-size: 8px;'.(explode("|", $applicant->civil_status)[0] == "other" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Others, Please specify: '.(explode("|", $applicant->civil_status)[0] == "other" ? explode("|", $applicant->civil_status)[1] : "").'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 110px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Telephone No.:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$applicant->student_tel_contact.'
                </p>
              </td>
              <td style="width: 115px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Mobile Number:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$applicant->student_mobile_contact.'
                </p>
              </td>
              <td style="width: 110px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">E-Mail Address:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$clsu2_email.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">College Affiliation:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$college.'
                </p>
              </td>
              <td style="width: 110px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Degree Program Enrolled in:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$program.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 260px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Senior High School where Graduated:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                '.$applicant->senior_high_address.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 260px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Strand enrolled in Senior High School:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                '.$applicant->strand.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 120px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">School Address:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                '.(explode("|", $applicant->senior_high_cluster)[3]).' ,'.(explode("|", $applicant->senior_high_cluster)[2]).'  ,'.(explode("|", $applicant->senior_high_cluster)[1]).'  ,'.(explode("|", $applicant->senior_high_cluster)[0]).' 
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 120px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Type of School:</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->type_of_school == "public" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Public
                  <span style="font-size: 8px;'.($applicant->type_of_school == "private" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Private
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 400px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Are you the First-Generation college student in the family? <i>(first to enter college among immediate family members)</i></p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->first_generation == "yes" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 8px;'.($applicant->first_generation == "no" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No
                </p>
              </td>
            </tr>
          </table>

          <h4 style="margin-top: 20px;">FAMILY BACKGROUND</h4>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 120px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Name of Father:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 500px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->father_name.'
                </p>
              </td>
              <td style="width: 10px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Age:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->father_age.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 90px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Occupation:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->father_occupation.'
                </p>
              </td>
              <td style="width: 170px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Educational Attainment:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->father_education.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 120px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Name of Mother:</p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 500px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->mother_name.'
                </p>
              </td>
              <td style="width: 10px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Age:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->mother_age.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 90px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Occupation:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->mother_occupation.'
                </p>
              </td>
              <td style="width: 170px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Educational Attainment:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->mother_education.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 150px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Marriage Status of Parents:</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->parent_marriage_status == "Living Together" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Living Together
                  <span style="font-size: 8px;'.($applicant->parent_marriage_status == "Separated because of work" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Separated because of work
                  <span style="font-size: 8px;'.($applicant->parent_marriage_status == "Separated due to conflict" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Separated due to conflict
                  <span style="font-size: 8px;'.($applicant->parent_marriage_status == "Widowed/widower" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Widowed/widower
                  <span style="font-size: 8px;'.($applicant->parent_marriage_status == "Single Parent" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Single Parent
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 170px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Birth Order in the Family:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.($applicant->birth_order == 0 ? 1 : $applicant->birth_order).'
                </p>
              </td>
              <td style="width: 115px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">No. of Brothers:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$applicant->no_brother.'
                </p>
              </td>
              <td style="width: 110px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">No. of Sisters:</p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 12px;">
                  '.$applicant->no_sister.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 220px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Are you living with your parents?</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 8px;'.($applicant->living_with_parent == "yes" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 8px;'.(explode("|", $applicant->living_with_parent)[0] == "no" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No, if "No", Why? '.(explode("|", $applicant->living_with_parent)[0] == "no" ? explode("|", $applicant->living_with_parent)[1] : "").'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 270px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Who are your companions at home?</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">';

                $companions = array("Siblings", "Stepfather", "Stepmother", "Step Sisters/ Step Brothers", "Grandparents", "Relatives", "Other");
                $isCompanion = false;
                $isOther = "";
                
                for ($x=0; $x < count($companions); $x++) 
                { 
                  for ($i=0; $i < count(explode("||", $applicant->companions_at_home)); $i++) 
                  { 
                    if (explode("|", explode("||", $applicant->companions_at_home)[$i])[0] == "Other" && $companions[$x] == "Other")
                    {
                      $isOther = explode("|", explode("||", $applicant->companions_at_home)[$i])[1];
                      $isCompanion = true;
                      break;
                    }else
                    {
                      if (explode("||", $applicant->companions_at_home)[$i] == $companions[$x])
                      {
                        $isCompanion = true;
                        break;
                      }
                    }
                    
                  }

                  if ($isCompanion === true)
                  {
                    $html .= '
                          <span style="font-size: 8px; border: 1px solid #000; background-color: #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$companions[$x].' '.($isOther != "" ? "(Please Specify: ".$isOther.")" : "").'
                    ';
                  }else
                  {
                    $html .= '
                          <span style="font-size: 8px; border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$companions[$x].'
                    ';
                  }


                  $isCompanion = false;
                }
            $html .= '
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;"> 
            <tr>
              <td style="width: 270px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Annual Family Income: (Please check)</p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  <span style="font-size: 10px; border: 1px solid #000;'.($applicant->family_income == "below Php 10,000" ? "background-color: #000;" : "background-color: #fff;").'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> below Php 10,000 &nbsp;&nbsp;
                  <span style="font-size: 10px; border: 1px solid #000;'.($applicant->family_income == "15,001- Php 30,000" ? "background-color: #000;" : "background-color: #fff;").'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Php15,001- Php 30,000 &nbsp;&nbsp;
                  <span style="font-size: 10px; border: 1px solid #000;'.($applicant->family_income == "Php 45,001 and above" ? "background-color: #000;" : "background-color: #fff;").'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Php 45,001 and above &nbsp;&nbsp;
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  <span style="font-size: 10px; border: 1px solid #000;'.($applicant->family_income == "Php 10,001- Php 15,000" ? "background-color: #000;" : "background-color: #fff;").'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Php 10,001- Php 15,000 &nbsp;&nbsp;
                  <span style="font-size: 10px; border: 1px solid #000;'.($applicant->family_income == "Php 30,001- Php 45,000" ? "background-color: #000;" : "background-color: #fff;").'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Php 30,001- Php 45,000 &nbsp;&nbsp;
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 320px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Are you currently a part-time working student?</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 8px;'.(explode("|", $applicant->working_student)[0] == "yes" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 8px;'.(explode("|", $applicant->working_student)[0] == "no" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No ,If "Yes", kindly indicate the name of the Company and Address (If "NO", write "N/A"): '.explode("|", $applicant->working_student)[1].'
                </p>
              </td>
            </tr>
          </table>

          <h4 style="margin-top: 20px;">EDUCATIONAL BACKGROUND</h4>
          <table border="" style="width: 100%;">
            <tr>
              <td>
              </td>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  School and Address
                </p>
              </td>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  Inclusive Years
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  Elementary
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->elementary_school_address.'
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->elementary_year.'
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  Senior High School
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->senior_high_address.'
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->high_school_grad_year.'
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  Vocational
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->vocational_school_address.'
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->vocational_school_year.'
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  College
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->college_school_address.'
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->college_school_year.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 330px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Co and Extra curricular Activities in High School: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->extra_curricular.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 360px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Name of Person to be notified in case of emergency: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->emergency_person.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 70px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Relationship: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.strtoupper($applicant->emergency_relationship).'
                </p>
              </td>
              <td style="width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Tel. / Cell No.: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->emergency_contact.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Address: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.strtoupper($applicant->emergency_address).'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 250px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Name of Scholarship (if there\'s any): </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.strtoupper($applicant->scholarship).'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 270px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">What activities do you want to participate in? (Please check)</p>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">';

                $companions = array("Sports and Activities", "Dancing", "Oration/Declamation/Debate", "Campus Journalism", "Singing", "Campus Musical Band", "Campus Politics", "Campus Politics", "Acting", "Campus Youth Ministry", "Drawing/Painting", "Photography", "Other");
                $isCompanion = false;
                $isOther = "";
                
                for ($x=0; $x < count($companions); $x++) 
                { 
                  for ($i=0; $i < count(explode("||", $applicant->activities)); $i++) 
                  { 
                    if (explode("|", explode("||", $applicant->activities)[$i])[0] == "Other" && $companions[$x] == "Other")
                    {
                      $isOther = explode("|", explode("||", $applicant->activities)[$i])[1];
                      $isCompanion = true;
                      break;
                    }else
                    {
                      if (explode("||", $applicant->activities)[$i] == $companions[$x])
                      {
                        $isCompanion = true;
                        break;
                      }
                    }
                    
                  }

                  if ($isCompanion === true)
                  {
                    $html .= '
                          <span style="font-size: 12px; border: 1px solid #000; background-color: #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$companions[$x].' '.($isOther != "" ? "(Please Specify: ".$isOther.")" : "").'
                    ';
                  }else
                  {
                    $html .= '
                          <span style="font-size: 12px; border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$companions[$x].'
                    ';
                  }


                  $isCompanion = false;
                }
                $html .= '
                </p>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td style="width: 190px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Do you have a study habit?: </p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 300px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.strtoupper($applicant->study_habit).'
                </p>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td style="width: 190px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">How many hours in a day do you study?: </p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 300px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.strtoupper($applicant->study_habit_hours).'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 270px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">How do you update yourself with the current events?</p>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">';

                $companions = array("Televsion", "Radio", "Newspaper", "Magazines", "Singing", "Other");
                $isCompanion = false;
                $isOther = "";
                
                for ($x=0; $x < count($companions); $x++) 
                { 
                  for ($i=0; $i < count(explode("||", $applicant->current_event)); $i++) 
                  { 
                    if (explode("|", explode("||", $applicant->current_event)[$i])[0] == "Other" && $companions[$x] == "Other")
                    {
                      $isOther = explode("|", explode("||", $applicant->current_event)[$i])[1];
                      $isCompanion = true;
                      break;
                    }else
                    {
                      if (explode("||", $applicant->current_event)[$i] == $companions[$x])
                      {
                        $isCompanion = true;
                        break;
                      }
                    }
                    
                  }

                  if ($isCompanion === true)
                  {
                    $html .= '
                          <span style="font-size: 12px; border: 1px solid #000; background-color: #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$companions[$x].' '.($isOther != "" ? "(Please Specify: ".$isOther.")" : "").'
                    ';
                  }else
                  {
                    $html .= '
                          <span style="font-size: 12px; border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '.$companions[$x].'
                    ';
                  }


                  $isCompanion = false;
                }
                $html .= '
                </p>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td style="width: 190px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Why did you enroll in CLSU: </p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 300px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.strtoupper($applicant->reason_to_enroll).'
                </p>
              </td>
            </tr>
          </table>
          <table>
            <tr>
              <td style="width: 100px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Health Status: </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 250px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Are you a person with disability?</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  <span style="font-size: 10px;'.($applicant->disability == "yes" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 10px;'.($applicant->disability == "no" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 170px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">If Yes, Please Specify:</p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;"></td>
              <td>
              <table style="font-family: roboto; font-size: 15px; font-weight: regular;">
                <tr>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Total Visual Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Total Visual Disability
                  </td>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Partial Visual Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Partial Visual Disability
                  </td>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Communication Disability (Hearing Impairment)" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Communication Disability (Hearing Impairment)
                  </td>
                </tr>
              </table>
              <table style="font-family: roboto; font-size: 15px; font-weight: regular;">
                <tr>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Communication Disability (Speech)" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Communication Disability (Speech)
                  </td>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Orthopedic Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Orthopedic Disability
                  </td>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Intellectual Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Intellectual Disability
                  </td>
                </tr>
              </table>
              <table style="font-family: roboto; font-size: 15px; font-weight: regular;">
                <tr>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Learning Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Learning Disability
                  </td>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Mental Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Mental Disability
                  </td>
                  <td>
                    <span style="font-size: 10px;'.($applicant->disability_type == "Psychosocial Disability" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Psychosocial Disability
                  </td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 150px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Do you have allegies?</p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;"></td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 10px;'.((count(explode("|", $applicant->allergy)) > 0 ? (explode("|", $applicant->allergy)[0] == "yes" ? "background-color: #000;" : "background-color: #fff;") : ($applicant->disability == "yes" ? "background-color: #000;" : "background-color: #fff;"))).' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 10px;'.((count(explode("|", $applicant->allergy)) > 0 ? (explode("|", $applicant->allergy)[0] == "no" ? "background-color: #000;" : "background-color: #fff;") : ($applicant->disability == "yes" ? "background-color: #000;" : "background-color: #fff;"))).' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No, if "YES", please specify: '.(count(explode("|", $applicant->allergy)) > 0 ? explode("|", $applicant->allergy)[1] : "").'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 350px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Do you have an existing mental health condition?</p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;"></td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 10px;'.((count(explode("|", $applicant->mental_health)) > 0 ? (explode("|", $applicant->mental_health)[0] == "yes" ? "background-color: #000;" : "background-color: #fff;") : ($applicant->disability == "yes" ? "background-color: #000;" : "background-color: #fff;"))).' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 10px;'.((count(explode("|", $applicant->mental_health)) > 0 ? (explode("|", $applicant->mental_health)[0] == "no" ? "background-color: #000;" : "background-color: #fff;") : ($applicant->disability == "yes" ? "background-color: #000;" : "background-color: #fff;"))).' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No, if "YES", please specify: '.(count(explode("|", $applicant->mental_health)) > 0 ? explode("|", $applicant->mental_health)[1] : "").'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 170px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Name of Family Doctor: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->family_doctor.'
                </p>
              </td>
              <td style="width: 120px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Contact Number: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->family_doctor_contact.'
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 410px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Do you want to see your guidance counselor for assistance?</p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 10px;'.($applicant->guidance_councilor == "yes" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 10px;'.($applicant->guidance_councilor == "no" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 410px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">When do you plan to visit your guidance counselor?</p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;"></td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 10px;'.($applicant->visit_guidance_councilor == "The guidance counselor will send me an invitation during our free time" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> The guidance counselor will send me an invitation during our free time
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;"></td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 10px;'.($applicant->visit_guidance_councilor == "My college guidance coordinator will refer me to consult our guidance counselor" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> The My college guidance coordinator will refer me to consult our guidance counselor
                </p>
              </td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td style="width: 70px;"></td>
              <td>
                <p style="font-family: roboto; font-size: 15px; font-weight: regular;">
                  <span style="font-size: 10px;'.($applicant->visit_guidance_councilor == "I will come voluntary to consult our guidance counselor" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> I will come voluntary to consult our guidance counselor
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%;">
            <tr>
              <td style="width: 390px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">How do you want to be assisted by a guidance counselor? </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.$applicant->guidance_councilor_assistance.'
                </p>
              </td>
            </tr>
          </table>
          <table border="" style="width: 100%; margin-top: 100px;">
            <tr>
              <td style="width: 10px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Signature: </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                '.$applicant->fname.', '.$applicant->mname.' '.$applicant->lname.'
                </p>
              </td>
              <td style="width: 200px;"></td>
              <td style="width: 10px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">Date: </p>
              </td>
              <td style="border-bottom: 1px solid #000; width: 150px;">
                <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  '.date("F d, Y", strtotime($applicant->confirmation_date)).'
                </p>
              </td>
            </tr>
          </table>
        ';

        $mpdf->SetHTMLFooter('<p style="font-size: 10px; font-style: italic;">ACA.OSA.GSU.F.001 (Revision No. 2; March 9, 2020)</p>');


        $ctr++;
        if ($ctr < count($applicant_info)) 
        {
          
        }
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html, 2);
      }

      ob_clean();
      header('Content-type: application/pdf');
      header('Content-Disposition: inline; filename="enrollment_form.pdf"');
      header('Content-Transfer-Encoding: binary');
      header('Accept-Ranges: bytes');
      $mpdf->Output($applicant_id.".pdf", \Mpdf\Output\Destination::DOWNLOAD);
      // $mpdf->Output($applicant_id.".pdf", "I");
      ob_end_flush();
    }else
    {
      $data = array(
        "code"  =>  "401",
        "msg"   =>  "Unauthorized Access",
        "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/",
        "homepageBTN" =>  "GO TO CTEC"
      );
      $this->load->view('err/custom_error', $data);
    }
  }

  public function calculateYearLevel($year = 0, $studentID = "")
  {
    $studentPrefix = explode("-", $studentID)[0];
    $yearLevel = "";
    switch ($studentPrefix - intval(date("y"))) 
    {
      case 0:
      $yearLevel = "1<sup>st</sup>";
      break;

      case 1:
        $yearLevel = "2<sup>nd</sup>";
        break;
  
      case 2:
        $yearLevel = "3<sup>rd</sup>";
        break;
  
      case 3:
        $yearLevel = "4<sup>th</sup>";
        break;
  
      case 4:
        $yearLevel = "5<sup>th</sup>";
        break;

      case 5:
        $yearLevel = "6<sup>th</sup>";
        break;

      case 6:
        $yearLevel = "7<sup>th</sup>";
        break;
            
      default:
        $yearLevel = "";
        break;
    }

    return $yearLevel;
  }

  public function donwloadEnrollmentForm($appID)
  {
    // ini_set('memory_limit', '-1');
    // ini_set('max_execution_time', 0);
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
      'mode'          =>  'utf-8',
      'format'        =>  [215.9, 330.2], //in cm
      'orientation'   =>  'P',
      'margin_top'    =>  '6',
      'margin_left'   =>  '6',
      'margin_right'  =>  '6',
      'margin_bottom' =>  '0',
      'fontDir'       =>  array_merge($fontDirs, [
                              'custom/font/directory',
                          ]),
      'fontdata'      => $fontData + [
                          'roboto' => [
                            'R' => 'Roboto-Regular.ttf'
                          ]
                        ],
      'default_font'  => 'roboto'
     ]
    );

    $mpdf->showWatermarkImage = true;
    $mpdf->use_kwt = true;

    $stylesheet = "
      .right {
          float: right;
          width: 40%;
          margin-right: 60px;
      }

      .left {
          float: left;
          width: 45%;
      }

      .right1 {
          float: right;
        width: 60%;
      }

      .left1 {
          float: left;
          width: 40%;
      }

      .custom-thumbnail
      {
        border: 1px solid #000;
        border-radius: 60px;
        height: 2in;
        width: 2in;
      }
    ";

    $applicant_id = $appID;
    $ctr = 1;
    $applicant_info = $this->applicant->get_applicant_info($applicant_id);
    $test = '';
    foreach ($applicant_info as $applicant) 
    {
      $html = '';
      $program = '';
      $college = '';
      $department = '';
      $clsu2_email = '';

      $college_vocational = "";
      // '.$applicant->vocational_school_address.','.$applicant->vocational_school_year.','.$applicant->vocational_awads.'|'.$applicant->college_school_address.','.$applicant->college_school_year.','.$applicant->college_awards.'
      if ($applicant->vocational_school_address != "")
      {
        $college_vocational .= $applicant->vocational_school_address;
      }

      if ($applicant->vocational_school_address != "")
      {
        $college_vocational .= ",".$applicant->vocational_school_year;
      }

      if ($applicant->vocational_awads != "")
      {
        $college_vocational .= ",".$applicant->vocational_awads;
      }

      if ($applicant->college_school_address != "")
      {
        $college_vocational .= "|".$applicant->college_school_address;
      }

      if ($applicant->college_school_year != "")
      {
        $college_vocational .= ",".$applicant->college_school_year;
      }

      if ($applicant->college_awards != "")
      {
        $college_vocational .= ",".$applicant->college_awards;
      }

      $student_info = $this->applicant->get_student_info($applicant_id);
      foreach ($student_info as $student) 
      {
        $program = $student->program_name;
        $college = $student->college_desc;
        $clsu2_email = $student->email;
      }
      
      /*Header*/
      $html .=  '
        <table style="text-align: center; margin: 0 auto;">
          <tr>
            <td rowspan="5">
              <img src="'.base_url('assets/images/logo.bmp').'" width="100"/>
            </td>
            <td>
              <p style="text-align: center; font-family: roboto; font-size: 15px;">
                  Republic of the Philippines
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p style="text-align: center; font-family: roboto; font-size: 18px; font-weight: bold;">
                CENTRAL LUZON STATE UNIVERSITY
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p style="text-align: center; font-family: roboto; font-size: 15px;">
                Science City of Muñoz, Nueva Ecija
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p style="text-align: center; font-family: roboto; font-size: 15px; font-weight: bold;">
                OFFICE OF ADMISSIONS
              </p>
            </td>
          </tr>
          <tr>
            <td>
              <p style="text-align: center; font-family: roboto; font-size: 15px; font-weight: bold;">
                ENROLLMENT FORM
              </p>
            </td>
          </tr>
        </table>
      ';

      /*Sub header*/
      $html .=  '
        <div style="text-align: left; font-family: roboto; font-size: 12px; font-weight: bold; margin-top: 25px;">
          PERSONAL INFORMATION
        </div>
      ';

      $html .=  '
        <div style="text-align: left; font-family: roboto; font-size: 15px; font-weight: bold; margin-top: 5px;">
          <table style="width: 100%;">

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
                Name
              </td>
              <td colspan="5" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->lname.' '.$applicant->fname.' '.$applicant->mname.'
              </td>
              <td style="font-size: 10px; font-weight: bold;">
                CLSU CAT Applicant ID No
              </td>
              <td colspan="10" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->applicant_id.'
              </td>
            </tr>

            <tr>
              <td></td>
              <td colspan="2" style="font-size: 10px; font-style: italic;">Family Name</td>
              <td colspan="2" style="font-size: 10px; font-style: italic; text-align: center;">Given Name</td>
              <td style="font-size: 10px; font-style: italic;">Middle Name</td>
              <td colspan="11"></td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
                Sex
              </td>
              <td colspan="2" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->sex.'
              </td>
              <td style="font-size: 12px; font-weight: bold;">
                Civil Status
              </td>
              <td colspan="2" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->civil_status.'
              </td>
              <td style="font-size: 12px; font-weight: bold;">
                Nationality
              </td>
              <td colspan="2" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->citizenship_name.'
              </td>
              <td style="font-size: 12px; font-weight: bold;">
                Religion
              </td>
              <td colspan="7" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->religion_name.'
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
                Date of Birth
              </td>
              <td colspan="5" style="font-size: 13px; background-color: #dedede;">
                '.(date("F d, Y", strtotime($applicant->date_of_birth))).'
              </td>
              <td style="font-size: 12px; font-weight: bold;">
                Place of Birth
              </td>
              <td colspan="10" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->place_of_birth.'
              </td>
            </tr>

            <tr>
              <td></td>
              <td colspan="2" style="font-size: 10px; font-style: italic;">Month</td>
              <td colspan="2" style="font-size: 10px; font-style: italic;">Day</td>
              <td style="font-size: 10px; font-style: italic;">Year</td>
              <td></td>
              <td colspan="4" style="font-size: 10px; font-style: italic;">City/Municipality</td>
              <td colspan="6" style="font-size: 10px; font-style: italic;">Province</td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
                Telephone/Mobile No.
              </td>
              <td colspan="5" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->student_mobile_contact.' / '.$applicant->student_tel_contact.'
              </td>
              <td style="font-size: 12px; font-weight: bold;">
                E-mail Address
              </td>
              <td colspan="10" style="font-size: 13px; background-color: #dedede;">
                '.$clsu2_email.'
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
                Home Address
              </td>
              <td colspan="16" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->permanent_address.', '.explode("|", $applicant->permanent_cluster)[3].'
              </td>
            </tr>

            <tr>
              <td></td>
              <td colspan="4" style="font-size: 10px; font-style: italic;">House No.</td>
              <td colspan="4" style="font-size: 10px; font-style: italic; text-align: center;">Street/Subdivision</td>
              <td colspan="8" style="font-size: 10px; font-style: italic;">Barangay</td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
              </td>
              <td colspan="16" style="font-size: 13px; background-color: #dedede;">
                '.(explode("|", $applicant->permanent_cluster)[2].", ".explode("|", $applicant->permanent_cluster)[1].", ".explode("|", $applicant->permanent_cluster)[0]).', '.$applicant->zipcode.', '.$applicant->country.'
              </td>
            </tr>

            <tr>
              <td></td>
              <td colspan="3" style="font-size: 10px; font-style: italic;">City/Municipality</td>
              <td colspan="3" style="font-size: 10px; font-style: italic; text-align: center;">Province</td>
              <td colspan="3" style="font-size: 10px; font-style: italic; text-align: center;">Zip Code</td>
              <td colspan="8" style="font-size: 10px; font-style: italic;">Country</td>
            </tr>

          </table>
        </div>
      ';

      $html .=  '
        <div style="text-align: left; font-family: roboto; font-size: 12px; font-weight: bold; margin-top: 1px;">
          EDUCATIONAL BACKGROUND
        </div>
      ';

      $html .=  '
        <div style="text-align: left; font-family: roboto; font-size: 15px; font-weight: bold; margin-top: 5px;">
          <table style="width: 100%;">

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
              </td>
              <td style="font-size: 12px; font-weight: bold; text-align: center;">
                Name of School
              </td>
              <td style="font-size: 12px; font-weight: bold; text-align: center;">
                Date of Completion
              </td>
              <td style="font-size: 12px; font-weight: bold; text-align: center;">
                Honors/Awards Received
              </td> 
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Elementary
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->elementary_school_address.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->elementary_year.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->elem_awards.'
              </td> 
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Junior High School
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->high_school_address.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->high_school_year.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->high_school_awards.'
              </td> 
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Senior High School
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->senior_high_address.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->high_school_grad_year.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->senior_high_school_awards.'
              </td> 
            </tr>

            <tr>
              <td colspan="2" style="font-size: 12px; font-weight: regular;">
                College, Institute or University Last attended (if any)
              </td>
              <td colspan="2" style="font-size: 13px; background-color: #dedede;">
                '.$college_vocational.'
              </td>
            </tr>

          </table>
        </div>
      ';

      $html .=  '
        <div style="text-align: left; font-family: roboto; font-size: 12px; font-weight: bold; margin-top: 1px;">
          FAMILY BACKGROUND
        </div>
      ';

      $html .=  '
        <div style="text-align: left; font-family: roboto; font-size: 15px; font-weight: bold; margin-top: 5px;">
          <table style="width: 100%;">

            <tr>
              <td style="font-size: 12px; font-weight: bold;">
              </td>
              <td style="font-size: 12px; font-weight: bold; text-align: center;">
                Father
              </td>
              <td style="font-size: 12px; font-weight: bold; text-align: center;">
                Mother
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Name
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->father_name.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->mother_name.'
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Highest Educational Attainment
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->father_education.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->mother_education.'
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Occupation
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->father_occupation.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->mother_occupation.'
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Telephone/Mobile No.
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->father_contact.'
              </td>
              <td style="font-size: 13px; background-color: #dedede;">
                '.$applicant->mother_contact.'
              </td>
            </tr>

            <tr>
              <td style="font-size: 12px; font-weight: regular;">
                Address of Parents/Guardian
              </td>
              <td colspan="2" style="font-size: 13px; background-color: #dedede;">
                '.$applicant->father_address.' / '.$applicant->mother_address.'
              </td>
            </tr>

          </table>
        </div>
      ';

      $html .=  '
        <div style="text-align: center; font-family: roboto; font-size: 12px; font-weight: bold; margin-top: 5px;">
          STUDENT\'S PLEDGE, WAIVER and CONSENT
        </div>
        <p style="font-size: 11px; text-indent: 20px; margin-top: 5px;">
          In consideration of my admission to the Central Luzon State University, I hereby promise and pledge to conform to and abide by all the rules and regulations laid down by the authorities in the said University and I hereby voluntarily and freely state, without any force or intimidation by any person or persons, that the University and/or its authorities shall not be liable for any accident or injury that may befall upon me while a student in the said institution. 
        </p>
        <p style="font-size: 11px; text-indent: 20px; margin-top: 5px;">
          I hereby affirm that all information written herein are complete and accurate. I am aware that any false information furnished in this enrollment form will make me ineligible for admission or subject to dismissal in the University. I hereby give permission to the University to store and process my personal data in adherence to the principles of transparency, legitimate purpose, and proportionality as required by RA 10173 or Data Privacy Act of 2012.  
        </p>

        <table style="margin: 0 0 0 auto; text-align: center; z-index: 999;">
          <tr>
            <td style="border-bottom: 2px solid #000;">
              
              <p style="text-align: center; z-index: 1;">'.$applicant->fname.' '.$applicant->mname.' '.$applicant->lname.'</p>
            </td>
          </tr>
          <tr>
            <td>
              <p style="text-align: center; padding-top: -15px; font-size: 12px;">Signature over Printed Name of Student </p>
            </td>
          </tr>
        </table>
      ';

      $signatory = "";
      if ($applicant->signatories == "father") 
      {
        $signatory = $applicant->father_name;
      }else if ($applicant->signatories == "mother")
      {
        $signatory = $applicant->mother_name;
      }else if ($applicant->signatories == "guardian")
      {
        $signatory = $applicant->guardian_name;
      }

      $html .=  '
        <div style="text-align: center; font-family: roboto; font-size: 12px; font-weight: bold;">
          PARENT\'S OR GUARDIAN\'S GUARANTEE
        </div>
        <p style="font-size: 11px; text-indent: 20px; margin-top: 5px;">
          I hereby conform to the pledge and waiver of my child in consideration to the admission requirements of the Central Luzon State University. 
        </p>

        <table style="margin: 0 0 0 auto; text-align: center; z-index: 999;">
          <tr>
            <td style="border-bottom: 2px solid #000;">
              <p style="text-align: center; z-index: 1;">'.$signatory.'</p>
              <p style="text-align: center; z-index: 1;"></p>
            </td>
          </tr>
          <tr>
            <td>
          <p style="text-align: center; padding-top: -15px; font-size: 12px;"> Signature over Printed Name of Parent/Guardian</p>
            </td>
          </tr>
        </table>

        <div style="text-align: center; font-family: roboto; font-style: italic; font-size: 12px; font-weight: bold; border-bottom: 2px solid #000;">
          (DO NOT WRITE BELOW THIS LINE)
        </div>
        <table style="width: 100%;">
          <tr>
            <td colspan="5" style="font-size: 12px;">Admitted to</td>
            <td rowspan="6" class="custom-thumbnail">
              <div style="font-size: 10px; font-style: italic; text-align: justify;">
                ATTACH HERE A RECENT 2”X2”
                COLORED PHOTO WITH WHITE
                BACKGROUND AND NAME TAG
                (SURNAME, FIRST NAME, MIDDLE INITIAL)
              </div>
            </td>
          </tr>
          <tr>
            <td></td>
            <td style="font-size: 11px;">Degree Program</td>
            <td colspan="3" style="font-size: 13px; background-color: #dedede;">'.$program.'</td>
          </tr>
          <tr>
            <td></td>
            <td style="font-size: 11px;">College</td>
            <td colspan="3" style="font-size: 13px; background-color: #dedede;">'.$college.'</td>
          </tr>
          <tr>
            <td></td>
            <td style="font-size: 11px;">Department</td>
            <td colspan="3" style="font-size: 13px; background-color: #dedede;"></td>
          </tr>
          <tr>
            <td colspan="5" style="font-size: 12px;">Admitted by:</td>
          </tr>
          <tr>
            <td></td>
            <td colspan="2" style="border: 1px solid #000;">
              <table style="width: 100%;">
                <tr>
                  <td style="font-size: 12px; font-style: italic;">For the College</td>
                </tr>
                <tr>
                  <td style="font-size: 13px; border-bottom: 1px solid #000; text-align: center;">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 10px; font-weight: bold; text-align: center;">
                    SIGNATURE OVER PRINTED NAME
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 10px; font-weight: regular; text-align: center;">
                    Registration Adviser
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 10px; font-weight: regular; text-align: left;">
                    Date
                  </td>
                </tr>
              </table>
            </td>
            <td colspan="2" style="border: 1px solid #000;">
              <table style="width: 100%;">
                <tr>
                  <td style="font-size: 12px; font-style: italic;">For the Office of Admissions</td>
                </tr>
                <tr>
                  <td style="font-size: 13px; border-bottom: 1px solid #000; text-align: center;">
                    &nbsp;
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 10px; font-weight: bold; text-align: center;">
                    SIGNATURE OVER PRINTED NAME
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 10px; font-weight: regular; text-align: center;">
                    Record-in-Charge
                  </td>
                </tr>
                <tr>
                  <td style="font-size: 10px; font-weight: regular; text-align: left;">
                    Date
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      ';

      $mpdf->SetHTMLFooter('<p style="font-size: 10px; font-style: italic;">ACA.OAD.YYY.F.001 (Revision No. 2; March 9, 2020)</p>');


      $ctr++;
      if ($ctr < count($applicant_info)) 
      {
        
      }
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($html, 2);
      $test .= $html;
    }

    // $mpdf->watermark_font = 'villona';

    ob_clean();
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="enrollment_form.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    $mpdf->Output($applicant_id.".pdf", \Mpdf\Output\Destination::DOWNLOAD);
    ob_end_flush();
    // echo $test;


    // $directoryName = FCPATH.'downloads/'.'gerald.valdez@clsu2.edu.ph';
    // //Check if the directory already exists.
    // if(!is_dir($directoryName)){
    //   //Directory does not exist, so lets create it.
    //   mkdir($directoryName, 0755, true);
    // }
    // $mpdf->Output('enrollment_form.pdf', \Mpdf\Output\Destination::FILE);
  }

}


/* End of file Applicant.php */
/* Location: ./application/controllers/Applicant.php */