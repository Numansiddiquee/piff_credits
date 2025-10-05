<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuoteItem extends Model
{
    use HasFactory;
    
    protected $fillable = ['quote_id', 'user_id', 'item_id','item_name', 'description', 'quantity', 'price', 'total'];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function item()
    {
        return $this->hasOne(Item::class,'id','item_id');
    }
}
