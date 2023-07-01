<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Department extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('date');
    $this->load->model('department_model', 'department');
    $this->load->model("admission_application_model", "admission_application");
    $this->load->model('admissions_model', 'admissions');
    $this->load->model('administrator_model', 'administrator');
    $this->load->model('faculty_model', 'faculty');
  }

  public function index()
  {
    if (!isset($_SESSION['uid'])) 
    {
      redirect('/');
    }else
    {
      if (isset($_SESSION['utype']))
      {
        if ($_SESSION['utype'] != "department head")
        {
          redirect('/');
        }
      }else
      {
        redirect('/');
      }
    }

    $data = array(
     'name'				=>	$_SESSION['account_name'],
     'user_type'		=>	strtoupper($_SESSION['utype']),
     'email'				=>	$_SESSION['e_id'],
     'get_time'		=>	$this->get_time(),
     "semester"    => $this->semester(),
   );

    $this->load->view('department/_header', $data);
    $this->load->view('department/_css', $data);
    $this->load->view('department/department_view', $data);
    $this->load->view('department/_footer', $data);
    $this->load->view('department/_js', $data);
  }

  public function semester()
  {
    $semester = $this->administrator->getSemester();
    $html_data = '<option value="#" selected>-- SELECT SEMESTER --</option>';
    foreach ($semester as $sem) {
      if (isset($_SESSION['class_rec_sem_filter'])) {
        if ($sem->semester_id == $_SESSION['class_rec_sem_filter']) {
          $html_data .= '<option value="'.$sem->semester_id.'" selected>'.$sem->semester_name.' '.$sem->semester_year.'</option>';
        }else{
          $html_data .= '<option value="'.$sem->semester_id.'">'.$sem->semester_name.' '.$sem->semester_year.'</option>';
        }
      }else{
        $html_data .= '<option value="'.$sem->semester_id.'">'.$sem->semester_name.' '.$sem->semester_year.'</option>';
      }
    }

    return $html_data;
  }


  public function get_time()
  {
    $datestring = '%F, %d %Y';
    $time = time();
    return mdate($datestring, $time);
  }

  public function graduateLevelList()
  {
    // POST data
    $postData = $this->input->post();

    $role = $this->validateDepartment($_SESSION['uid']);

		// Get data
    $data = $this->department->getGraduateApplicants($postData, $role);

    echo json_encode($data);
  }

  public function validateDepartment($userID = "")
  {
    $role = 0;
    $roleData = $this->department->getRole($userID);
    foreach ($roleData as $role) 
    {
      $role = $role->role;
    }

    return $role;
  }

  public function applicationInfo()
  {
    $applicationID = $_POST['appID'];
    $applicationData = $this->admission_application->getApplication($applicationID);

    echo $this->admissionApplicationForm($applicationData);
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

    $html = "";
    $eduactional_background = $data[0]->educational_background; 
    $html .= '
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

    return json_encode(array("content"  =>  $html));
  }


  public function viewReferenceForm()
  {
    $referenceID = $_POST['reference'];

    // $applicant_id = $appID;
    $ctr = 1;
    // $applicant_info = $this->applicant->get_applicant_info($applicant_id);
    $referenceInfo = $this->admissions->getReferenceInfo($referenceID);
    $test = '';
    $html = '';

    foreach ($referenceInfo as $reference) 
    {
      $referenceEmail = $this->admissions->getReferenceEmail($reference->reference_name, $reference->applicant_id);
      $html .= '
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      The <b>'.$reference->college_desc.'</b>. will appreciate receiving your evaluation of the applicant\'s aptitude for graduate studies, including his/her scholastic achievements, emotional maturity, and potential for professional success.
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td style="width: 10px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Re:
      </p>
      </td>
      <td style="width: 10px; text-align: center; border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 12px; font-weight: bold;">
      '.$reference->lname.'
      </p>
      </td>
      <td style="width: 10px; text-align: center; border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 12px; font-weight: bold;">
      '.$reference->fname.'
      </p>
      </td>
      <td style="width: 10px; text-align: center; border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 12px; font-weight: bold;">
      '.$reference->mname.'
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 10px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">

      </p>
      </td>
      <td style="width: 10px; text-align: center;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      (Family Name)
      </p>
      </td>
      <td style="width: 10px; text-align: center;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      (First Name)
      </p>
      </td>
      <td style="width: 10px; text-align: center;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      (Middle Name)
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      A.	How long have you known the applicant? In what capacity?
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td style="width: 300px;">
      <p style="font-family: roboto; font-size: 11px;">
      <span style="font-size: 8px;'.(explode("||", $reference->applicant_capacity)[0] == "As his/her professor" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> As his/her professor
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.(explode("||", $reference->applicant_capacity)[0] == "As his/her professor" ? (count(explode("||", $reference->applicant_capacity)) > 1 ? explode("||", $reference->applicant_capacity)[1] : "_____") : "_____" ).' years
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 300px;">
      <p style="font-family: roboto; font-size: 11px;">

      <span style="font-size: 8px;'.( explode("||", $reference->applicant_capacity)[0] == "As his/her thesis adviser" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> As his/her thesis adviser
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.(explode("||", $reference->applicant_capacity)[0] == "As his/her thesis adviser" ? (count(explode("||", $reference->applicant_capacity)) > 1 ? explode("||", $reference->applicant_capacity)[1] : "_____") : "_____" ).' years
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 300px;">
      <p style="font-family: roboto; font-size: 11px;">

      <span style="font-size: 8px;'.( explode("||", $reference->applicant_capacity)[0] == "As his/her employer/supervisor" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> As his/her employer/supervisor
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.(explode("||", $reference->applicant_capacity)[0] == "As his/her employer/supervisor" ? (count(explode("||", $reference->applicant_capacity)) > 1 ? explode("||", $reference->applicant_capacity)[1] : "_____") : "_____" ).' years
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 300px;">
      <p style="font-family: roboto; font-size: 11px;">

      <span style="font-size: 8px;'.( explode("||", $reference->applicant_capacity)[0] == "other" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Other, please specify 
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.(explode("||", $reference->applicant_capacity)[0] == "other" ? (count(explode("||", $reference->applicant_capacity)) > 1 ? explode("||", $reference->applicant_capacity)[1] : "_____") : "_____" ).' years
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      B.	Aptitude for graduate work: (Please provide details of your evaluation)
      </p>
      </td>
      </tr>
      <tr>
      <td style="border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->applicant_amplitude.'
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      C.	Scholastic capability: (Please provide details of your evaluation)
      </p>
      </td>
      </tr>
      <tr>
      <td style="border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->applicant_scholastic.'
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      D.	Emotional maturity: (Please provide details of your evaluation)
      </p>
      </td>
      </tr>
      <tr>
      <td style="border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">

      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      E.	Potential for professional success: (Please provide details of your evaluation)
      </p>
      </td>
      </tr>
      <tr>
      <td style="border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->applicant_potential_professional.'
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; padding-top: 10px;">
      <tr>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      F.	Others
      </p>
      </td>
      </tr>
      <tr>
      <td style="border-bottom: 1px solid #000;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->others.'
      </p>
      </td>
      </tr>
      </table>
      <table style="width: 100%; margin-top: 50px;">
      <tr>
      <td style="width: 120px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Reference Name:
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->reference_name.'
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 120px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Relationship to the Applicant:
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->reference_relationship.'
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 120px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Affiliation:
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->reference_affiliation.'
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 120px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Position:
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->reference_position.'
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 120px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Reference Email:
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.(count($referenceEmail) > 0 ? $referenceEmail[0]->email : "***" ).'
      </p>
      </td>
      </tr>
      <tr>
      <td style="width: 120px;">
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      Reference Contact:
      </p>
      </td>
      <td>
      <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
      '.$reference->reference_number.'
      </p>
      </td>
      </tr>
      </table>
      ';
    }

    echo json_encode(array("content"  =>  $html));
  }

  public function getParseDelimetedData($str = "", $index = 0)
  {
    $parseData = explode("||", $str);

    return count($parseData) > $index ? $parseData[$index] : "N/A";
  }

  public function deanEndorse()
  {
    $applicationID = $_POST['appID'];
    $msg = array();

    $data = array(
      "dean_remarks"       => "pending",
      "department_remarks" =>  "approved_regular",
      "department_status"  => date("Y-m-d H:i:s")
    );

    $condition = array(
      "application_id"  =>  $applicationID
    );

    $endorse = $this->admissions->update($data, $condition, array("oad0003"));
    if ($endorse !== false)
    {
      $msg = array(
        "sys_msg" =>  "success",
        "msg"     =>  "Application forwarded successfully",
        "type"    =>  "success"
      );
    }else
    {
      $msg = array(
        "sys_msg" =>  "failed",
        "msg"     =>  "Application forwarding failed",
        "type"    =>  "error"
      );
    }

    echo json_encode($msg);
  }

  public function department_subject()
  {
    $check_user_info = $this->department->check_user_info($_SESSION['e_id']);
    $department_id  = count($check_user_info) > 0 ? $check_user_info[0]->dept_id : 0;
    $semester = $_POST['semid'];
    $subject_data = $this->department->get_subject($semester, $department_id);
    $_SESSION['class_rec_sem_filter'] = $semester;
    $output = array();
    $data = array();
    $pending = '';
    $filter = $_POST['rog_filter'];
    $i = 1;
    foreach ($subject_data as $subjects) {
      $show_btn = '';
      $student_arr = array('');
      $students = $this->faculty->get_enrolled_student_id($subjects->schedid);
      $teaching_load_data = $this->department->get_teaching_loads($department_id, $subjects->schedid);

      $department_head_status = 0;
      $dean_status = 0;
      $faculty_status = 0;
      $oad_status = 0;

      foreach ($students as $user_id) {
        array_push($student_arr, $user_id->user_id);
      }

              // $teaching_load_key = array_search($subjects->schedid, array_column($teaching_load_data, 'schedid'));

      if (count($teaching_load_data) > 0) 
      {
        $submissions_status = $this->department->get_rog_status($student_arr, $semester, (count($teaching_load_data) > 0 ? $teaching_load_data[0]->user_id : 0), $subjects->cat_no);
        if (count($submissions_status) > 0) 
        {
          foreach ($submissions_status as $submissions) 
          {
            if ($submissions->status == 'department head') 
            {
              $department_head_status++;
            }
            if ($submissions->status == 'dean') 
            {
              $dean_status++;
            }
            if ($submissions->status == 'approved') 
            {
              $oad_status++;
            }
            if ($submissions->status == 'faculty' || $submissions->status == 'pending') 
            {
              $faculty_status++;
            }
          }

          if ($department_head_status > 0) 
          {
            $pending = 'department head';
          }else
          {
            if ($faculty_status > 0)
            {
              $pending = 'faculty';
            }else
            {
              if ($dean_status > 0)
              {
                $pending = 'dean';
              }else
              {
                if ($oad_status > 0) {
                  $pending = 'approved';
                }
              }
            }
          }

                  /*if ($department_head_status > 0) 
                  {
                    $pending = 'department head';
                  }else
                  {
                    if (count($submissions_status) == $dean_status) 
                    {
                      $pending = 'dean';
                    }

                    if (count($submissions_status) == $faculty_status) 
                    {
                      $pending = 'faculty';
                    }

                    if (count($submissions_status) == $oad_status) 
                    {
                      $pending = 'approved';
                    }
                  }*/
                }else
                {
                  $pending = 'no grade submitted';
                }

                // if (count($student_arr) > 0) {
                //     $pending = count() ? $this->department->get_rog_status($student_arr, $semester, $teaching_load_data[0]->user_id, $subjects->cat_no)[0]->status : 'NO GRADE SUBMITTED';
                // }else{
                //     $pending = 'NO GRADE SUBMITTED';
                // }

                if ($pending == 'dean') {
                  $show_btn = '<button class="btn bg-yellow btn-lg" onclick="view_rog(\''.$subjects->schedid.'\', \''.$semester.'\', \''.$subjects->cat_no.'\', \''.$_SESSION['e_id'].'\', \''.$teaching_load_data[0]->user_id.'\')"><i class="fas fa-eye"></i> VIEW</button>';
                }else if($pending == 'department head'){
                  $show_btn = '<button class="btn bg-green btn-lg" onclick="view_rog(\''.$subjects->schedid.'\', \''.$semester.'\', \''.$subjects->cat_no.'\', \''.$_SESSION['e_id'].'\', \''.$teaching_load_data[0]->user_id.'\')"><i class="fas fa-eye"></i> VIEW</button>';
                }else if($pending == 'approved'){
                  $show_btn = '<button class="btn bg-orange btn-lg" onclick="view_rog(\''.$subjects->schedid.'\', \''.$semester.'\', \''.$subjects->cat_no.'\', \''.$_SESSION['e_id'].'\', \''.$teaching_load_data[0]->user_id.'\')"><i class="fas fa-eye"></i> VIEW</button>';
                }else if($pending == 'faculty'){
                  $show_btn = '<span class="text-primary font-weight-bold">FOR SUBMISSION BY FACULTY</span>';
                }else if($pending == 'pending'){
                  $show_btn = '<span class="text-primary font-weight-bold">FOR SUBMISSION BY FACULTY</span>';
                }else{
                  $show_btn = '<span class="text-secondary font-weight-bold">ROG NOT YET SUBMITTED</span>';
                }


                if (count($submissions_status) > 0) 
                {
                  if ($filter == '#' || $filter == '-') 
                  {
                    $data = array(
                      $i++,
                      $show_btn,
                      $subjects->schedid,
                      $subjects->cat_no,
                      $subjects->units,
                      $subjects->time,
                      $subjects->day,
                      $subjects->room,
                      $subjects->section,
                      $teaching_load_data[0]->lname.', '.$teaching_load_data[0]->fname,
                      strtoupper($pending == 'approved' ? 'OFFICE OF ADMISSIONS' : $pending)
                    );
                    array_push($output, $data);
                  }else
                  {
                    if ($pending == $filter) 
                    {
                      $data = array(
                        $i++,
                        $show_btn,
                        $subjects->schedid,
                        $subjects->cat_no,
                        $subjects->units,
                        $subjects->time,
                        $subjects->day,
                        $subjects->room,
                        $subjects->section,
                        $teaching_load_data[0]->lname.', '.$teaching_load_data[0]->fname,
                        strtoupper($pending == 'approved' ? 'OFFICE OF ADMISSIONS' : $pending)
                      );
                      array_push($output, $data);
                    }
                  }
                }else
                {
                  if ($pending == $filter) 
                  {
                    $data = array(
                      $i++,
                      $show_btn,
                      $subjects->schedid,
                      $subjects->cat_no,
                      $subjects->units,
                      $subjects->time,
                      $subjects->day,
                      $subjects->room,
                      $subjects->section,
                      $teaching_load_data[0]->lname.', '.$teaching_load_data[0]->fname,
                      "NO GRADE SUBMITTED"
                    );
                    array_push($output, $data);
                  }
                }
              }
            }
          // Output to JSON format
            echo json_encode(array("data" =>  $output));
          }

          public function returnApplication()
          {
            $applicationID = $_POST['appID'];
            $remarks = $_POST['remarks'];
            $msg = array();

            $data = array(
              "deaprtment_note"     =>  $remarks,
              "department_remarks" => NULL,
              "department_status"  => NULL
            );

            $condition = array(
              "application_id"  =>  $applicationID
            );

            $endorse = $this->admissions->update($data, $condition, array("oad0003"));
            if ($endorse !== false)
            {
              $msg = array(
                "sys_msg" =>  "success",
                "msg"     =>  "Application forwarded successfully",
                "type"    =>  "success"
              );
            }else
            {
              $msg = array(
                "sys_msg" =>  "failed",
                "msg"     =>  "Application forwarding failed",
                "type"    =>  "error"
              );
            }

            echo json_encode($msg);
          }

          public function withdrawApplication()
          {
            $applicationID = $_POST['appID'];
            $remarks = $_POST['remarks'];
            $msg = array();

            $data = array(
              "department_note"     =>  $remarks,
              "department_remarks"  =>  "advised_to_withdraw",
              "department_status"   =>  date("Y-m-d H:i:s")
            );

            $condition = array(
              "application_id"  =>  $applicationID
            );

            $endorse = $this->admissions->update($data, $condition, array("oad0003"));
            if ($endorse !== false)
            {
              $msg = array(
                "sys_msg" =>  "success",
                "msg"     =>  "Application forwarded successfully",
                "type"    =>  "success"
              );
            }else
            {
              $msg = array(
                "sys_msg" =>  "failed",
                "msg"     =>  "Application forwarding failed",
                "type"    =>  "error"
              );
            }

            echo json_encode($msg);
          }

          public function endorseProbationary()
          {
            $applicationID = $_POST['appID'];
            $remarks = $_POST['remarks'];
            $msg = array();

            $data = array(
              "dean_remarks"       => "pending",
              "department_note"     =>  $remarks,
              "department_remarks"  =>  "approved_probationary",
              "department_status"   =>  date("Y-m-d H:i:s")
            );

            $condition = array(
              "application_id"  =>  $applicationID
            );

            $endorse = $this->admissions->update($data, $condition, array("oad0003"));
            if ($endorse !== false)
            {
              $msg = array(
                "sys_msg" =>  "success",
                "msg"     =>  "Application forwarded successfully",
                "type"    =>  "success"
              );
            }else
            {
              $msg = array(
                "sys_msg" =>  "failed",
                "msg"     =>  "Application forwarding failed",
                "type"    =>  "error"
              );
            }

            echo json_encode($msg);
          }

          public function view_rog()
          {
            $student_list_arr = array();
            $output = array();
            $subjects_to_submit = $this->faculty->get_subject_to_submit_by_schedid($_POST['schedid'], $_POST['sem']);
      // $grades_to_submit = $this->faculty->get_grades_to_submit($_POST['sem'], $_POST['faculty_id']);

            foreach ($subjects_to_submit as $student)   
            {
              $grades_to_submit = $this->faculty->get_grades_to_submit($_POST['sem'], $_POST['faculty_id'], $student->user_id, $student->cat_no);
        // $grades_key = array_search($student->user_id, array_column($grades_to_submit, 'user_id'));
              $grades_to_display = '';
              $status_to_display = '';

              if (count($grades_to_submit) > 0) {
                if ($grades_to_submit[0]->status == 'faculty' || $grades_to_submit[0]->status == 'pending') 
                {
                  if ($grades_to_submit[0]->reexam === NULL) 
                  {
                    $grades_to_display = strtoupper($grades_to_submit[0]->status).' ('.$grades_to_submit[0]->grades.')';
                  }else
                  {
                    $grades_to_display = strtoupper($grades_to_submit[0]->status).' ('.$grades_to_submit[0]->reexam.')';
                  }
                  $status_to_display = $grades_to_submit[0]->status;
                }else
                {
                  $grades_to_display = strtoupper($grades_to_submit[0]->status).' ('.($grades_to_submit[0]->reexam === "" ? $grades_to_submit[0]->grades : $grades_to_submit[0]->reexam).')';
                  if (in_array($grades_to_submit[0]->status, array('department head', 'dean'))) 
                  {
                    $status_to_display = $grades_to_submit[0]->status;
                  }else if($grades_to_submit[0]->status == 'approved') 
                  {
                    $status_to_display = 'approved';
                  }
                  else
                  {
                    $status_to_display = '';
                  }
                }
              }else
              {
                $grades_to_display = "NO GRADE SUBMITTED";
              }


        /* if ($grades_to_submit[$grades_key]['user_id'] == $student->user_id) 
        {
          if ($grades_to_submit[$grades_key]['status'] == 'faculty' || $grades_to_submit[$grades_key]['status'] == 'pending') 
          {
            if ($grades_to_submit[$grades_key]['reexam'] === NULL) 
            {
              $grades_to_display = $grades_to_submit[$grades_key]['grades'];
            }else
            {
              $grades_to_display = $grades_to_submit[$grades_key]['reexam'];
            }
            $status_to_display = $grades_to_submit[$grades_key]['status'];
          }else
          {
            $grades_to_display = strtoupper($grades_to_submit[$grades_key]['status']).' ('.($grades_to_submit[$grades_key]['reexam'] === NULL ? $grades_to_submit[$grades_key]['grades'] : $grades_to_submit[$grades_key]['reexam']).')';
            if (in_array($grades_to_submit[$grades_key]['status'], array('department head', 'dean'))) 
            {
              $status_to_display = $grades_to_submit[$grades_key]['status'];
            }else if($grades_to_submit[$grades_key]['status'] == 'approved') 
            {
              $status_to_display = 'approved';
            }
            else
            {
              $status_to_display = '';
            }
          }
        }else
        {
          $grades_to_display = "NO GRADE SUBMITTED";
        } */

        $student_list_arr = array(
          'student_id'  =>  $student->user_id,
          'name'      =>  $student->lname.', '.$student->fname,
          'cat_no'    =>  $student->cat_no,
          'grades'    =>  $grades_to_display,
          'status'    =>  $status_to_display  
        );

        array_push($output, $student_list_arr);
      }
      
      echo json_encode($output);
    }

    public function submit_rog()
    {
      $date_forwarded = date('Y-m-d H:i:s');
      $msg = array();
      $student_arr = array();
      $students = $this->faculty->get_enrolled_student_id($_POST['schedid']);
      foreach ($students as $user_id) {
        array_push($student_arr, $user_id->user_id);
      }
      
      /* ON TIME SUBMISSIONS */
      $data = array(
        'date_dept_approve' =>  $date_forwarded,
        'status'        =>  'dean'
      );

      $condition = array(
        'faculty_id'  =>  $_POST['faculty_id'],
        'subject'   =>  $_POST['cat_no'],
        'semester_id' =>  $_POST['sem']
      );

      $this->department->table = 'tbl_grades';
      $forward = $this->department->submit_rog($data, $condition, $student_arr);
      if ($forward === true) 
      {
        $msg = array(
          'sys_msg' =>  'SUCCESS',
          'icon'    =>  'success',
          'msg'   =>  'Report of grades is successfully forwarded to dean, please check your email for the copy of the submitted report of grades. <strong style="color: red;">Did not receive an email?</strong> <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="resend_email_copyof_rog()"><span id="resend_email_copy_of_rog">resend email</span></a></span>'
        );
      }else
      {
        $msg = array(
          'sys_msg' =>  'FAILED',
          'icon'    =>  'error',
          'msg'   =>  'Failed to forward, please try again.'
        );
      }

      /*if (strtotime(date('Y-m-d H:i:s')) > strtotime(FIRST_SEM_2022_2023_GRADE_DEADLINE)) 
      {
        //LATE SUBMISSIONS
        $msg = array(
            'sys_msg' =>  'FAILED',
            'icon'    =>  'warning',
            'msg'   =>  'SUBMISSION IS LATE'
          );
      }else
      {
        
      }*/

      echo json_encode($msg);
    }

    public function return_rog()
    {
      $date_forwarded = date('Y-m-d H:i:s');
      $msg = array();
      $student_arr = array();
      $students = $this->faculty->get_enrolled_student_id($_POST['schedid']);
      foreach ($students as $user_id) {
        array_push($student_arr, $user_id->user_id);
      }
      
      /* ON TIME SUBMISSIONS */
      $data = array(
        'status'        =>  'faculty'
      );

      $condition = array(
        'faculty_id'  =>  $_POST['faculty_id'],
        'subject'   =>  $_POST['cat_no'],
        'semester_id' =>  $_POST['sem']
      );

      $this->department->table = 'tbl_grades';
      $forward = $this->department->submit_rog($data, $condition, $student_arr);
      if ($forward === true) 
      {
        $msg = array(
          'sys_msg' =>  'SUCCESS',
          'icon'    =>  'success',
          'msg'   =>  'Report of grades is successfully returned to faculty, please check your email for the copy of the submitted report of grades. <strong style="color: red;">Did not receive an email?</strong> <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="resend_email_copyof_rog()"><span id="resend_email_copy_of_rog">resend email</span></a></span>'
        );
      }else
      {
        $msg = array(
          'sys_msg' =>  'FAILED',
          'icon'    =>  'error',
          'msg'   =>  'Failed to forward, please try again.'
        );
      }

      /*if (strtotime(date('Y-m-d H:i:s')) > strtotime(FIRST_SEM_2022_2023_GRADE_DEADLINE)) 
      {
        $msg = array(
            'sys_msg' =>  'FAILED',
            'icon'    =>  'warning',
            'msg'   =>  'SUBMISSION IS LATE'
          );
      }else
      {
        
      }*/

      echo json_encode($msg);
    }



  }


  /* End of file Department.php */
/* Location: ./application/controllers/Department.php */