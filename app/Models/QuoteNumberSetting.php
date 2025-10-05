<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteNumberSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'is_auto_generate',
        'prefix',
        'next_number',
    ];
}
