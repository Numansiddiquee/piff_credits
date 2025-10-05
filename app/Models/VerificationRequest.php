<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VerificationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'type',
        'status',
        'sumsub_applicant_id',
        'admin_comment',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function kycDocuments()
    {
        return $this->hasMany(KycDocument::class, 'verification_id');
    }

    public function kybDocuments()
    {
        return $this->hasMany(KybDocument::class, 'verification_id');
    }
}
