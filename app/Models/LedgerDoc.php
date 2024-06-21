<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerDoc extends Model
{
    use HasFactory;

    protected $fillable = ['uqlid', 'aadhaar_no', 'ledger_file', 'slug', 'status', 'admin_comment', 'customer_comment'];

    public function legalnocs()
    {
        return $this->belongsToMany(LegalDoc::class)->withTimestamps();
    }
}
