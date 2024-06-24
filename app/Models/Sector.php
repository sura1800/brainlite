<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="sectors";
    protected $primaryKey = 'sector_id';
    protected $softDelete = true;
    protected $fillable = ['sector_id','sector_name','status','created_at', 'updated_at'];

}
