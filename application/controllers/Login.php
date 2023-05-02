<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('login_model', 'login');
    // $this->load->model('students_model', 'students');
  }
  
  public function index($login_type = 0)
  {
    $this->session->set_userdata(array(
      "login_type" => $login_type
    ));
    $this->load->view('login/_header');
    $this->load->view('login/_css');
    $this->load->view('login/login_view');
    $this->load->view('login/_footer');
    $this->load->view('login/_js');
    // show_error("The portals will undergo system maintenance.", null, "SYSTEM MAINTENANCE");
  }

  public function Logout()
  {
      $this->session->sess_destroy();
      redirect(base_url('/'));
  }

  public function login_verification()
  {
      $token = $_POST['token'];
      $action = $_POST['action'];
      $email = $_POST['email'];
      $password = $_POST['pass'];
      $response = array();

      if ($this->user_verification($email, $password) === true) {
        /* Call recaptcha */
        // call curl to POST request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);

        // verify the response
        if (count($arrResponse) > 0)
        {
          if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.1) 
          {
              // valid submission
              // go ahead and do necessary stuff
              // echo json_encode($arrResponse["success"]." === ".$arrResponse["action"]." === ".$arrResponse["score"]);
              switch ($this->session->userdata('utype')) 
              {
                case 'faculty':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "faculty",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'student':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "students",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'department head':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "department_head",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'dean':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "dean",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'ric':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "records_in_charge",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'admin':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "administrator",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'registration adviser':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "registration_adviser",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'infirmary':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "clsu_infirmary",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'encoder':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "encoder",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                case 'accounting':
                  
                  $data = array(
                    'login_stat'    =>  1,
                    'login_timestamp' =>  date("Y-m-d H:i:s"),
                    'login_token'   =>  $token
                  );

                  $condition = array(
                    'uname' =>  $email,
                    'upass' =>  $password
                  );

                  if ($this->login->update($data, $condition, 'tbl_users') !== false) 
                  {
                    $response = array(
                      'sys_msg'   =>  "SUCCESS",
                      'redirect'  =>  "accounting",
                      'msg'       =>  ''
                    );
                  }else
                  {
                    $response = array(
                      'sys_msg'   =>  "Something went wrong",
                      'redirect'  =>  "",
                      'msg'       =>  'Login failed, please try again!!!'
                    );
                  }
                  break;
                
                default:
                  $response = array(
                    'sys_msg'   =>  "Something went wrong",
                    'redirect'  =>  "",
                    'msg'       =>  'Login failed, please contact service provider.'
                  );
                  break;
              }
              
          }else 
          {
              $response = array(
                'sys_msg'   =>  "FAILED",
                'redirect'  =>  "0",
                'msg'       =>  'Login failed, please try again2!!!'
              );
          }
        }else
        {
          $response = array(
            'sys_msg'   =>  "FAILED",
            'redirect'  =>  "",
            'msg'       =>  'Login failed, please try again!!!'
          );
        }
        /* END Call recaptcha */
      }else
      {
        // Invalid credentials
        $response = array(
          'sys_msg'   =>  "FAILED",
          'redirect'  =>  "",
          'msg'       =>  $this->user_verification($email, $password)
        );
      }

      echo json_encode($response);
  }

  public function active_semester()
  {
      // $semester = $this->students->get_active_semester();
      // return $semester[0]->semester_name.' '.$semester[0]->semester_year;
  }

  public function user_verification($email, $password)
  {
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    // {
    //    return "Invalid clsu2 email, please enter a valid clsu2 email.";
    // }
    // else
    // {
    //
    // }
    // $semester = $this->students->get_active_semester();
    $user_data = $this->login->get_user_info($email, $password);
    if (count($user_data) > 0)
    {
        $data = array(
            "uid"               =>  $user_data[0]->uname,
            "account_name"      =>  $user_data[0]->fname." ".$user_data[0]->lname,
            "e_id"              =>  $user_data[0]->email,
            "utype"             =>  $user_data[0]->user_type,
            "ylevel"            =>  $user_data[0]->year_level,
            "sex"               =>  $user_data[0]->sex,
            "login_timestamp"   =>  date("Y-m-d H:i:s")/*,
            "semester"          =>  $semester[0]->semester_name.' '.$semester[0]->semester_year,
            "course"            =>  $user_data[0]->course_name*/
        );

        // $_SESSION['fullname'] = $user_data[0]->lname.", ".$user_data[0]->fname." ".$user_data[0]->mname;
        // $_SESSION['course'] = $user_data[0]->course_name;
        // $_SESSION['sex']  = $user_data[0]->sex;
        // $_SESSION['semester'] = $semester[0]->semester_name.' '.$semester[0]->semester_year;

        $this->session->set_userdata($data);
        return true;
      }
      else
      {
        return "Wrong username or password, please try again.";
      }
  }
}


/* End of file Login.php */
/* Location: ./application/controllers/Login.php */
