<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentExport;

class StudentController extends Controller
{
    public function index(Request $request){

        $students = Student::whereNull('deleted_at');
        if(isset($_GET['student_name']) && !empty($_GET['student_name'])){
            $students = $students->where('students.student_name', 'like', '%'.$_GET['student_name'].'%');
        }
        if(isset($_GET['mobile_no']) && !empty($_GET['mobile_no'])){
            $students = $students->where('students.mobile_no', 'like', '%'.$_GET['mobile_no'].'%');
        }
        if(isset($_GET['candidate_reg_id']) && !empty($_GET['candidate_reg_id'])){
            $students = $students->where('students.candidate_reg_id', 'like', '%'.$_GET['candidate_reg_id'].'%');
        }
        if(isset($_GET['tp_id']) && !empty($_GET['tp_id'])){
            $students = $students->where('students.tp_id', 'like', '%'.$_GET['tp_id'].'%');
        }
        if(isset($_GET['batch_id']) && !empty($_GET['batch_id'])){
            $students = $students->where('students.batch_id', 'like', '%'.$_GET['batch_id'].'%');
        }
        if(isset($_GET['acadamic_year']) && !empty($_GET['acadamic_year'])){
            $students = $students->where('students.acadamic_year', 'like', '%'.$_GET['acadamic_year'].'%');
        }
        if(isset($_GET['qp_code']) && !empty($_GET['qp_code'])){
            $students = $students->where('students.qp_code', 'like', '%'.$_GET['qp_code'].'%');
        }
        if(isset($_GET['aadhar_no']) && !empty($_GET['aadhar_no'])){
            $students = $students->where('students.aadhar_no', 'like', '%'.$_GET['aadhar_no'].'%');
        }

        $data['students'] = $students->orderBy('student_id','DESC')->paginate(10);
        return view('admin.student.index',$data);

    }

    public function show(Student $student)
    {
        $student_details = Student::where('student_id', "=", $student->student_id)->get();
        return view('admin.student.show', compact(['student', 'student_details']));
    }

    public function store(Request $request){
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx',
        ]);
        $file = $request->file('excel_file');
        Excel::import(new StudentImport, $file);
       return redirect()->back()->with('message','File Uploaded Successfully.');
    }

    public function studentExport(Request $request,$token)
    {
        $file = 'student_'. time().'.csv';
        return Excel::download(new StudentExport($token), $file);
    }
}
