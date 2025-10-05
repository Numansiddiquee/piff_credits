<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsComment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function performer()
    {
        return $this->morphTo(null, 'action_from', 'user_id');
    }
}
