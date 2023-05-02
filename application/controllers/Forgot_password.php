<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
class Forgot_password extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('forgot_password_model', 'forgot_password');
  }

  public function index()
  {
  	
  }

  public function password_verification($email)
  {
  	$data = array(
  		'email' => $email
  	);
    $_SESSION['u_email'] = $email;
    $this->load->view('forgot_password_view', $data);
  }

  public function send_verification()
  {
    $email = $_SESSION['u_email'];
    $check_email = $this->forgot_password->check_email($email);
    // if(count($check_email) > 0){
    //   $subject = strtoupper($check_email[0]->user_type)." - Verification Code";
    //   $htmlContent  = '<p>Dear '.strtoupper($check_email[0]->user_type).',</p><br>';
    //   $htmlContent  .= '<p>Good day, your verification code to reset your password is: </p><h3>Code: '.$this->_token().'</h3><br>';
    //   $this->send_smtp_email($email, $subject, $htmlContent);
    //   echo 'success';
    // }else{
    //   echo 'failed';
    // }

     if(count($check_email) > 0){
      $mail = new PHPMailer(true);
      $ctr = 1;
      $msg = '';
      //abad.princess@clsu2.edu.ph
      //manitchala.joshua@clsu2.edu.ph
      try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        //$mail->isSendmail();
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                     //Set the SMTP server to send through 
        $mail->Username   = 'clsuoad.noreply@clsu2.edu.ph';                     //SMTP username
        $mail->Password   = 'AD315510N5';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('clsuoad.noreply@gmail.com', 'OFFICE OF ADMISSIONS');
        $mail->addAddress($email); 
        $mail->addReplyTo($email, 'Student');     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'STUDENT PORTAL - Verification Code';
        
        $htmlContent  = '<p>Dear Maam/Sir,</p><br>';
        $htmlContent  .= '<p>Good day, your verification code to reset your password is: </p><h3>Code: '.$this->_token().'</h3><br>';
        
        $mail->Body    = $htmlContent;
            
        $mail->send();
        $mail->clearAddresses();
      } catch (Exception $e) {
        $msg .= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
      echo 'success';
    }else{
      echo 'failed';
    } 
  }

  public function send_smtp_email($email, $subject, $body)
  {
    $to      = $email;
    $subject = $subject;
    $message = $body;
    $headers = array(
        'From' => 'clsuoad.noreply@clsu2.edu.ph',
        'Reply-To' => '',
        'MIME-Version' => '1.0',
        'Content-type' => 'text/html',
        'charset' => 'iso-8859-1',
        'X-Mailer' => 'PHP/' . phpversion()
    );

    mail($to, $subject, $message, $headers);
  }

  public function reset_password()
  {
    if ($_POST['vcode'] == $_SESSION['vcode']) {
      $get_info = $this->forgot_password->check_email($_SESSION['u_email']);
      $user_id = $get_info[0]->user_id;  

      $data = array(
        // 'upass' =>  explode('-', $user_id)[1].explode('-', $user_id)[0]
        'upass' =>  'wxyz123#'
      );

      $res = $this->forgot_password->update('tbl_users', $data, array('user_id' =>  $user_id));
      if ($res > 0) {
        unset($_SESSION['vcode']);
        echo json_encode(array('sys_msg'  => 1, 'default_pass' => 'wxyz123#', 'test'  =>  json_encode($get_info)));
      }else{
        echo json_encode(array('sys_msg'  => 0));
      }
    }else{
      echo json_encode(array('sys_msg'  => 2));
    }
  }

  // Generate token
  public function _token()
  {
    if (!isset($_SESSION['vcode'])) {
      $token = "";
      $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
      $codeAlphabet.= "0123456789";
      $max = strlen($codeAlphabet); // edited

      for ($i=0; $i < 10; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
      }
      $_SESSION['vcode'] = $token;
      return $token;
    }else{
      return $_SESSION['vcode'];
    }
  }
}
