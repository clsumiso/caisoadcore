<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Applicant extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $data = array(
      "code"  =>  "404",
      "msg"   =>  "Page not Found!",
      "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/"
    );
    $this->load->view('err/custom_error', $data);
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
        $this->load->view('applicant/_header', $data);
        $this->load->view('applicant/_css', $data);
        $this->load->view('applicant/applicant_view', $data);
        $this->load->view('applicant/_footer', $data);
        $this->load->view('applicant/_js', $data);
      }else
      {
        $data = array(
          "code"  =>  "401",
          "msg"   =>  "Unauthorized Access",
          "link"  =>  "https://ctec.clsu2.edu.ph/clsucat/"
        );
        $this->load->view('err/custom_error', $data);
      }
  }

}


/* End of file Applicant.php */
/* Location: ./application/controllers/Applicant.php */