<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobRole extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="job_roles";
    protected $primaryKey = 'job_role_id';
    protected $softDelete = true;
    protected $fillable = ['job_role_id','job_role_name','job_code','status','created_at', 'updated_at'];

}
