<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admission_application extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->model("admission_application_model", "admission_application");
  }

  public function index()
  {
    $data = array();
    $this->load->view('application/_header', $data);
    $this->load->view('application/_css', $data);
    $this->load->view('application/application_view', $data);
    $this->load->view('application/modal/_err_modal', $data);
    $this->load->view('application/_footer', $data);
    $this->load->view('application/_js', $data);
  }

  public function submitApplication()
  {
    $data = $_POST;
    $msg = array();

    $arrData = array(
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
      "educational_background"      =>  json_encode($this->getArr($data['question_21'])),
      "reference"                   =>  json_encode($this->getArr($data['question_22'])),
      "area_of_interest"            =>  $data['question_23'],
      "aoi_major"                   =>  $data['question_24'],
      "languange_proficiency"       =>  json_encode($this->getArr($data['question_25'])),
      "graduate_program_applied"    =>  json_encode(array($data['question_26'], $data['question_27'])),
      "teaching_experience"         =>  json_encode($this->getArr($data['question_28'])),
      "publish_materials"           =>  $data['question_29'],
      "academic"                    =>  json_encode($this->getArr($data['question_30'])),
      "future_plan"                 =>  $data['question_31'],
      "expected_source"             =>  $data['question_32'],
      "school_year"                 =>  $data['question_33'],
      "semester"                    =>  $data['question_34'],
      "confirmation_status"         =>  1,
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

  public function getArr($arr = array())
  {
    $arrData = array();
    for ($i=0; $i < count($arr); $i++) 
    { 
      if ($arr[$i] != "") 
      {
        array_push($arrData, $arr[$i]);
      }
    }

    return $arrData;
  }

}


/* End of file Application.php */
/* Location: ./application/controllers/Application.php */