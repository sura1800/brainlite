<?php

namespace App\Models;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDoc extends Model
{
    use HasFactory;

    protected $fillable = ['uqid', 'aadhaar_no', 'noc_no', 'location', 'doc_file', 'slug', 'admin_comment', 'customer_comment'];

    public function ledgers()
    {
        return $this->belongsToMany(LedgerDoc::class)->withTimestamps();
    }
}
