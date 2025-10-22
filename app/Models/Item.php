<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','type','name','description','selling_price'];
    
    public function createdBy()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function invoice()
    {
        return $this->hasMany(InvoiceItem::class,'item_id','id');
    }
}
