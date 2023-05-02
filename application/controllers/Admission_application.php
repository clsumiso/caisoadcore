<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admission_application extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model("admission_application_model", "admission_application");
<<<<<<< HEAD
    $this->load->library('upload'); 
=======
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
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

<<<<<<< HEAD
  public function grad_admission_verification()
  {
    # code...
  }

=======
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
  public function courseList()
  {
    $courseData = $this->admission_application->gerGraduateProgram(array("MS", "MA", "PhD"));
    $htmlData = "";
    foreach ($courseData as $data) 
    {
      $htmlData .= '<option value='.$data->course_id.'>'.strtoupper($data->course_desc).' ('.$data->course_name.')</option>';
    }

    return $htmlData;
  }

  public function submitApplication()
  {
    $data = $_POST;
    $msg = array();
<<<<<<< HEAD
    $generatedApplicantID = $this->generateApplicantID(50);

    $count = count($_FILES['gradAttachment']['name']);
    $directoryName = "";
    $directories = array("TOR", "GWA", "IMG");
    $tor_file = "";
    $gwa_file = "";
    $img_file = "";
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
        $config['allowed_types'] = 'jpg|jpeg|JPG|JPEG|pdf|PDF';
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

    $arrData = array(
      "application_id"              =>  $generatedApplicantID,
=======

    $arrData = array(
      "application_id"              =>  $this->generateApplicantID(50),
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
      "enroll_degree"               =>  $data['question_1'] == "true" ? 1 : 0,
      "enroll_grad_program"         =>  $data['question_2'] == "true" ? 1 : 0,
      "degree_program_applied"      =>  $data['question_3'],
      "field_of_study"              =>  $data['question_4'],
      "title"                       =>  $data['question_5'],
      "lname"                       =>  $data['question_6'],
      "fname"                       =>  $data['question_7'],
      "mname"                       =>  $data['question_8'],
      "mailing_address"             =>  $data['question_9'],
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
      "address_of_employment"       =>  $data['question_20'],
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
<<<<<<< HEAD
      "tor_file"                    =>  $tor_file,
      "gwa_file"                    =>  $gwa_file,
      "img_file"                    =>  $img_file,
=======
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
      "date_created"                =>  date("Y-m-d H:i:s")
    );

    $save = $this->admission_application->save("oad0001", $arrData);
    if ($save !== false) 
    {
      $msg = array(
        "sys_msg" =>  "success",
        "msg"     =>  "Applcation submitted successfully",
        "type"    =>  "success"
      );
    }else
    {
      $msg = array(
        "sys_msg" =>  "failed",
        "msg"     =>  "Applcation submitted failed",
        "type"    =>  "error"
      );
    }
    echo json_encode($msg);
  }

<<<<<<< HEAD
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

=======
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
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
<<<<<<< HEAD
      $data = array(
        "code"        =>  "404",
        "msg"         =>  "Application not found, please contact OFFICE OF ADMISSIONS (OAD)",
        "link"        =>  "javascript:void(0)",
        "homepageBTN" =>  "APPLICATION VERIFICATION"
      );

      $this->load->view('err/custom_error', $data);
=======
      $this->load->view('err/custom_error');
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
      return;
    }

    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new \Mpdf\Mpdf([
          'mode'          => 'utf-8',
          'format'        => 'LEGAL', //in cm
          'orientation'   => 'P',
          'margin_top'    => '15',
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
    // Define the Header/Footer before writing anything so they appear on the first page
    // $mpdf->SetHTMLHeader('
    //   <table class="table" style="margin-bottom: 0;">
    //     <tr>
    //       <td style="text-align: right; width: 18%;">
    //         <img src="assets/images/logo.png" width="96" />
    //       </td>
    //       <td style="text-align: center; vertical-align: top; padding-top: 35px; width: 10%;">
    //         <p style="font-family: roboto; font-size: 11px; font-weight: regular;">Republic of the Philippines</p>
    //         <p style="font-family: roboto; font-size: 11px; font-weight: bold;">CENTRAL LUZON STATE UNIVERSITY</p>
    //         <p style="font-family: roboto; font-size: 11px; font-weight: regular;">Science City of Muñoz, Nueva Ecija</p>
    //       </td>
    //       <td style="text-align: right; width: 20%;">
    //         <img src="assets/images/passport-photo.png" style="width: 1.3in; height; 1.7in; border: 1px solid #000;" />
    //       </td>
    //     </tr>
    //   </table>
    // ', 'O');
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
                <img src="assets/images/passport-photo.png" style="width: 1.3in; height; 1.7in; border: 1px solid #000;" />
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

          <table class="table table-bordered">
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
                  Test
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
              <td></td>
              <td style="padding-top: 10px; text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
                </p>
              </td>
              <td></td>
              <td style="text-align: center; border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Test
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
                  Test    
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
                  Test              
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
                  School Year:               
                </p>
              </td>
              <td style="border-bottom: 1px solid #000;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular; width: 100%;">
                  Test            
                </p>
              </td>
            </tr>
            <tr>
              <td style="text-align: left; padding-bottom: 20px;">
                <p style="font-family: roboto; font-size: 11px; font-weight: regular;">
                  Semester:
                </p>
                <p style="font-family: roboto; font-size: 11px;">
                  <span style="font-size: 8px;background-color: #000; border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 1<sup>st</sup> Semester
                  <span style="font-size: 8px;background-color: #fff; border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 2<sup>nd</sup> Semester
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
                  Test
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
                  Test
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
              <td style="font-family: roboto; font-size: 8px; font-style: italic;">ACA.OAD.YYY.F.133 (Revision No. 0; January 5, 2023)</td>
          </tr>
      </table>
    ');
    
    $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.
    $mpdf->WriteHTML($html); //HTML Content goes here.
    // $mpdf->Output('application-form.pdf', 'D');
    $mpdf->Output();
  }

  public function applicationInfo($applicationID = "")
  {
    $applicationData = $this->admission_application->getApplication($applicationID);

    $this->admissionApplicationForm($applicationData);
  }

}


/* End of file Application.php */
<<<<<<< HEAD
/* Location: ./application/controllers/Admission_application */
=======
/* Location: ./application/controllers/Application.php */
>>>>>>> 8f4e08ab01c3fc6313cfa008ebea363e0fb9eb21
