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

}


/* End of file Application.php */
/* Location: ./application/controllers/Application.php */