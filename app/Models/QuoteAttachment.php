<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteAttachment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'quote_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function uploader() {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
