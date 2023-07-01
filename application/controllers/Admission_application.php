<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Admission_application extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model("admission_application_model", "admission_application");
    $this->load->library('upload'); 
  }

  public function index()
  {
    $data = array(
      "courseList"  =>  $this->courseList()
    );
    $this->load->view('application/_header', $data);
    $this->load->view('application/_css', $data);
    $this->load->view('application/application_view', $data);
    $this->load->view('application/modal/_err_modal', $data);
    $this->load->view('application/_footer', $data);
    $this->load->view('application/_js', $data);
  }

  public function reference($appID, $referenceEmail)
  {
    $data = array(
      "appID"     =>  $appID,
      "referenceEmail" =>  $referenceEmail,
      "referenceInfo"   =>  $this->getReferenceInfo($appID, $referenceEmail)
    );
    
    $this->load->view('application/_header', $data);
    $this->load->view('application/_css', $data);
    $this->load->view('application/reference_view', $data);
    $this->load->view('application/_footer', $data);
    $this->load->view('application/_js', $data);
  }

  public function getReferenceInfo($appID, $referenceEmail = "")
  {
    $referenceData = $this->admission_application->getApplication($appID);
    $referenceInfo = "";
    $refereceCtr = 0;
    $output = array();
    foreach ($referenceData as $reference) 
    {
      $referenceInfo = $reference->reference;
    }

    for ($i=0; $i < explode("||", $referenceInfo); $i++) 
    { 
      if (explode("||", $referenceInfo)[$i] == $referenceEmail)
      {
        $refereceCtr = $i;
        break;
      }
    }

    array_push($output, explode("||", $referenceInfo)[$refereceCtr - 1]);
    array_push($output, explode("||", $referenceInfo)[$refereceCtr - 2]);
    array_push($output, explode("||", $referenceInfo)[$refereceCtr - 3]);
    array_push($output, explode("||", $referenceInfo)[$refereceCtr - 4]);
    array_push($output, explode("||", $referenceInfo)[$refereceCtr + 1]);
    array_push($output, explode("||", $referenceInfo)[$refereceCtr]);


    return $output;

  }

  public function applicantInfo()
  {
    $applicantID = $_POST['appID'];
    $appInfo = array();

    $applicants = $this->admission_application->getApplication($applicantID);
    foreach ($applicants as $applicant) 
    {
      $appInfo = array(
        "appName"   =>  $applicant->lname.", ".$applicant->fname." ".$applicant->mname,
        "appEmail"  =>  $applicant->email_address,
        "program"   =>  $applicant->course_desc
      );
    }

    echo json_encode($appInfo);
  }

  public function admission_verification($applicationID)
  {
    $emailLogs = $this->admission_application->getEmailLogs($applicationID);
    $requiredAttachment = $this->admission_application->getRequiredAttachment($applicationID);
    $requiredAttachmentHTML = "";

    $emailSendStatus = '';
    $emailSentCtr = 0;

    foreach ($emailLogs as $logs) 
    {
      $emailSendStatus .= '<tr>';
        $emailSendStatus .= '<td>'.$logs->email.'</td>';
        $emailSendStatus .= '<td>'.($logs->status == 0 ? "EMAIL SENDING FAILED" : "EMAIL SENT").'</td>';
        if ($logs->status == 0)
        {
          $emailSendStatus .= '<td>
                                  <button class="btn btn-lg btn-success waves-effect" onclick="resendReference(\''.$applicationID.'\', \''.(htmlentities($logs->lname).", ".htmlentities($logs->fname)." ".htmlentities($logs->mname)).'\', \''.$logs->email.'\', \''.$logs->reference_name.'\')">RESEND</button>
                              </td>';
        }else
        {
          $emailSentCtr++;
          $emailSendStatus .= '<td>...</td>';
        }
      $emailSendStatus .= '</tr>';
    }

    foreach ($requiredAttachment as $attachment) 
    {
      $requiredAttachmentHTML .= '<tr>';
        $requiredAttachmentHTML .= '<td>GWA</td>';
        $requiredAttachmentHTML .= '<td>'.($attachment->gwa_file == "" ? "No attachment found, please upload" : "complete").'</td>';
        $requiredAttachmentHTML .= '<td><form><input type="file" class="form-control"><input type="submit" class="btn btn-sm bg-blue-grey waves-effect" value="UPLOAD"></form></td>';
      $requiredAttachmentHTML .= '</tr>';

      $requiredAttachmentHTML .= '<tr>';
        $requiredAttachmentHTML .= '<td>PICTURE</td>';
        $requiredAttachmentHTML .= '<td>'.($attachment->img_file == "" ? "No attachment found, please upload" : "complete").'</td>';
        $requiredAttachmentHTML .= '<td><form><input type="file" class="form-control"><input type="submit" class="btn btn-sm bg-blue-grey waves-effect" value="UPLOAD"></form></td>';
      $requiredAttachmentHTML .= '</tr>';

      $requiredAttachmentHTML .= '<tr>';
        $requiredAttachmentHTML .= '<td>PROFICIENCY (optional)</td>';
        $requiredAttachmentHTML .= '<td></td>';
        $requiredAttachmentHTML .= '<td></td>';
      $requiredAttachmentHTML .= '</tr>';

      $requiredAttachmentHTML .= '<tr>';
        $requiredAttachmentHTML .= '<td>TOR</td>';
        $requiredAttachmentHTML .= '<td>'.($attachment->tor_file == "" ? "No attachment found, please upload" : "complete").'</td>';
        $requiredAttachmentHTML .= '<td><form><input type="file" class="form-control"><input type="submit" class="btn btn-sm bg-blue-grey waves-effect" value="UPLOAD"></form></td>';
      $requiredAttachmentHTML .= '</tr>';
    }

    $data = array(
      "appID"             =>  $applicationID,
      "emailSendStatus"   =>  $emailSendStatus,
      "requiredAttachment"=>  $requiredAttachmentHTML,
      "trackTitle"        =>  "List below are the emails of your reference. If status is EMAIL SENDING FAILED, please click RESEND BUTTON",
      "enrollmentFormBtn" =>  count($emailLogs) == $emailSentCtr ? '<br><button class="btn btn-lg btn-block btn-success waves-effect">FILL-UP ENROLLMENT FORM</button>' : 0
    );
    
    $this->load->view('application/_header', $data);
    $this->load->view('application/_css', $data);
    $this->load->view('application/application_verification_view', $data);
    $this->load->view('application/_footer', $data);
    $this->load->view('application/_js', $data);
  }

  public function courseList()
  {
    $courseData = $this->admission_application->gerGraduateProgram(array("MS", "MA", "PhD"));
    $htmlData = "";
    foreach ($courseData as $data) 
    {
      if (!in_array($data->course_id, array(78, 172, 143)))
      {
        $htmlData .= '<option value='.$data->course_id.'>'.strtoupper($data->course_desc).' ('.$data->course_name.')</option>';
      }
    }

    return $htmlData;
  }

  public function submitApplication()
  {
    $data = $_POST;
    $msg = array();
    $generatedApplicantID = $this->generateApplicantID(50);

    $count = count($_FILES['gradAttachment']['name']);
    $directoryName = "";
    $directories = array("TOR", "GWA", "IMG");
    $tor_file = "";
    $gwa_file = "";
    $img_file = "";
    $proficiency_file = "";
    $referenceEmail = array();
    $referenceName = array();
    $referenceEmailCtr = 4;
    $referenceNameCtr = 0;
    $emailFailed = array();
    
    for($i=0; $i < $count; $i++)
    {
      $directoryName = FCPATH.'uploads/graduate_level_requirements/'.$directories[$i];
      // $downloads = FCPATH.'downloads/graduate_level_/'.$_SESSION['e_id'];
      //Check if the directory already exists.
      if(!is_dir($directoryName))
      {
        //Directory does not exist, so lets create it.
        mkdir($directoryName, 0755, true);
      }

      if(!empty($_FILES['gradAttachment']['name'][$i]))
      {
        $_FILES['file']['name'] = $_FILES['gradAttachment']['name'][$i];
        $_FILES['file']['type'] = $_FILES['gradAttachment']['type'][$i];
        $_FILES['file']['tmp_name'] = $_FILES['gradAttachment']['tmp_name'][$i];
        $_FILES['file']['error'] = $_FILES['gradAttachment']['error'][$i];
        $_FILES['file']['size'] = $_FILES['gradAttachment']['size'][$i];

        $config['upload_path'] = $directoryName; 
        $config['allowed_types'] = 'jpg|jpeg|JPG|JPEG|png|PNG|pdf|PDF';
        $config['max_size'] = '10024';
        $config['file_name'] = $generatedApplicantID;

        $this->upload->initialize($config);
        if($this->upload->do_upload('file'))
        {
          $uploadData = $this->upload->data();
          switch ($i)
          {
            case 0: 
              $tor_file = $uploadData['file_name'];
              break;

              case 1: 
                $gwa_file = $uploadData['file_name'];
                break;

                case 2: 
                  $img_file = $uploadData['file_name'];
                  break;
          }
          // $filename = $uploadData['file_name'];
        }

        unset($config);
      }
    }

    if(!empty($_FILES['proficiencyAttachement']['name']))
    {
      $directoryName = FCPATH.'uploads/graduate_level_requirements/PROFICIENCY';
      // $downloads = FCPATH.'downloads/graduate_level_/'.$_SESSION['e_id'];
      //Check if the directory already exists.
      if(!is_dir($directoryName))
      {
        //Directory does not exist, so lets create it.
        mkdir($directoryName, 0755, true);
      }

      $_FILES['file']['name'] = $_FILES['proficiencyAttachement']['name'];
      $_FILES['file']['type'] = $_FILES['proficiencyAttachement']['type'];
      $_FILES['file']['tmp_name'] = $_FILES['proficiencyAttachement']['tmp_name'];
      $_FILES['file']['error'] = $_FILES['proficiencyAttachement']['error'];
      $_FILES['file']['size'] = $_FILES['proficiencyAttachement']['size'];

      $config['upload_path'] = $directoryName; 
      $config['allowed_types'] = 'jpg|jpeg|JPG|JPEG|png|PNG|pdf|PDF';
      $config['max_size'] = '10024';
      $config['file_name'] = $generatedApplicantID;

      $this->upload->initialize($config);
      if($this->upload->do_upload('file'))
      {
        $uploadData = $this->upload->data();
        $proficiency_file = $uploadData['file_name'];
        // $filename = $uploadData['file_name'];
      }

      unset($config);
    }

    $arrData = array(
      "application_id"              =>  $generatedApplicantID,
      "enroll_degree"               =>  $data['question_1'] == "true" ? 1 : 0,
      "enroll_grad_program"         =>  $data['question_2'] == "true" ? 1 : 0,
      "degree_program_applied"      =>  $data['question_3'],
      "field_of_study"              =>  $data['question_4'],
      "title"                       =>  $data['question_5'],
      "lname"                       =>  htmlentities($data['question_6']),
      "fname"                       =>  htmlentities($data['question_7']),
      "mname"                       =>  htmlentities($data['question_8']),
      "mailing_address"             =>  htmlentities($data['question_9']),
      "region"                      =>  $data['question_10'],
      "province"                    =>  $data['question_11'],
      "municipality"                =>  $data['question_12'],
      "barangay"                    =>  $data['question_13'],
      "postal_code"                 =>  $data['question_14'],
      "country"                     =>  $data['question_15'],
      "email_address"               =>  $data['question_16'],
      "phone_number"                =>  $data['question_17'],
      "citizenship"                 =>  $data['question_18'],
      "present_occupation"          =>  $data['question_19'],
      "address_of_employment"       =>  htmlentities($data['question_20']),
      "educational_background"      =>  $this->getArr($data['question_21']),
      "reference"                   =>  $this->getArr($data['question_22']),
      "area_of_interest"            =>  $data['question_23'],
      "aoi_major"                   =>  $data['question_24'],
      "languange_proficiency"       =>  $this->getArr($data['question_25']),
      "graduate_program_applied"    =>  $data['question_26']."||".$data['question_27'],
      "teaching_experience"         =>  $this->getArr($data['question_28']),
      "publish_materials"           =>  $this->getArr($data['question_29']),
      "academic"                    =>  $this->getArr($data['question_30']),
      "future_plan"                 =>  $data['question_31'],
      "expected_source"             =>  $data['question_32'],
      "school_year"                 =>  $data['question_33'],
      "semester"                    =>  $data['question_34'],
      "confirmation_status"         =>  1,
      "tor_file"                    =>  $tor_file,
      "gwa_file"                    =>  $gwa_file,
      "img_file"                    =>  $img_file,
      "proficiency_file"            =>  $proficiency_file,
      "admission_type"              =>  "graduate_level_admission",
      "date_created"                =>  date("Y-m-d H:i:s")
    );

    for ($i=0; $i < count(explode("||", $this->getArr($data['question_22']))); $i++) 
    { 
      if ($i == $referenceEmailCtr)
      {
        array_push($referenceEmail, explode("||", $this->getArr($data['question_22']))[$referenceEmailCtr]);
        $referenceEmailCtr += 6;
      }

      if ($i == $referenceNameCtr)
      {
        array_push($referenceName, explode("||", $this->getArr($data['question_22']))[$referenceNameCtr]);
        $referenceNameCtr += 6;
      }
    }

    // $msg = array(
    //   "sys_msg" =>  "success",
    //   "msg"     =>  "Applcation submitted successfully",
    //   "type"    =>  "success",
    //   "test"    =>  json_encode($referenceName)
    // );

    $emailVerification = $this->emailVerification($generatedApplicantID, $data['question_16']);

    if ($emailVerification[0]['error'] === true)
    {
      $save = $this->admission_application->save("oad0001", $arrData);
      if ($save !== false) 
      {
        $applicantCourseInfo = $this->admission_application->getApplication($generatedApplicantID);
        $courseInfo = "";
        foreach ($applicantCourseInfo as $course_info) 
        {
          $courseInfo = $course_info->course_desc;
        }

        $emailStatus = $this->emailRefrence($referenceEmail, htmlentities($data['question_7'].", ".htmlentities($data['question_8'])." ".htmlentities($data['question_6'])), $referenceName, $generatedApplicantID, $courseInfo);


        $emailCtr = 0;
        for ($i=0; $i < count($emailStatus); $i++) 
        { 
          if ($emailStatus[$i]['error'] === true)
          {
            $emailData = array(
              "application_id"  =>  $generatedApplicantID,
              "reference_name"  =>  $emailStatus[$i]['referenceName'],
              "email"           =>  $emailStatus[$i]['email'],
              "status"          =>  1,
              "created"         =>  date("Y-m-d H:i:s"),
              "modified"        =>  date("Y-m-d H:i:s")
            );
            
            $emailLogs = $this->admission_application->save("oad0004", $emailData);
            $emailCtr++;
          }
          
          if ($emailStatus[$i]['error'] !== true)
          {
            $emailData = array(
              "application_id"  =>  $generatedApplicantID,
              "reference_name"  =>  $emailStatus[$i]['referenceName'],
              "email"           =>  $emailStatus[$i]['email'],
              "status"          =>  0,
              "created"         =>  date("Y-m-d H:i:s"),
              "modified"        =>  date("Y-m-d H:i:s")
            );
            
            $emailLogs = $this->admission_application->save("oad0004", $emailData);
            array_push($emailFailed, $emailStatus[$i]['email']);
          }
        }

        if ($emailCtr == count($emailStatus))
        {
          $msg = array(
            "sys_msg"       =>  "success",
            "msg"           =>  "Application submitted successfully",
            "type"          =>  "success",
            "emailStatus"   =>  "success",
            "emailFailed"   =>  "",
            "applicationID" =>  $generatedApplicantID,
            "course"        =>  json_encode($applicantCourseInfo)
          );
        }else
        {
          $msg = array(
            "sys_msg"       =>  "failed",
            "msg"           =>  "Application submitted failed",
            "type"          =>  "error",
            "emailStatus"   =>  $emailCtr == count($emailStatus) ? "success" : "failed",
            "emailFailed"   =>  $emailFailed,
            "applicationID" =>  $generatedApplicantID
          );
        }
      }else
      {
        $msg = array(
          "sys_msg" =>  "failed",
          "msg"     =>  "Application submitted failed, please try again",
          "type"    =>  "error",
          "emailStatus"   =>  "",
          "emailFailed"   =>  "reference",
          "applicationID" =>  $generatedApplicantID,
          "course"        =>  json_encode($applicantCourseInfo)
        );
      }
    }else
    {
      $msg = array(
        "sys_msg" =>  "failed",
        "msg"     =>  "Application submitted failed, please try again",
        "type"    =>  "error",
        "emailStatus"   =>  "",
        "emailFailed"   =>  "applicant",
        "applicationID" =>  $generatedApplicantID,
        "course"        =>  json_encode($applicantCourseInfo)
      );
    }
    
    echo json_encode($msg);
  }

  public function submitReference()
  {
    $data = $_POST;

    $reference = array(
      "applicant_id"                         =>  $_POST['applicantID'],
      "applicant_capacity"                   =>  $this->getArr($_POST['question_1']),
      "applicant_amplitude"                  =>  $_POST['question_2'],
      "applicant_scholastic"                 =>  $_POST['question_3'],
      "applicant_potential_professional"     =>  $_POST['question_4'],
      "others"                               =>  $_POST['question_5'],
      "reference_name"                       =>  $_POST['reference_name'],
      "reference_relationship"               =>  $_POST['reference_relationship'],
      "reference_affiliation"                =>  $_POST['reference_affiliation'],
      "reference_position"                   =>  $_POST['reference_position'],
      "reference_number"                     =>  $_POST['reference_number'],
      "created"                              =>  date("Y-m-d H:i:s"),
      "modified"                             =>  date("Y-m-d H:i:s")
    );

    $save = $this->admission_application->save("oad0002", $reference);
    if ($save !== false) 
    {

      $referenceStatusData = array(
        "application_id"    =>  $_POST['applicantID'],
        "reference_email"   =>  $_POST['reference_email'],
        "reference_status"  =>  date("Y-m-d H:i:s"),
        "reference_remarks" =>  "approve" 
      );

      $condition = array(
        "application_id"    =>  $_POST['applicantID'],
        "reference_email"   =>  $_POST['reference_email']
      );

      if (count($this->admission_application->checkRequest($_POST['applicantID'], $_POST['reference_email'])) > 0)
      {
        $this->admission_application->updateAdmission($referenceStatusData, $condition, array('oad0003'));
      }else
      {
        $this->admission_application->save("oad0003", $referenceStatusData);
      }

      $emailReference = $this->referenceResponse($reference, $_POST['reference_email']);

      $msg = array(
        "sys_msg"       =>  "success",
        "msg"           =>  "Submitted successfully, Thank you!!!",
        "type"          =>  "success",
        "emailStatus"   =>  "",
        "emailFailed"   =>  ""
      );
    }else
    {
      $msg = array(
        "sys_msg" =>  "failed",
        "msg"     =>  "Submit failed",
        "type"    =>  "error",
        "emailStatus"   =>  "",
        "emailFailed"   =>  ""
      );
    }

    echo json_encode($msg);
  }

  public function refuseApplication($applicationID, $referenceEmail)
  {
    $referenceStatusData = array(
      "application_id"    =>  $applicationID,
      "reference_email"   =>  $referenceEmail,
      "reference_status"  =>  date("Y-m-d H:i:s"),
      "reference_remarks" =>  "refuse" 
    );

    $condition = array(
      "application_id"    =>  $applicationID,
      "reference_email"   =>  $referenceEmail
    );

    if (count($this->admission_application->checkRequest($applicationID, $referenceEmail)) > 0)
    {
      $update = $this->admission_application->updateAdmission($referenceStatusData, $condition, array('oad0003'));
      if ($update !== false)
      {
        redirect("https://oad.clsu2.edu.ph/");
      }else
      {
        $data = array(
          "code"        =>  "501",
          "msg"         =>  "Something went wrong, please try again",
          "link"        =>  base_url('/admission_application/refuseApplication/'.$applicantID.'/'.$referenceEmail),
          "homepageBTN" =>  "REFUSE"
        );
        $this->load->view('err/custom_error', $data);
      }
    }else
    {
      $insert = $this->admission_application->save("oad0003", $referenceStatusData);
      if ($insert !== false)
      {
        redirect("https://oad.clsu2.edu.ph/");
      }else
      {
        $data = array(
          "code"        =>  "501",
          "msg"         =>  "Something went wrong, please try again",
          "link"        =>  base_url('/admission_application/refuseApplication/'.$applicantID.'/'.$referenceEmail),
          "homepageBTN" =>  "REFUSE"
        );
        $this->load->view('err/custom_error', $data);
      }
    }
  }

  public function uploadFile($directory = "", $fileName = "", $file = "")
  {
    $msg = array();
    $directoryName = FCPATH.'uploads/graduate_level_requirements/'.$directory;
		// $downloads = FCPATH.'downloads/graduate_level_/'.$_SESSION['e_id'];
		//Check if the directory already exists.
		if(!is_dir($directoryName))
    {
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755, true);
		}
		
		$config['upload_path']          = 	$directoryName;
		$config['allowed_types']        = 	'pdf|PDF|jpg|JPEG|png|PNG';
		$config['max_size']             = 	10024;
		$config['file_name']            = 	$fileName;
		$config['overwrite']            = 	TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($file))
		{
      $error = $this->upload->display_errors();
      // $msg = array(
      //   "sys_msg" =>  "error",
      //   "msg"     =>  $error,
      //   "type"    =>  "error"
      // );
      return false;
      // $this->session->set_flashdata('error_upload', $error);
      // redirect('faculty/grades');
		}
		else
		{
      // $msg = array(
      //   "sys_msg" =>  "success",
      //   "msg"     =>  "Upload Complete",
      //   "type"    =>  "success"
      // );
      return true;
		}

    // return $msg;
  }

  public function getArr($arr = array())
  {
    $arrData = array();
    $delimetedData = "";
    for ($i=0; $i < count($arr); $i++) 
    { 
      if ($arr[$i] != "")
      {
        array_push($arrData, htmlentities($arr[$i]));
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

  public function getParseDelimetedData($str = "", $index = 0)
  {
    $parseData = explode("||", $str);

    return count($parseData) > $index ? $parseData[$index] : "N/A";
  }

  function generateApplicantID($length_of_string)
  {
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $code = $this->admission_application->getApplicationID(substr(str_shuffle($str_result), 0, $length_of_string));

    if (count($code) > 0) 
    {
      $this->generateApplicantID($length_of_string);
    }

    return substr(str_shuffle($str_result), 0, $length_of_string);
  }

  public function admissionApplicationForm($data = array())
  {
    if (count($data) == 0)
    {
      $data = array(
        "code"        =>  "404",
        "msg"         =>  "Application not found, please contact OFFICE OF ADMISSIONS (OAD)",
        "link"        =>  "javascript:void(0)",
        "homepageBTN" =>  "APPLICATION VERIFICATION"
      );

      $this->load->view('err/custom_error', $data);
      return;
    }

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new \Mpdf\Mpdf([
          'mode'          => 'utf-8',
          'format'        => [215.9, 330.2], //in cm
          'orientation'   => 'P',
          'margin_top'    => '15',
          'margin_bottom' => '50',
          'fontDir'       => array_merge($fontDirs, [
                                  'custom/font/directory',
                          ]),
          'fontdata'      => $fontData + [
              'roboto' => [ 
                  'R' => 'Roboto-Regular.ttf'
              ],
              'londrina' => [
                  'R' => 'LondrinaOutline-Regular.ttf'
              ],
              'stoicheion' => [
                  'R' => 'Stoicheion-2Od3X.ttf'
              ],
              'villona' => [
                  'R' => 'Vilona-mLL45.ttf'
              ]
          ],
          'default_font' => 'roboto'
    ]);
    $stylesheet = file_get_contents('assets/plugins/bootstrap/css/bootstrap.css');

    $html = "";
    $eduactional_background = $data[0]->educational_background; 
    $html .= '
          <table class="table" style="margin-bottom: 0;">
            <tr>
              <td style="text-align: right; width: 18%;">
                <img src="assets/images/logo.png" width="96" />
              </td>
              <td style="text-align: center; vertical-align: top; padding-top: 35px; width: 10%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">Republic of the Philippines</p>
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">CENTRAL LUZON STATE UNIVERSITY</p>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">Science City of Muñoz, Nueva Ecija</p>
              </td>
              <td style="text-align: right; width: 20%;">
                <img src="uploads/graduate_level_requirements/IMG/'.$data[0]->img_file.'" style="width: 1.2in; height; 1.6in; border: 1px solid #000;" />
              </td>
            </tr>
          </table>

          <table>
            <tr>
              <td colspan="3" style="text-align: center; padding: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">APPLICATION FOR ADMISSION TO GRADUATE STUDIES</p>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align: left; padding-bottom: 20px;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  Instruction to Applicant: This form should be accomplished with all entries. Please fill-out all items, Applicant for MS/MPS must be a Bachelor\'s degree graduate; applicant for PhD must be an MS/MA degree graduate. An application entity one for consideration to the specified program only.
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: left; padding-bottom: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Are you currently enrolled in a degree program in CLSU or in other higher education institution?
                </p>
              </td>
              <td style="vertical-align: 0;">
                <p style="font-family: roboto; font-size: 11px;">
                  <span style="font-size: 8px;'.($data[0]->enroll_degree == 1 ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 8px;'.($data[0]->enroll_degree == 0 ? "background-color: #000;" : "background-color: #fff;").'  border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: left; padding-bottom: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Were you previously enrolled in a graduate program in CLSU (including DOT- Uni)?
                </p>
              </td>
              <td style="vertical-align: 0;">
                <p style="font-family: roboto; font-size: 11px;">
                  <span style="font-size: 8px;'.($data[0]->enroll_grad_program == 1 ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Yes
                  <span style="font-size: 8px;'.($data[0]->enroll_grad_program == 0 ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> No
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Degree Program Applied for:
                  <span style="font-size: 8px;'.($data[0]->degree_program_applied == "master" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Master\'s
                  <span style="font-size: 8px;'.($data[0]->degree_program_applied == "phd" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> PhD
                </p>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td style="width: 12%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Field of Study:
                </p>
              </td>
              <td colspan="5" style="border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.$data[0]->course_desc.' ('.$data[0]->course_name.')
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: left; padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Title:
                  <span style="font-size: 8px;'.($data[0]->title == "mr" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Mr.
                  <span style="font-size: 8px;'.($data[0]->title == "ms" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Ms.
                  <span style="font-size: 8px;'.($data[0]->title == "mrs" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Mrs.
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left; width: 8%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  1. Name:
                </p>
              </td>
              <td colspan="2" style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 12px; font-weight: bold;">
                  '.strtoupper($data[0]->lname).'
                </p>
              </td>
              <td colspan="2" style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 12px; font-weight: bold;">
                  '.strtoupper($data[0]->fname).'
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 12px; font-weight: bold;">
                  '.strtoupper($data[0]->mname).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  
                </p>
              </td>
              <td colspan="2" style="text-align: center;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (Family Name)
                </p>
              </td>
              <td colspan="2" style="text-align: center;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (First Name)
                </p>
              </td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (Middlename)
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  2. Mailing Address
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->mailing_address).'
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->barangay).'
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->municipality).'
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->province).'
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.$data[0]->postal_code.'
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->country).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (House No., Street Name, Building)
                </p>
              </td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (Barangay)
                </p>
              </td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (City/Town)
                </p>
              </td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (Province)
                </p>
              </td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (Postal/Zip Code)
                </p>
              </td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 9px; font-weight: regular;">
                  (Country)
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  3. Email:
                </p>
              </td>
              <td style="text-align: left; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.$data[0]->email_address.'
                </p>
              </td>
              <td style="text-align: left; width: 18%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  4. Mobile Phone Number:
                </p>
              </td>
              <td style="text-align: left; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.$data[0]->phone_number.'
                </p>
              </td>
              <td style="text-align: left; width: 10%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  5. Citizenship:
                </p>
              </td>
              <td style="text-align: left; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->citizenship).'
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  6. Present occupation or position:
                </p>
              </td>
              <td colspan="4" style="text-align: left; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->present_occupation).'
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  7. Name & Address of Employment:
                </p>
              </td>
              <td colspan="4" style="text-align: left; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper($data[0]->address_of_employment).'
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  8. College/University Attended Beyond High School (No action will be taken without the original copy of the student’s official transcript of records from each institution attended):
                </p>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td style="text-align: left; width: 10%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  &nbsp;
                </p>
              </td>
              <td colspan="2" style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Institution
                </p>
              </td>
              <td></td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Dates Attended
                </p>
              </td>
              <td></td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Degree Obtained
                </p>
              </td>
              <td></td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  GPA
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Bachelor\'s
                </p>
              </td>
              <td colspan="2" style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 0))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 1)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 2))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 3)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Master\'s
                </p>
              </td>
              <td colspan="2" style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 4))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 5)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 6))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 7)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  Doctorate
                </p>
              </td>
              <td colspan="2" style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 8))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 9)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 10))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 11)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Other
                </p>
              </td>
              <td colspan="2" style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 12))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 13)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->educational_background, 14))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->educational_background, 15)).'
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="9" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  9. References
                  Name and contact details of two (for master\'s degree applicants) of three (for PhD applicants) persons, preferably professors, supervisors, or professionals under whom you have worked or studied. The individuals will be conducted directly by the Office of Admissions. Please provide accurate contact information                    
                </p>
              </td>
            </tr>
          </table>
          
          <table class="table">
            <tr>
              <td style="text-align: center; width: 17%; padding-bottom: 35px; vertical-align: top;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Name(s)
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Nature of relationship <br> with the referee
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Affiliation <br> (Please do not abbreviate)                
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Position/Job Title
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Corporate Email Address
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; vertical-align: top;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Mobile Phone Number
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 0))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 1))).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 2))).'            
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 3))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->reference, 4)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->reference, 5)).' 
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 6))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 7))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 8))).'             
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 9))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->reference, 10)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->reference, 11)).' 
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 12))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 13))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 14))).'             
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.strtoupper(($this->getParseDelimetedData($data[0]->reference, 15))).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->reference, 16)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->reference, 17)).' 
                </p>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td colspan="7" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  10. Language Proficiency: (please rate yourself excellent, good, fair or poor)
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  
                </p>
              </td>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Language
                </p>
              </td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Reading Skills
                </p>
              </td>
              <td></td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Writing Skills
                </p>
              </td>
              <td></td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Speaking Skills
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left; padding-bottom: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  &nbsp;
                </p>
              </td>
              <td style="text-align: left; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  a. English
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 0)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 1)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 2)).' 
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  &nbsp;
                </p>
              </td>
              <td style="text-align: left; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  b. Filipino
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 3)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 4)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 5)).' 
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  &nbsp;
                </p>
              </td>
              <td style="text-align: left; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  c. Others
                </p>
              </td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 6)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 7)).' 
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000; vertical-align: bottom;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->languange_proficiency, 8)).' 
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="7" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  11. Have you previously applied for admission to a graduate program in CLSU?
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  &nbsp;
                </p>
              </td>
              <td style="text-align: left; vertical-align: bottom; width: 10%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  If yes, when 
                </p>
              </td>
              <td colspan="2" style="text-align: left; vertical-align: bottom; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->graduate_program_applied, 0) == "true" ? ($this->getParseDelimetedData($data[0]->graduate_program_applied, 1)) : "").'
                </p>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  12. Teaching and Other Experiences:
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Position
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Agency
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Inclusive Dates
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 0)).' 
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 1)).'
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 2)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 3)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 4)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 5)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 6)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 7)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->teaching_experience, 8)).'
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  13. Published materials (not more than three), give the title, name of journal, year and pages of the three most recent published article.                  
                </p>
              </td>
            </tr>
          </table>
          
          <table class="table">
            <tr>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Title
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Name of Journal
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Year
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Page
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 0)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 1)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 2)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 3)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 4)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 5)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 6)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 7)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 8)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 9)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 10)).'
                </p>
              </td>
              <td>&nbsp;&nbsp;</td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: bold;">
                  '.($this->getParseDelimetedData($data[0]->publish_materials, 11)).'
                </p>
              </td>
            </tr>
          </table>

          <table class="table">
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  14. Academic honors, awards, certificate, or honorary scholarship you have received: 
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Kind
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Award Institution/Agency
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Date
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 0)).'
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 1)).'
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 2)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 3)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 4)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 5)).'
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 6)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 7)).'
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.($this->getParseDelimetedData($data[0]->academic, 8)).'
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  15. Brief account of future plans upon completion of your graduate studies at the Central Luzon State University.               
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular; width: 100%;">
                  '.$data[0]->future_plan.'    
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  16. Expected source and amount of financial support for your travel and study in this University.            
                </p>
              </td>
            </tr>
            <tr>
              <td colspan="5" style="border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular; width: 100%;">
                  '.$data[0]->expected_source.'               
                </p>
              </td>
            </tr>
          </table>  

          <table class="table">
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  17. When do you wish to begin studies in this University?           
                </p>
              </td>
            </tr>
            <tr>
              <td style="width: 10%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular; width: 100%;">
                  School Year:  '.$data[0]->school_year.'             
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left; padding-bottom: 20px; width: 50%;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Semester:
                </p>
                <p style="font-family: roboto; font-size: 11px;">
                  <span style="font-size: 8px;'.($data[0]->semester == 1 ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 1<sup>st</sup> Semester
                  <span style="font-size: 8px;'.($data[0]->semester == 2 ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 2<sup>nd</sup> Semester
                </p>
              </td>
              <td></td>
              <td>
                
              </td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td colspan="5" style="padding-top: 10px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  18. I certify that the information submitted in this application form is accurate:    
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td style="padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td style="padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td colspan="2" style="border-bottom: 1px solid #000; padding-top: 20px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  '.strtoupper($data[0]->fname).' '.strtoupper($data[0]->mname).' '.strtoupper($data[0]->lname).'
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td colspan="2" style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  (Signature over printed name)
                </p>
              </td>
            </tr>
            <tr>
              <td style="padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td style="padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td style="padding-top: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td colspan="2" style="border-bottom: 1px solid #000; padding-top: 20px; text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                '.strtoupper(date("F j, Y", strtotime($data[0]->date_created))).'
                </p>
              </td>
            </tr>
            <tr>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td>
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                      
                </p>
              </td>
              <td colspan="2" style="text-align: center;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  (Date)
                </p>
              </td>
            </tr>
          </table>
          
    ';

    $mpdf->SetHTMLFooter('
      <table width="100%">
          <tr>
              <td style="font-family: roboto; font-size: 8px; font-style: italic;">ACA.OAD.YYY.F.133 (Revision No. 1; May 23, 2023)</td>
          </tr>
      </table>
    ');
    
    $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
    $mpdf->WriteHTML($html); //HTML Content goes here.
    $mpdf->Output('application-form.pdf', 'I');
    // $mpdf->Output();
  }

  public function applicationInfo($applicationID = "")
  {
    $applicationData = $this->admission_application->getApplication($applicationID);

    $this->admissionApplicationForm($applicationData);
  }

  public function emailRefrence($emailAddress = array(), $applicantName = "", $referenceName = array(), $applicantID = "", $courseInfo = "")
  {
    $mail = new PHPMailer(true);
    $output = array();
    $msg = array();
    $htmlContent = '
      <html>
        <body style="margin 0 auto;">
        
        <div style="margin: 0 auto; display: flex; justify-content: center; flex-direction: row; font-family: sans-serif; border: 4px dashed #636e72; padding: 10px;">
        <div>
          <h2 style="color: #fff; background-color: #00b894; padding: 10px; text-align: center;">GRADUATE-LEVEL APPLICATION FOR ADMISSION</h2>
          <p>Dear [References Name],</p>
          <p>
              I hope this letter finds you well. I am writing to request your assistance as a reference for my job search. As someone who knows me and my work well, I believe that your endorsement could be a valuable asset in helping me secure my application for admission.
            </p>
          <p>
              If you would be willing to serve as a reference for me, please let me know if there is any additional information or documentation that you need from me to make the process smoother.
            </p>
          <p>
              I am grateful for all of the support you have provided me over the years, and I greatly appreciate your willingness to serve as a reference. Please let me know if there is anything that I can do to return the favor in the future.
            </p>
          <p>
              Thank you for your consideration.
            </p>
          <p>
              Sincerely,
            </p>
          <p>
              [Your Name]
            </p>
            <br>
            <br>
            <br>
            <h3 style="text-align: center;"><a href="javascript:void(0)" style="color: #fff; background-color: #00b894; padding: 15px;">Reference Form</a></h3>
            <br>
            <h3 style="text-align: center;"><a href="javascript:void(0)" style="color: #fff; background-color: #e17055; padding: 15px;">REJECT</a></h3>
        </div>
        </div>
        
        </body>
      </html>
    ';

    for ($i=0; $i < count($emailAddress); $i++) 
    { 
      try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        //$mail->isSendmail();
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                     //Set the SMTP server to send through 
        $mail->Username   = 'clsuoad.noreply@clsu2.edu.ph';                     //SMTP username
        $mail->Password   = 'AD315510N5';                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
  
        //Recipients
        $mail->setFrom('clsuoad.noreply@clsu2.edu.ph', 'OFFICE OF ADMISSIONS');
        $mail->addAddress($emailAddress[$i]);
        
        // //Set CC address
        // $mail->addCC($applicantEmail, $applicantName);
  
        //Set BCC address
        // $mail->addBCC($emailAddress[$i], $referenceName[$i]);
        // $mail->addReplyTo($applicantEmail, $applicantEmail);     //Add a recipient
  
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recommendation letter for '.$applicantName;
  
        $htmlContent  = '
          <html>
            <body style="margin 0 auto;">
            
              <div style="margin: 0 auto; display: flex; justify-content: center; flex-direction: row; font-family: sans-serif; border: 4px dashed #636e72; padding: 10px;">
                <div>
                    <h2 style="color: #fff; background-color: #00b894; padding: 10px; text-align: center;">GRADUATE-LEVEL APPLICATION FOR ADMISSION</h2>
                    <p>Dear '.$referenceName[$i].',</p>
                    <p>
                      Mr./Ms. '.$applicantName.' is applying for admission to the <b>'.strtoupper($courseInfo).'</b> in our university.  He/she has identified you in his/her application as a former professor, thesis adviser or work supervisor who can provide us with relevant recommendation.
                    </p>
                    <p>
                      We will appreciate it very much if you can provide us with an assessment of the applicant\'s intellectual capacity, readiness for graduate studies, emotional maturity and potential for success.  After clicking the “Reference Form” button below you will be redirected to the online reference form.
                    </p>
                    <p>
                      If you do not want to be involved in the admission application of Mr./Ms. '.$applicantName.', kindly click the "Refuse" button.
                    </p>
                    <p>
                      Thank you very much.
                    </p>
                    <br>
                    <br>
                    <p>
                      Very truly yours,
                    </p>
                    <br>
                    <br>
                    <p>
                      '.$applicantName.'
                    </p>
                    <br>
                    <br>
                    <br>
                    <h3 style="text-align: center;">'.anchor('/admission_application/reference/'.$applicantID.'/'.$emailAddress[$i], 'Reference Form', array('title' => 'Reference Form', 'style' => 'color: #fff; background-color: #00b894; padding: 15px;')).'</h3>
                    <br>
                    <h3 style="text-align: center;">'.anchor('/admission_application/refuseApplication/'.$applicantID.'/'.$emailAddress[$i], 'Refuse', array('title' => 'Refuse', 'style' => 'color: #fff; background-color: #e17055; padding: 15px;')).'</h3>
                </div>
              </div>
            </body>
          </html>`
        ';
        
        $mail->Body    = $htmlContent;
            
        $email_sent = $mail->send();
        $msg = array(
          "error" =>  $email_sent,
          "email" =>  $emailAddress[$i],
          "referenceName" =>  $referenceName[$i]
        );
        $mail->clearAddresses();
        
      } catch (Exception $e) 
      {
        $msg = array(
          "error" =>  $mail->ErrorInfo,
          "email" =>  $emailAddress[$i],
          "referenceName" =>  $referenceName[$i]
        );
        // $msg .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
      
      array_push($output, $msg);
    }

    return $output;
  }

  public function emailVerification($verificationCode = "", $emailAddress = "")
  {
    $mail = new PHPMailer(true);
    $output = array();
    try 
    {
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      //$mail->isSendmail();
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                     //Set the SMTP server to send through 
      $mail->Username   = 'clsuoad.noreply@clsu2.edu.ph';                     //SMTP username
      $mail->Password   = 'AD315510N5';                              //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('clsuoad.noreply@clsu2.edu.ph', 'OFFICE OF ADMISSIONS');
      $mail->addAddress($emailAddress);
      
      // //Set CC address
      // $mail->addCC($applicantEmail, $applicantName);

      //Set BCC address
      // $mail->addBCC($emailAddress[$i], $referenceName[$i]);
      // $mail->addReplyTo($applicantEmail, $applicantEmail);     //Add a recipient

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'Track Application | Admission Application';

      $htmlContent  = '
        <html>
          <body style="margin 0 auto;">
          
            <div style="margin: 0 auto; display: flex; justify-content: center; flex-direction: row; font-family: sans-serif; border: 4px dashed #636e72; padding: 10px;">
              <div>
                  <h2 style="color: #fff; background-color: #00b894; padding: 10px; text-align: center;">GRADUATE-LEVEL APPLICATION FOR ADMISSION</h2>
                  <br>
                  <br>
                  <h3 style="text-align: center;">'.anchor('/admission-verification/'.$verificationCode, 'Track Application', array('title' => 'Track Application', 'style' => 'color: #fff; background-color: #00b894; padding: 15px;')).'</h3>
              </div>
            </div>
          </body>
        </html>`
      ';
      
      $mail->Body = $htmlContent;
          
      $email_sent = $mail->send();
      $msg = array(
        "error" =>  $email_sent,
        "email" =>  $emailAddress
      );
      $mail->clearAddresses();
      
    } catch (Exception $e) 
    {
      $msg = array(
        "error" =>  $mail->ErrorInfo,
        "email" =>  $emailAddress
      );
      // $msg .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    array_push($output, $msg);
    return $output;
  }

  public function resendReference()
  {
    $referenceEmail = $_POST['referenceEmail'];
    $applicantName = $_POST['name'];
    $referenceName = $_POST['referenceName'];
    $applicantID = $_POST['appID'];

    $mail = new PHPMailer(true);
    $output = array();
    $msg = array();
    $htmlContent = '';

    

    try 
    {
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      //$mail->isSendmail();
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                     //Set the SMTP server to send through 
      $mail->Username   = 'clsuoad.noreply@clsu2.edu.ph';                     //SMTP username
      $mail->Password   = 'AD315510N5';                              //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('clsuoad.noreply@clsu2.edu.ph', 'OFFICE OF ADMISSIONS');
      $mail->addAddress($referenceEmail);
      
      // //Set CC address
      // $mail->addCC($applicantEmail, $applicantName);

      //Set BCC address
      // $mail->addBCC($emailAddress[$i], $referenceName[$i]);
      // $mail->addReplyTo($applicantEmail, $applicantEmail);     //Add a recipient

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'OAD | Admission Application';

      $htmlContent  = '
        <html>
          <body style="margin 0 auto;">
          
            <div style="margin: 0 auto; display: flex; justify-content: center; flex-direction: row; font-family: sans-serif; border: 4px dashed #636e72; padding: 10px;">
              <div>
                  <h2 style="color: #fff; background-color: #00b894; padding: 10px; text-align: center;">GRADUATE-LEVEL APPLICATION FOR ADMISSION</h2>
                  <p>Dear '.$referenceName.',</p>
                  <p>
                    Mr./Ms. '.$applicantName.' is applying for admission to the <program> in our university.  He/she has identified you in his/her application as a former professor, thesis adviser or work supervisor who can provide us with relevant recommendation.
                  </p>
                  <p>
                    We will appreciate it very much if you can provide us with an assessment of the applicant\'s intellectual capacity, readiness for graduate studies, emotional maturity and potential for success.  After clicking the “Reference Form” button below you will be redirected to the online reference form.
                  </p>
                  <p>
                    If you do not want to be involved in the admission application of Mr.Ms. '.$applicantName.', kindly click the "Refuse" button.
                  </p>
                  <p>
                    Thank you very much.
                  </p>
                  <br>
                  <br>
                  <p>
                    Very truly yours,
                  </p>
                  <br>
                  <br>
                  <p>
                    '.$applicantName.'
                  </p>
                  <br>
                  <br>
                  <br>
                  <h3 style="text-align: center;">'.anchor('/admission_application/reference/'.$applicantID.'/'.$referenceEmail, 'Reference Form', array('title' => 'Reference Form', 'style' => 'color: #fff; background-color: #00b894; padding: 15px;')).'</h3>
                  <br>
                  <h3 style="text-align: center;">'.anchor('/admission_application/refuseApplication/'.$applicantID.'/'.$referenceEmail, 'Refuse', array('title' => 'Refuse', 'style' => 'color: #fff; background-color: #e17055; padding: 15px;')).'</h3>
              </div>
            </div>
          </body>
        </html>`
      ';
      
      $mail->Body    = $htmlContent;
          
      $email_sent = $mail->send();
      if ($email_sent === true)
      {
        $emailLogsData = array(
          "status"    =>  1,
          "modified"  =>  date("Y-m-d H:i:s")
        );

        $condition = array(
          "application_id"  =>  $applicantID,
          "email"           =>  $referenceEmail
        );

        $this->admission_application->updateAdmission($emailLogsData, $condition, array('oad0004'));
      }
      $msg = array(
        "error" =>  $email_sent,
        "email" =>  $referenceEmail
      );
      $mail->clearAddresses();
      
    } catch (Exception $e) 
    {
      $msg = array(
        "error" =>  $mail->ErrorInfo,
        "email" =>  $referenceEmail
      );
      // $msg .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    array_push($output, $msg);

    echo json_encode($output);
  }

  public function referenceResponse($data = array(), $referenceEmail = "")
  {
    $mail = new PHPMailer(true);
    $output = array();
    $msg = array();
    $htmlContent = '';
    $htmlTable = "";
    // $reference = array(
    //   "applicant_id"                         =>  $_POST['applicantID'],
    //   "applicant_capacity"                   =>  $this->getArr($_POST['question_1']),
    //   "applicant_amplitude"                  =>  $_POST['question_2'],
    //   "applicant_scholastic"                 =>  $_POST['question_3'],
    //   "applicant_potential_professional"     =>  $_POST['question_4'],
    //   "others"                               =>  $_POST['question_5'],
    //   "others"                               =>  $_POST['question_5'],
    //   "reference_name"                       =>  $_POST['reference_name'],
    //   "reference_relationship"               =>  $_POST['reference_relationship'],
    //   "reference_affiliation"                =>  $_POST['reference_affiliation'],
    //   "reference_position"                   =>  $_POST['reference_position'],
    //   "reference_number"                     =>  $_POST['reference_number'],
    //   "created"                              =>  date("Y-m-d H:i:s"),
    //   "modified"                             =>  date("Y-m-d H:i:s")
    // );

    $htmlTable .= '<table border="1">';
    $htmlTable .= '<tbody>';
    
      $htmlTable .= '<tr>';
        $htmlTable .= '<td>'.$data['applicant_capacity'].'</td>';
      $htmlTable .= '</tr>';
      
      $htmlTable .= '<tr>';
        $htmlTable .= '<td>'.$data['applicant_amplitude'].'</td>';
      $htmlTable .= '</tr>';
      
      $htmlTable .= '<tr>';
        $htmlTable .= '<td>'.$data['applicant_scholastic'].'</td>';
      $htmlTable .= '</tr>';
      
      $htmlTable .= '<tr>';
        $htmlTable .= '<td>'.$data['applicant_potential_professional'].'</td>';
      $htmlTable .= '</tr>';

      $htmlTable .= '<tr>';
        $htmlTable .= '<td>'.$data['others'].'</td>';
      $htmlTable .= '</tr>';
      
    $htmlTable .= '</tbody>';
    $htmlTable .= '</table>';

    try 
    {
      //Server settings
      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
      $mail->isSMTP();                                            //Send using SMTP
      //$mail->isSendmail();
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                     //Set the SMTP server to send through 
      $mail->Username   = 'clsuoad.noreply@clsu2.edu.ph';                     //SMTP username
      $mail->Password   = 'AD315510N5';                              //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('clsuoad.noreply@clsu2.edu.ph', 'OFFICE OF ADMISSIONS');
      $mail->addAddress($referenceEmail);
      
      // //Set CC address
      // $mail->addCC($applicantEmail, $applicantName);

      //Set BCC address
      // $mail->addBCC($emailAddress[$i], $referenceName[$i]);
      // $mail->addReplyTo($applicantEmail, $applicantEmail);     //Add a recipient

      //Content
      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'OAD | Reference Response';

      $htmlContent  = '
        <html>
          <body style="margin 0 auto;">
          
            <div style="margin: 0 auto; display: flex; justify-content: center; flex-direction: row; font-family: sans-serif; border: 4px dashed #636e72; padding: 10px;">
              <div>
                  <h2 style="color: #fff; background-color: #00b894; padding: 10px; text-align: center;">GRADUATE-LEVEL APPLICATION FOR ADMISSION</h2>
                  <p>My Response</p>
                  '.$htmlTable.'
              </div>
            </div>
          </body>
        </html>`
      ';
      
      $mail->Body    = $htmlContent;
          
      $email_sent = $mail->send();
      if ($email_sent === true)
      {
        $msg = array(
          "error" =>  $email_sent,
          "email" =>  $referenceEmail
        );
      }
      
      $mail->clearAddresses();
      
    } catch (Exception $e) 
    {
      $msg = array(
        "error" =>  $mail->ErrorInfo,
        "email" =>  $referenceEmail
      );
      // $msg .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
    array_push($output, $msg);

    return $output;
  }

  public function generateNoa()
  {
    $applicantID = $_POST['applicantID'];
    $registrationSchedule = $_POST['regSched'];
    $classStart = $_POST['classStart'];
    $nonClsuGrad = $_POST['nonClsuGrad'];

    $applicantData = $this->admission_application->get_applicant_noa($applicantID);
    $output = array();
    foreach($applicantData as $applicant)
    {
      array_push($output, $applicant->title); // [0]
      array_push($output, $applicant->fname); // [1]
      array_push($output, $applicant->mname); // [2]
      array_push($output, $applicant->lname); // [3]
      array_push($output, $applicant->barangay); // [4]
      array_push($output, $applicant->municipality); // [5]
      array_push($output, $applicant->province); // [6]
      array_push($output, $applicant->department_remarks); // [7]
      array_push($output, $applicant->department_note); // [8]
      array_push($output, $applicant->dean_remarks); // [9]
      array_push($output, $applicant->dean_note); // [10]
      array_push($output, $applicant->course_desc); // [11]
      array_push($output, ($applicant->semester == 1 ? "First Semester ".$applicant->school_year : "Second Semester ".$applicant->school_year)); // [12]
      array_push($output, $registrationSchedule); // [13]
      array_push($output, $classStart); // [14]
      array_push($output, $nonClsuGrad); // [15]
      array_push($output, $applicant->department_status); // [16]
      array_push($output, $applicant->dean_status); // [17]
    }

    $this->processNoa($output);
  }

  public function processNoa($data = array())
  {
    // if (count($data) == 0)
    // {
    //   $data = array(
    //     "code"        =>  "404",
    //     "msg"         =>  "Application not found, please contact OFFICE OF ADMISSIONS (OAD)",
    //     "link"        =>  "javascript:void(0)",
    //     "homepageBTN" =>  "APPLICATION VERIFICATION"
    //   );

    //   $this->load->view('err/custom_error', $data);
    //   return;
    // }

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new \Mpdf\Mpdf([
          'mode'          => 'utf-8',
          'format'        => "A4", //in cm
          'orientation'   => 'P',
          'margin_top'    => '15',
          'margin_bottom' => '50',
          'fontDir'       => array_merge($fontDirs, [
                                  'custom/font/directory',
                          ]),
          'fontdata'      => $fontData + [
              'roboto' => [ 
                  'R' => 'Roboto-Regular.ttf'
              ],
              'londrina' => [
                  'R' => 'LondrinaOutline-Regular.ttf'
              ],
              'stoicheion' => [
                  'R' => 'Stoicheion-2Od3X.ttf'
              ],
              'villona' => [
                  'R' => 'Vilona-mLL45.ttf'
              ]
          ],
          'default_font' => 'roboto'
    ]);
    $stylesheet = file_get_contents('assets/plugins/bootstrap/css/bootstrap.css');

    $html = ""; 
    /**
     * Header
     */
    $html .= '
          <table style="margin-bottom: 0; width: 100%;">
            <tr>
              <td style="text-align: right; width: 30%;">
                <img src="assets/images/logo.png" width="80" />
              </td>
              <td style="text-align: center; vertical-align: top; padding-top: 15px; width: 10%;">
                <p style="font-family: roboto; font-size: 12px; font-weight: regular;">Republic of the Philippines</p>
                <p style="font-family: roboto; font-size: 12px; font-weight: bold;">CENTRAL LUZON STATE UNIVERSITY</p>
                <p style="font-family: roboto; font-size: 12px; font-weight: regular;">Science City of Muñoz, Nueva Ecija</p>
              </td>
              <td style="text-align: right; width: 30%;">

              </td>
            </tr>
            <tr>
              <td style="text-align: right; width: 30%;"></td>
              <td style="text-align: center; padding-bottom: 25px;">
                <p style="font-family: roboto; font-size: 12px; font-weight: regular;">OFFICE OF ADMISSIONS</p>
              </td>
              <td style="text-align: right; width: 30%;"></td>
            </tr>
            <tr>
              <td style="text-align: right; width: 30%;"></td>
              <td style="text-align: center;">
                <p style="font-family: roboto; font-size: 12px; font-weight: bold;">NOTICE OF ADMISSION</p>
              </td>
              <td style="text-align: right; width: 30%;"></td>
            </tr>
          </table>

          <table border="1" style="margin-bottom: 0; width: 100%;">
          </table>
    ';
    /**
     * END OF HEADER
     */
    $html .= '
      <table style="margin-bottom: 0; width: 100%; margin-top: 36px;">
        <tr>
          <td style="text-align: left;">
            <p style="font-family: roboto; font-size: 12px; font-weight: regular;">
              '.(date('F j, Y')).'
            </p>
          </td>
        </tr>
      </table>
      <table style="margin-bottom: 0; width: 100%; margin-top: 36px;">
        <tr>
          <td style="text-align: left;">
            <p style="font-family: roboto; font-size: 12px; font-weight: regular;">
              '.$data[0].'
            </p>
          </td>
        </tr>
      </table>
    ';
    /**
     * CONTENT
     */

    /**
     * END OF CONTENT
     */
    $mpdf->SetHTMLFooter('
      <table width="100%">
          <tr>
              <td style="font-family: roboto; font-size: 8px; font-style: italic;">ACA.OAD.YYY.F.133 (Revision No. 1; May 23, 2023)</td>
          </tr>
      </table>
    ');
    
    $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
    $mpdf->WriteHTML($html); //HTML Content goes here.
    $mpdf->Output('application-form.pdf', 'I');
    // $mpdf->Output();
  }
}


/* End of file Application.php */
/* Location: ./application/controllers/Admission_application */