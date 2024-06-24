<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="batches";
    protected $primaryKey = 'batch_id';
    protected $softDelete = true;
    protected $fillable = ['batch_id','batch_name','status','created_at', 'updated_at'];

}
