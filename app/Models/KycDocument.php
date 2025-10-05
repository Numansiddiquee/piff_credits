<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KycDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'verification_id',
        'type',
        'file_path',
        'sumsub_doc_id',
        'status',
    ];


    public function verification()
    {
        return $this->belongsTo(VerificationRequest::class, 'verification_id');
    }
}
