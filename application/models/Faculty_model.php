<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_semester()
	{
		$this->db->select('*');
		$this->db->from('tbl_semester');
		$this->db->order_by('semester_id', 'DESC');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_old_grades($semester, $subject, $faculty_id)
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.fname, tbl_profile.mname, tbl_profile.lname, tbl_semester.semester_name, tbl_semester.semester_year, tbl_grades.subject, tbl_grades.units, tbl_grades.grades, tbl_grades.reexam, tbl_grades.remarks, tbl_grades.date_faculty_approve, tbl_grades.date_dept_approve, tbl_grades.date_dean_approve, tbl_grades.date_uploaded, tbl_grades.status');
		$this->db->from('tbl_grades');
		$this->db->join('tbl_profile', 'tbl_grades.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_grades.semester_id = tbl_semester.semester_id', 'inner');
		$this->db->where('tbl_grades.semester_id', $semester);
		$this->db->where('tbl_grades.faculty_id', $faculty_id);
		$this->db->where('tbl_grades.subject', $subject);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_subjects_old_grades($semester, $faculty_id)
	{
		$this->db->select('subject');
		$this->db->from('tbl_grades');
		$this->db->where('semester_id', $semester);
		$this->db->where('faculty_id', $faculty_id);
		$this->db->group_by('subject', array('subject'));
		$query = $this->db->get();

		return $query->result();
	}

	public function get_subjects_new_grades($semester, $faculty_id)
	{
		$this->db->select('tbl_teaching_loads.schedid, tbl_class_schedule.cat_no, tbl_class_schedule.section');
		$this->db->from('tbl_teaching_loads');
		$this->db->join('tbl_class_schedule', 'tbl_teaching_loads.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_teaching_loads.semester_id', $semester);
		$this->db->where('tbl_teaching_loads.user_id', $faculty_id);
		$this->db->where('tbl_class_schedule.class_type !=', '2');
		$this->db->order_by('tbl_class_schedule.cat_no', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_new_grades($semester, $subject, $faculty_id, $student_id_arr = array('@'))
	{
		$this->db->select('tbl_profile.user_id, tbl_profile.fname, tbl_profile.mname, tbl_profile.lname, tbl_semester.semester_name, tbl_semester.semester_year, tbl_grades.subject, tbl_grades.units, tbl_grades.grades, tbl_grades.reexam, tbl_grades.remarks, tbl_grades.date_faculty_approve, tbl_grades.date_dept_approve, tbl_grades.date_dean_approve, tbl_grades.date_uploaded, tbl_grades.status');
		$this->db->from('tbl_grades');
		$this->db->join('tbl_profile', 'tbl_grades.user_id = tbl_profile.user_id', 'inner');
		$this->db->join('tbl_semester', 'tbl_grades.semester_id = tbl_semester.semester_id', 'inner');
		$this->db->where('tbl_grades.semester_id', $semester);
		$this->db->where('tbl_grades.faculty_id', $faculty_id);
		$this->db->where('tbl_grades.subject', $subject);
		$this->db->where_in('tbl_grades.user_id', $student_id_arr);
		$this->db->order_by('tbl_profile.lname', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}

	public function get_students_on_class_list($schedid, $semester_id)
	{
		$this->db->select('tbl_registration.user_id');
		$this->db->from('tbl_registration');
		$this->db->where('tbl_registration.schedid', $schedid);
		$this->db->where('tbl_registration.semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_class_schedule_info($schedid, $semester_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_class_schedule');
		$this->db->where('schedid', $schedid);
		$this->db->where('semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_teaching_load_subjects($semester_id)
	{
		$this->db->select('tbl_class_schedule.*, tbl_teaching_loads.user_id AS faculty_id, tbl_department.dept_desc, tbl_semester.semester_name, tbl_semester.semester_year');
		$this->db->from('tbl_class_schedule');
		$this->db->join('tbl_teaching_loads', 'tbl_class_schedule.schedid = tbl_teaching_loads.schedid', 'left');
		$this->db->join('tbl_department', 'tbl_class_schedule.department_id = tbl_department.dept_id', 'left');
		$this->db->join('tbl_semester', 'tbl_class_schedule.semester_id = tbl_semester.semester_id', 'inner');
		$this->db->where('tbl_class_schedule.semester_id', $semester_id);
		$query = $this->db->get();

		return $query->result();
	}

	public function get_teaching_loads($email, $schedid, $semid)
	{
		$this->db->select('tbl_teaching_loads.user_id, tbl_teaching_loads.semester_id, tbl_teaching_loads.schedid, tbl_class_schedule.cat_no, tbl_teaching_loads.date_created');
		$this->db->from('tbl_teaching_loads');
		$this->db->join('tbl_class_schedule', 'tbl_teaching_loads.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_teaching_loads.user_id', $email);
		$this->db->where('tbl_teaching_loads.schedid', $schedid);
		$this->db->where('tbl_teaching_loads.semester_id', $semid);
		$query = $this->db->get();

		return $query->result();
	}

	public function delete($table, $condition = array())
	{
		$this->db->trans_begin();
	    $this->db->trans_strict(TRUE);
        $this->db->delete($table, $condition);

	    if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function save($table, $data = array())
	{
		$this->db->trans_begin();
	    $this->db->trans_strict(TRUE);
        $this->db->insert($table, $data);

	    if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return false;
	    } else {
	        $this->db->trans_commit();
	        return true;
	    }
	}

	public function get_subject_to_submit_by_schedid($schedid, $semester)
    {
        $this->db->select("tbl_registration.user_id, tbl_class_schedule.schedid, tbl_class_schedule.cat_no, tbl_profile.lname, tbl_profile.fname");
        $this->db->from('tbl_registration');
        $this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
        $this->db->join('tbl_profile', 'tbl_registration.user_id = tbl_profile.user_id', 'inner');
        $this->db->where('tbl_registration.schedid', $schedid);

        if ($semester == 3) 
        {
            $this->db->where('tbl_registration.status', 2);
        }else
        {
            $this->db->where_in('tbl_registration.ra_status', array('approved'));
        }
        // $this->db->where('tbl_registration.status', 2);
        

        $this->db->where('tbl_registration.semester_id', $semester);
        $this->db->order_by('tbl_profile.lname', 'ASC');
        // $this->db->where_in('tbl_grades.status', array('pending', 'faculty'));
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grades_to_submit($semester, $faculty, $user_id, $subject)
    {
        $this->db->select("grade_id, user_id, grades, reexam, status, faculty_id");
        $this->db->from('tbl_grades');
        $this->db->where('tbl_grades.user_id', $user_id);
        $this->db->where('tbl_grades.faculty_id', $faculty);
        $this->db->where('tbl_grades.semester_id', $semester);
        $this->db->where('tbl_grades.subject', $subject);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_enrolled_student_id($schedid)
    {
        $this->db->select("user_id");
        $this->db->from('tbl_registration');
        $this->db->where('schedid', $schedid);
        $query = $this->db->get();
        return $query->result();
    }

    public function manage_grades($class_rec_id = '', $sem = '')
	{
		$data = array(
			"account_name"  			=> 	$_SESSION['account_name'],
			"page"         	 			=>  4.1,
			"activity_subject_info"		=>	$this->grades_subject_data($class_rec_id, $sem)[0],
			"semester"					=> 	$sem,
			"cat_no"					=> 	$this->grades_subject_data($class_rec_id, $sem)[1],
			"class_rec_id"				=> 	$class_rec_id,
			"rog_status"				=>	$this->rog_status(explode('_', $class_rec_id)[2], $sem),					
			/*,
			"student_list"				=>	$this->get_student_enrolled($class_rec_id, $sem)*/
			
		);

		return $data;

		// $this->load->view('faculty/_header', $data);
		// $this->load->view('faculty/_css', $data);
		// $this->load->view('pre_loader', $data);
		// $this->load->view('faculty/manage_grades_view', $data);
		// $this->load->view('faculty/_footer', $data);
		// $this->load->view('faculty/_js', $data);
	}

	public function manage_grades_old($subject = '', $sem = '')
	{
		$subject_data = '
				<blockquote class="quote-success bg-warning animate__animated  animate__flipInX" style="margin: 0 0 10px;">
					<p class="font-weight-bold" style="font-size: 24px;">'.str_replace('%20', ' ', $subject).'</p>
				</blockquote>
			';
		$data = array(
			"account_name"  			=> 	$_SESSION['account_name'],
			"page"         	 			=>  4.1,
			"activity_subject_info"		=>	$subject_data,
			"cat_no"					=> 	$subject,
			"class_rec_id"				=> 	str_replace('%20', ' ', $subject)."|".$sem,
			"semester"					=> 	$sem
			
		);

		return $data;

		// $this->load->view('faculty/_header', $data);
		// $this->load->view('faculty/_css', $data);
		// $this->load->view('pre_loader', $data);
		// $this->load->view('faculty/manage_grades_old_view', $data);
		// $this->load->view('faculty/_footer', $data);
		// $this->load->view('faculty/_js', $data);
	}

	public function get_non_email_user($email)
    {
        $this->db->select("user_id");
        $this->db->from('tbl_profile');
		$this->db->where('email', $email);
        $query = $this->db->get();
        return $query->result();
    }


    public function get_subject($user_id, $sem, $email, $non_email, $schedid)
    {
        $this->db->select("tbl_teaching_loads.user_id, tbl_teaching_loads.schedid, tbl_class_schedule.cat_no, tbl_class_schedule.units, tbl_class_schedule.day, tbl_class_schedule.time, tbl_class_schedule.room, tbl_class_schedule.section, tbl_class_schedule.class_type");
        $this->db->from('tbl_teaching_loads');
        $this->db->join('tbl_class_schedule', 'tbl_teaching_loads.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_teaching_loads.semester_id', $sem);
		$this->db->where('tbl_teaching_loads.schedid', $schedid);
		$this->db->where_in('tbl_teaching_loads.user_id', $non_email);
        // $this->db->group_start();
        //     $this->db->where('tbl_teaching_loads.user_id', $user_id);
        //     $this->db->or_where('tbl_teaching_loads.user_id', $email);
        // $this->db->group_end();
		// $this->db->limit($limit, $start);
		// $this->db->limit(100, 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_grades_old_system($faculty_id, $sem)
    {
        $this->db->select("*");
        $this->db->from('tbl_grades');
		$this->db->where('tbl_grades.semester_id', $sem);
		$this->db->where_in('tbl_grades.status', array('approved', 'faculty', 'department head', 'dean'));
		$this->db->where_in('tbl_grades.faculty_id', $faculty_id);
        $this->db->group_by(array('tbl_grades.subject'));
        $query = $this->db->get();
        return $query->result();
    }

    public function get_enrolled($schedid, $sem)
	{
		$this->db->select("user_id");
        $this->db->from('tbl_registration');
		$this->db->where('semester_id', $sem);
		$this->db->where('schedid', $schedid);
        if ($sem == 3) 
        {
            $this->db->where_in('status', array(1,2));
        }else
        {
            $this->db->where_in('ra_status', array('approved'));
        }
		
		// $this->db->limit($limit, $start);
		// $this->db->limit(100, 0);
        $query = $this->db->get();
        return $query->result();
	}

	public function get_profile_id($user_id)
	{
		$this->db->select("profile_id");
        $this->db->from('tbl_profile');
		$this->db->where('user_id', $user_id);
		// $this->db->limit($limit, $start);
		// $this->db->limit(100, 0);
        $query = $this->db->get();
        return $query->result();
	}

	public function get_cps($class_record_id)
	{
		$this->db->select("*");
        $this->db->from('tbl_class_record');
		$this->db->where('class_record_id', $class_record_id);
        $query = $this->db->get();
        return $query->result();
	}

	public function get_enrolled_student($schedid, $sem)
    {
        $this->db->select("tbl_profile.*, tbl_registration.user_id AS reg_id, tbl_class_schedule.cat_no, tbl_class_schedule.schedid, tbl_class_schedule.section");
        $this->db->from('tbl_registration');
        $this->db->join('tbl_profile', 'tbl_registration.user_id = tbl_profile.user_id', 'left');
        $this->db->join('tbl_class_schedule', 'tbl_registration.schedid = tbl_class_schedule.schedid', 'inner');
		$this->db->where('tbl_registration.semester_id', $sem);
		$this->db->where('tbl_registration.schedid', $schedid);
		if ($sem <= 3){
			$this->db->where('tbl_registration.status', 2);
		}else
		{
			$this->db->where('tbl_registration.ra_status', 'approved');
		}
		
		$this->db->order_by('tbl_profile.lname', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_enrolled_student_old($subject, $sem, $faculty, $status)
    {
        $this->db->select("tbl_profile.*, tbl_grades.*");
        $this->db->from('tbl_grades');
        $this->db->join('tbl_profile', 'tbl_grades.user_id = tbl_profile.user_id', 'inner');
		$this->db->where('tbl_grades.semester_id', $sem);
		$this->db->where('tbl_grades.subject', $subject);
		$this->db->where_in('tbl_grades.faculty_id', $faculty);
        if ($status != '*') {
            $this->db->where('tbl_grades.status', $status);
        }else{
            $this->db->where_in('tbl_grades.status', array('faculty', 'department head', 'dean', 'approved', 'pending'));
        }
		$this->db->order_by('tbl_profile.lname', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student_grade($user_id, $schedid, $sem)
    {
        $this->db->select("tbl_grades.*");
        $this->db->from('tbl_grades');
        $this->db->join('tbl_class_schedule', 'tbl_grades.subject = tbl_class_schedule.cat_no', 'inner');
		$this->db->where('tbl_class_schedule.schedid', $schedid);
		$this->db->where('tbl_grades.user_id', $user_id);
		$this->db->where('tbl_grades.semester_id', $sem);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_student_grade_old($user_id, $subject, $sem, $faculty_id)
    {
        $this->db->select("tbl_grades.*");
        $this->db->from('tbl_grades');
		$this->db->where('subject', $subject);
		$this->db->where('user_id', $user_id);
		$this->db->where('semester_id', $sem);
		$this->db->where_in('faculty_id', $faculty_id);
        $query = $this->db->get();
        return $query->result();
    }





}

/* End of file Faculty_model.php */
/* Location: ./application/models/Faculty_model.php */