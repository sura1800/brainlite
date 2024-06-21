<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['title','group_id', 'slug', 'main_image', 'content', 'short_content', 'status', 'meta_title', 'meta_keywords', 'meta_description'];
}
