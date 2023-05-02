<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Computation
{
    public function _tuitionFee($course_type, $course_id, $schedule, $tuitionFee_data =  array())
    {
        $tuition_fee = 0;
        if (count($tuitionFee_data) > 0)
        {
            if (in_array($course_type, array('BS', 'B', 'D', 'BA')))
            {
                /* For Undergraduate Programs */
                if (in_array($course_id, array(53, 54, 56)))
                {
                    /* (BSHRM/BSHM/BSTM) */
                    foreach ($tuitionFee_data as $tuition_data)
                    {
                        if ($tuition_data->course_id == $course_id)
                        {
                            $tuition_fee = $tuition_data->amount;
                            break;
                        }
                    }
                }else
                {
                    /* All Undergraduate Program except (BSHRM/BSHM/BSTM) */
                    foreach ($tuitionFee_data as $tuition_data)
                    {
                        if ($tuition_data->course_id == 0 && in_array($tuition_data->course_type, array('BS', 'B', 'D', 'BA')))
                        {
                            $tuition_fee = $tuition_data->amount;
                            break;
                        }
                    }
                }
            }else
            {
                /* For Graduate Programs */
                if (!in_array($course_type, array('BS', 'B', 'D', 'BA')))
                {
                    if ($schedule == 'S') {
                        foreach ($tuitionFee_data as $tuition_data)
                        {
                            if ($tuition_data->course_type == $course_type && $tuition_data->sched_type == 'S')
                            {
                                $tuition_fee = $tuition_data->amount;
                                break;
                            }
                        }
                    }else
                    {
                        foreach ($tuitionFee_data as $tuition_data)
                        {
                            if ($tuition_data->course_type == $course_type && $tuition_data->sched_type == 'R')
                            {
                                $tuition_fee = $tuition_data->amount;
                                break;
                            }
                        }
                    }
                }else
                {
                    if ($schedule == 'S') {
                        foreach ($tuitionFee_data as $tuition_data)
                        {
                            if ($tuition_data->course_type == $course_type && $tuition_data->sched_type == 'S')
                            {
                                $tuition_fee = $tuition_data->amount;
                                break;
                            }
                        }
                    }else
                    {
                        foreach ($tuitionFee_data as $tuition_data)
                        {
                            if ($tuition_data->course_type == $course_type && $tuition_data->sched_type == 'R')
                            {
                                $tuition_fee = $tuition_data->amount;
                                break;
                            }
                        }
                    }
                }
            }
        }else
        {
            $tuition_fee = 0;
        }

        return $tuition_fee;
    }

    public function _entrance($year_level, $semester, $enrollment_count = 0, $admission_fee_data = array())
    {
        $entrance_fee = 0;
        if ($semester === "1")
        {
            if ($year_level === "1")
            {
                if ($enrollment_count <= 1)
                {
                    foreach ($admission_fee_data as $entrance)
                    {
                        if ($entrance->admission_fee_id == 1)
                        {
                            $entrance_fee = $entrance->amount;
                            break;
                        }
                    }
                }else
                {
                    $entrance_fee = 0;
                }
            }
        }
        // IF VALUE IS ZERO its either not qualified in fee or year level is not updated
        return $entrance_fee;
    }

    public function _medical_screening($enrollment_count = 0, $student_type = "", $admission_fee_data = array())
    {
        $medical_screening_fee = 0;
        if ($enrollment_count <= 1)
        {
            foreach ($admission_fee_data as $med_screen)
            {
                if (in_array($med_screen->admission_fee_id,  array(2, 3, 4, 5)))
                {
                    if ($med_screen->student_type === strtoupper($student_type))
                    {
                        $medical_screening_fee = $med_screen->amount;
                    }
                }
            }
        }

        return $medical_screening_fee;
    }

    public function _athletic_fee($athletic_fee_data = array()) //Mandatory Fee
    {
        $recreation = $scuaa = $athletic = 0;
        foreach ($athletic_fee_data as $fee_data)
        {
            if ($fee_data->athletic_fee_id == 1)
            {
                $recreation = $fee_data->amount;
            }

            if ($fee_data->athletic_fee_id == 2)
            {
                $scuaa = $fee_data->amount;
            }

            if ($fee_data->athletic_fee_id == 3)
            {
                $athletic = $fee_data->amount;
            }
        }

        $athletic_fee = array(
            'recreation'        =>  $recreation,
            'scuaa'             =>  $scuaa,
            'athletic'          =>  $athletic
        );

        return $athletic_fee;
    }

    public function _computer_fee($computer_fee_data = array(), $computer_ctr = 0)
    {
        $computer_fee = 0;
        foreach ($computer_fee_data as $fee_data)
        {
            if ($fee_data->computer_fee_id == 1)
            {
                $computer_fee = $fee_data->amount * $computer_ctr;
            }
        }
        return $computer_fee;
    }

    public function _field_study($development_fee_data = array(), $field_study_ctr = 0)
    {
        $field_study = 0;
        if ($field_study_ctr > 0){
            foreach ($development_fee_data as $fee_data)
            {
                if ($fee_data->development_fee_id == 1)
                {
                    $field_study = $fee_data->amount;
                }
            }
        }

        return $field_study;
    }

    public function _bridging_fee($development_fee_data = array(), $course_id = 0, $semester_enrolled_ctr = 0, $year_level = 0)
    {
        $bridging_fee = 0;
        if ($semester_enrolled_ctr <= 4)
        {
          if ($year_level <= 2) {
            foreach ($development_fee_data as $fee_data)
            {
                if ($fee_data->development_fee_id == 2 && $course_id == 2)
                {
                    $bridging_fee = $fee_data->amount;
                }
            }
          }
        }

        return $bridging_fee;
    }

    public function _scientific_journal($development_fee_data = array())
    {
        $scientific_journal = 0;

        foreach ($development_fee_data as $fee_data)
        {
            if ($fee_data->development_fee_id == 3)
            {
                $scientific_journal = $fee_data->amount;
            }
        }

        return $scientific_journal;
    }

    public function _student_news_organ($development_fee_data = array())
    {
        $student_news_organ = 0;

        foreach ($development_fee_data as $fee_data)
        {
            if ($fee_data->development_fee_id == 4)
            {
                $student_news_organ = $fee_data->amount;
            }
        }

        return $student_news_organ;
    }

    public function _entrance_new($enrollment_count = 0, $student_type = "", $year_level = 0, $entrance_new_data = array())
    {
        $entrance = 0;
        if ($enrollment_count <= 1)
        {
            foreach ($entrance_new_data as $fee_data)
            {
                if ($fee_data->year_level === $year_level && $fee_data->student_type === strtoupper($student_type))
                {
                    $entrance = $fee_data->amount;
                }
            }
        }

        return $entrance;
    }

    public function _laboratory_fee($lab_enrolled = array(), $laboratory_fee_data = array())
    {
        $laboratory_fee = 0;
        foreach ($laboratory_fee_data as $fee_data)
        {
            if (in_array($fee_data->laboratory_fee_id, array(1, 2, 3)))
            {
                if ($fee_data->lab_type == 1)
                {
                    $laboratory_fee = $laboratory_fee + ($fee_data->amount * $lab_enrolled[0]);
                }

                if ($fee_data->lab_type == 3)
                {
                    $laboratory_fee = $laboratory_fee + ($fee_data->amount * $lab_enrolled[1]);
                }

                if ($fee_data->lab_type == 4)
                {
                    $laboratory_fee = $laboratory_fee + ($fee_data->amount * $lab_enrolled[2]);
                }
            }
        }
        return $laboratory_fee;
    }

    public function _audio_visual($laboratory_fee_data = array())
    {
        $audio_visual = 0;
        foreach ($laboratory_fee_data as $fee_data)
        {
            if (in_array($fee_data->laboratory_fee_id, array(4)))
            {
                $audio_visual = $fee_data->amount;
            }
        }
        return $audio_visual;
    }

    public function _guidance_fee($course_type, $guidance_fee_data = array())
    {
        $pta = $class_org = $cgc = $charity = 0;

        foreach ($guidance_fee_data as $fee_data)
        {
            if (in_array($course_type, array('BS', 'B', 'D', 'BA')))
            {
                if ($fee_data->guidance_fee_id == 1)
                {
                    $pta = $fee_data->amount;
                }

                if ($fee_data->guidance_fee_id == 2)
                {
                    $cgc = $fee_data->amount;
                }

                if ($fee_data->guidance_fee_id == 3)
                {
                    $class_org = $fee_data->amount;
                }

                if ($fee_data->guidance_fee_id == 4)
                {
                    $charity = $fee_data->amount;
                }
            }else
            {

                if ($fee_data->guidance_fee_id == 2)
                {
                    $cgc = $fee_data->amount;
                }

                if ($fee_data->guidance_fee_id == 4)
                {
                    $charity = $fee_data->amount;
                }
            }
        }

        $guidance_fee_arr = array(
            'pta'           => $pta,
            'class_org'     => $class_org,
            'cgc'           => $cgc,
            'charity'       => $charity
        );

        return $guidance_fee_arr;
    }

    public function _library_fee($course_type, $semester_number, $libray_fee_data = array())
    {
        $library_fee = 0;

        foreach ($libray_fee_data as $fee_data)
        {
            if (in_array($course_type, array('BS', 'B', 'D', 'BA')))
            {
                if (in_array($fee_data->library_fee_id, array(1, 2, 3)))
                {
                    if ($fee_data->semester_number == $semester_number)
                    {
                        $library_fee = $fee_data->amount;
                    }
                }
            }else
            {
                if (in_array($fee_data->library_fee_id, array(4, 5, 6)))
                {
                    if ($fee_data->semester_number == $semester_number)
                    {
                        $library_fee = $fee_data->amount;
                    }
                }
            }

        }

        return $library_fee;
    }

    public function _medical_dental($semester_number, $medical_dental_data = array())
    {
        $medical_dental = 0;
        if (in_array($semester_number, array(1, 2)))
        {
            foreach ($medical_dental_data as $fee_data)
            {
                if (in_array($fee_data->medical_dental_fee_id, array(1, 2)))
                {
                    if ($fee_data->semester_number == $semester_number)
                    {
                        $medical_dental = $fee_data->amount;
                    }
                }
            }
        }

        return $medical_dental;
    }

    public function _insurance($semester_number, $medical_dental_data = array())
    {
        $insurance = 0;
        if (in_array($semester_number, array(1)))
        {
            foreach ($medical_dental_data as $fee_data)
            {
                if (in_array($fee_data->medical_dental_fee_id, array(3)))
                {
                    if ($fee_data->semester_number == $semester_number)
                    {
                        $insurance = $fee_data->amount;
                    }
                }
            }
        }

        return $insurance;
    }

    public function _registration_fee($registration_fee_data = array())
    {
        $registration_fee = 0;

        foreach ($registration_fee_data as $fee_data) {
            $registration_fee = $fee_data->amount;
        }

        return $registration_fee;
    }

    public function _school_id($student_type, $school_id_data = array())
    {
        $school_id_fee = 0;

        if (in_array(strtoupper($student_type), array('NEW', 'TRANSFEREE', 'TRANSFEREES')))
        {
            foreach ($school_id_data as $fee_data)
            {
                if ($fee_data->student_type == $student_type)
                {
                    $school_id_fee = $fee_data->amount;
                }
            }
        }

        return $school_id_fee;
    }
}
