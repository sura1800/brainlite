<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyEntry extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="daily_entries";
    protected $primaryKey = 'daily_entry_id';
    protected $softDelete = true;
    protected $fillable = ['daily_entry_id','user_id','entry_date','batch_id','job_role_id','tcid_id','sector_id','images','status','created_at', 'updated_at'];

}
