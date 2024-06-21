<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class StudentImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if(array_key_exists('User Name', $row) && array_key_exists('Student Name', $row) && array_key_exists('Candidate Reg Id', $row) && array_key_exists('Mobile No', $row)
            && array_key_exists('TP ID', $row) && array_key_exists('Project Type', $row) && array_key_exists('Sector', $row) && array_key_exists('Batch ID', $row)
            && array_key_exists('Acadamic Year', $row) && array_key_exists('QP Code', $row) && array_key_exists('Job Role', $row)&& array_key_exists('Training Location', $row) && array_key_exists('State', $row)
        ){
            if($row['User Name'] !=='' && $row['Student Name'] !=='' && $row['Candidate Reg Id'] !=='' && $row['Mobile No'] !=='' && $row['TP ID'] !=='' && $row['Project Type'] !=='' && $row['Sector'] !==''
                && $row['Batch ID'] !=='' && $row['Acadamic Year'] !=='' && $row['QP Code'] !=='' && $row['Job Role'] !=='' && $row['Training Location'] !=='' && $row['State'] !==''){

                    $check_student = Student::where([
                            'mobile_no' => $row['Mobile No'],
                            'username'  => $row['User Name'],
                            'candidate_reg_id'  => $row['Candidate Reg Id'],
                        ])->exists();

                    if($check_student === false){
                        $data = [
                            'username'          => $row['User Name'],
                            'student_name'      => $row['Student Name'],
                            'candidate_reg_id'  => $row['Candidate Reg Id'],
                            'mobile_no'         => $row['Mobile No'],
                            'tp_id'             => $row['TP ID'],
                            'project_type'      => $row['Project Type'],
                            'sector'            => $row['Sector'],
                            'batch_id'          => $row['Batch ID'],
                            'acadamic_year'     => $row['Acadamic Year'],
                            'qp_code'           => $row['QP Code'],
                            'job_role'          => $row['Job Role'],
                            'training_location' => $row['Training Location'],
                            'state'             => $row['State'],
                            //'aadhar_no'         => $row['aadhar_no'],
                         ];
                         return new Student($data);
                    }
            }

        }

    }

    public function batchSize(): int
    {
        return 20;
    }
}
