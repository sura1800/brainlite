<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tcid extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="tcids";
    protected $primaryKey = 'tcid_id';
    protected $softDelete = true;
    protected $fillable = ['tcid_id','tcid','status','created_at', 'updated_at'];
}
