<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WriteOff extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','invoice_id', 'writeoff_date', 'reason'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
