<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'user_id',
        'client_id',
        'quote_id',
        'reference',
        'quote_date',
        'expiry_date',
        'subject',
        'client_notes',
        'subtotal',
        'discount_type',
        'discount_value',
        'total_discount',
        'grand_total',
        'terms_and_conditions',
        'status',
    ];


    public function client()
    {
        return $this->belongsTo(User::class,'client_id','id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function companyEmail()
    {
        return $this->hasOne(User::class,'company_id','company_id');
    }

    public function attachments()
    {
        return $this->hasMany(QuoteAttachment::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }
}
