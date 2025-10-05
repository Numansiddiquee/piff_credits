<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function uploader() {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
