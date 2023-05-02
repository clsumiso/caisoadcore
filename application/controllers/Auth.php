<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    // 
  }

  public function verifyAccount()
  {
    $userName = $_SESSION['uid'];
    $userPass = $_POST['upass'];
  }

}


/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */