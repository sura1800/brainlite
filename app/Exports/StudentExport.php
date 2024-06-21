<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StudentExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $result= json_decode($this->request);
        $students = DB::table('students')->whereNull('deleted_at');

        if(!empty($result)){
                if(!empty($result->student_name)){
                    $students = $students->where('students.student_name', 'like', $result->student_name.'%');
                }
                if(!empty($result->mobile_no)){
                    $students = $students->where('students.mobile_no', 'like', $result->mobile_no.'%');
                }
                if(!empty($result->candidate_reg_id)){
                    $students = $students->where('students.candidate_reg_id', 'like', $result->candidate_reg_id.'%');
                }
                if(!empty($result->tp_id)){
                    $students = $students->where('students.tp_id', 'like', $result->tp_id.'%');
                }
                if(!empty($result->batch_id)){
                    $students = $students->where('students.batch_id', 'like', $result->batch_id.'%');
                }
                if(!empty($result->acadamic_year)){
                    $students = $students->where('students.acadamic_year', 'like', $result->acadamic_year.'%');
                }
                if(!empty($result->qp_code)){
                    $students = $students->where('students.qp_code', 'like', $result->qp_code.'%');
                }
                if(!empty($result->aadhar_no)){
                    $students = $students->where('students.aadhar_no', 'like', $result->aadhar_no.'%');
                }
        }
        $students = $students->orderBy('student_id','DESC')->get();

        $list = array();
        $item = array();
        $list[0] = array(
            'username'          => 'User Name',
            'student_name'      => 'Student Name',
            'candidate_reg_id'  => 'Candidate Reg Id',
            'mobile_no'         => 'Mobile No',
            'tp_id'             => 'TP ID',
            'project_type'      => 'Project Type',
            'sector'           => 'Sector',
            'batch_id'          => 'Batch ID',
            'acadamic_year'     => 'Acadamic Year',
            'qp_code'           => 'QP Code',
            'job_role'          => 'Job Role',
            'training_location' => 'Training Location',
            'state'             => 'State',
            'aadhar_no'         => 'Aadhar No',
        );

        foreach($students as $student){
            $item = array(
                'username'          => $student->username,
                'student_name'      => $student->student_name,
                'candidate_reg_id'  => $student->candidate_reg_id,
                'mobile_no'         => $student->mobile_no,
                'tp_id'             => $student->tp_id,
                'project_type'      => $student->project_type,
                'sector'            => $student->sector,
                'batch_id'          => $student->batch_id,
                'acadamic_year'     => $student->acadamic_year,
                'qp_code'           => $student->qp_code,
                'job_role'          => $student->job_role,
                'training_location' => $student->training_location,
                'state'             => $student->state,
                'aadhar_no'         => $student->aadhar_no,
            );
            $list[] = $item;
        }
        unset($item, $students, $student, $result);
        return collect($list);

    }
}
