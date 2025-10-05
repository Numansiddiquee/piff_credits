<?php

namespace App\Services;

use App\Models\LogsComment;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use App\Models\User;

class LogService
{
    public function addLog($client_id, $action_type, $action_id, $log_type, $log_title = null,$log,$performerType)
    {
        $uuid = Uuid::uuid7();
        $newLogComment = new LogsComment();
        $newLogComment->unique_id = $uuid->toString();
        $newLogComment->user_id = Auth::user()->id;
        $newLogComment->company_id = Auth::user()->company_id;
        $newLogComment->client_id = $client_id;
        $newLogComment->action_type = $action_type;
        $newLogComment->action_from = $performerType ? $performerType : User::class;
        $newLogComment->action_id = $action_id;
        $newLogComment->type = $log_type;
        $newLogComment->log_title = $log_title;
        $newLogComment->log_comment_text = $log;
        $newLogComment->save();
        return true;
    }
}
