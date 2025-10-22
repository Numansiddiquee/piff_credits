<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id','client_id','subject','company_id','user_id','invoice_number','invoice_number', 'invoice_date', 'due_date',
        'discount', 'discount_type', 'discounted_amount','terms_condition', 'subtotal', 'total','due', 'notes','status'
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
    ];
    
    public function client()
    {
        return $this->belongsTo(User::class,'client_id','id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function attachments()
    {
        return $this->hasMany(InvoiceAttachment::class);
    }

    public function writeOff()
    {
        return $this->hasOne(WriteOff::class);
    }

    public function getIsWrittenOffAttribute()
    {
        return $this->writeOff()->exists();
    }
}
