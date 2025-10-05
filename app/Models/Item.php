<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    
    public function company()
    {
        return $this->hasOne(Company::class,'id','company_id');
    }
}
