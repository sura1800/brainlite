<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="students";
    protected $primaryKey = 'student_id';
    protected $softDelete = true;
    protected $fillable = ['student_id', 'username', 'student_name', 'candidate_reg_id','mobile_no','tp_id','project_type','sector','batch_id','acadamic_year','qp_code','job_role','training_location','state','aadhar_no','created_at', 'updated_at'];
}
