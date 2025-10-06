<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'to_email', 'cc_email', 'bcc_email', 'subject', 'body',
        'model_type', 'model_id', 'source', 'attachments'
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
