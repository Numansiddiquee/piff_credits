<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'country',
        'state',
        'city',
        'zip_code',
        'status',
        'logo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
