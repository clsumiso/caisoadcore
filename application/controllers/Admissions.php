<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

class Admissions extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
		$this->load->helper('date');
    $this->load->helper('download');
    $this->load->model('admissions_model', 'admissions');
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
        if ($_SESSION['utype'] != "admissions")
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
			'get_time'		=>	$this->get_time()
		);

    $this->load->view('admissions/_header', $data);
    $this->load->view('admissions/_css', $data);
    $this->load->view('admissions/admissions_view', $data);
    $this->load->view('admissions/_footer', $data);
    $this->load->view('admissions/_js', $data);
  }

  public function graduate_level()
  {
    if (!isset($_SESSION['uid'])) 
    {
      redirect('/');
    }else
    {
      if (isset($_SESSION['utype']))
      {
        if ($_SESSION['utype'] != "admissions_graduate")
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
			'get_time'		=>	$this->get_time()
		);

    $this->load->view('grad_level_admissions/_header', $data);
    $this->load->view('grad_level_admissions/_css', $data);
    $this->load->view('grad_level_admissions/admissions_view', $data);
    $this->load->view('grad_level_admissions/_footer', $data);
    $this->load->view('grad_level_admissions/_js', $data);
  }

  public function graduateLevelList()
  {
    // POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->admissions->getGraduateApplicants($postData);

		echo json_encode($data);
  }

  public function get_time()
	{
		$datestring = '%F, %d %Y';
		$time = time();
		return mdate($datestring, $time);
	}

  public function applicantList()
	{
		// POST data
		$postData = $this->input->post();

		// Get data
		$data = $this->admissions->getApplicants($postData);

		echo json_encode($data);
	}

  public function downloadRequirements($directory = "", $filename = "")
  {
    force_download('/uploads/graduate_level_requirements/'.$directory.'/'.$filename, NULL);
  }

  public function departmentEndorse()
  {
    $applicationID = $_POST['appID'];
    $msg = array();

    $data = array(
      "department_remarks" =>  "pending"
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

  public function exportReferenceForm($referenceID)
  {
    // ini_set('memory_limit', '-1');
    // ini_set('max_execution_time', 0);
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
      'mode'          =>  'utf-8',
      'format'        =>  'A4', //in cm
      'orientation'   =>  'P',
      'margin_top'    =>  '6',
      'margin_left'   =>  '25',
      'margin_right'  =>  '25',
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

    // $applicant_id = $appID;
    $ctr = 1;
    // $applicant_info = $this->applicant->get_applicant_info($applicant_id);
    $referenceInfo = $this->admissions->getReferenceInfo($referenceID);
    $test = '';
    // foreach ($applicant_info as $applicant) 
    // {
      
    // }
    $html = '';
      
    /*Header*/
    $html .=  '
      <table style="text-align: center; margin: 0 auto;">
        <tr>
          <td rowspan="2" style="vertical-align: top; padding-right: 20px;">
            <img src="'.base_url('assets/images/logo.bmp').'" width="80"/>
          </td>
          <td style="padding-top: 15px;">
            <p style="text-align: center; font-family: tahoma; font-size: 12px;">
                Republic of the Philippines
            </p>
            <p style="text-align: center; font-family: tahoma; font-size: 12px; font-weight: bold;">
              CENTRAL LUZON STATE UNIVERSITY
            </p>
            <p style="text-align: center; font-family: tahoma; font-size: 12px;">
              Science City of Muñoz, Nueva Ecija
            </p>
          </td>
        </tr>
        <tr>
          <td style="padding-top: 30px;">
            <p style="text-align: center; font-family: tahoma; font-size: 16px; font-weight: bold;">
              RECOMMENDATION LETTER
            </p>
          </td>
        </tr>
      </table>
      <table style="width: 100%; padding-top: 30px;">
        <tr>
          <td>
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular; font-style: italic;">
              Please send this form in a sealed envelope, with your signature across the flap.
            </p>
          </td>
        </tr>
      </table>
      <table style="width: 100%;">
        <tr>
          <td style="width: 45px;">
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
              Mail to: 
            </p>
          </td>
          <td>
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: bold;">
              The Dean
            </p>
          </td>
        </tr>
        <tr>
          <td style="width: 45px;">
          </td>
          <td>
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
              Office of Admissions
            </p>
          </td>
        </tr>
        <tr>
          <td style="width: 45px;">
          </td>
          <td>
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
              Central Luzon State University
            </p>
          </td>
        </tr>
        <tr>
          <td style="width: 45px;">
          </td>
          <td>
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
              Science City of Muñoz, Nueva Ecija
            </p>
          </td>
        </tr>
      </table>
      <table style="width: 100%; padding-top: 20px;">
        <tr>
          <td>
            <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
              Greetings!
            </p>
          </td>
        </tr>
      </table>
    ';

    foreach ($referenceInfo as $reference) 
    {
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
                <span style="font-size: 8px;'.( explode("||", $reference->applicant_capacity)[0] == "As his/her professor" ? "background-color: #000;" : "background-color: #fff;").' border: 1px solid #000;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> As his/her professor
              </p>
            </td>
            <td>
              <p style="text-align: center; font-family: tahoma; font-size: 11px; font-weight: regular;">
                '.(explode("||", $reference->applicant_capacity)[0] == "As his/her professor" ? explode("||", $reference->applicant_capacity)[1] : "_____" ).' years
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
                '.(explode("||", $reference->applicant_capacity)[0] == "As his/her thesis adviser" ? explode("||", $reference->applicant_capacity)[1] : "_____" ).' years
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
                '.(explode("||", $reference->applicant_capacity)[0] == "As his/her employer/supervisor" ? explode("||", $reference->applicant_capacity)[1] : "_____" ).' years
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
                '.(explode("||", $reference->applicant_capacity)[0] == "other" ? explode("||", $reference->applicant_capacity)[1] : "_____" ).' years
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
      ';
    }
      

    $mpdf->SetHTMLFooter('<p style="font-size: 10px; font-style: italic;">ACA.OAD.YYY.F.035 (Revision No. 1; May 23, 2023)</p>');

    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->WriteHTML($html, 2);

    // $mpdf->watermark_font = 'villona';

    ob_clean();
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="enrollment_form.pdf"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    $mpdf->Output("recommendation-letter".(date("YmdHis")).".pdf", \Mpdf\Output\Destination::DOWNLOAD);
    // $mpdf->Output();
    ob_end_flush();
    // echo $test;
  }

}


/* End of file Admissions.php */
/* Location: ./application/controllers/Admissions.php */