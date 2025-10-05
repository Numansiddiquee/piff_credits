<?php

namespace App\Services;

use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendEmail($data)
    {
//        dd($data);
        Mail::send([], [], function ($message) use ($data) {
            // Ensure email fields are arrays
            $toEmails = is_array($data['to_email']) ? $data['to_email'] : [$data['to_email']];
            $ccEmails = !empty($data['cc_email']) ? (is_array($data['cc_email']) ? $data['cc_email'] : [$data['cc_email']]) : [];
            $bccEmails = !empty($data['bcc_email']) ? (is_array($data['bcc_email']) ? $data['bcc_email'] : [$data['bcc_email']]) : [];

            $message->to($toEmails)
                ->subject($data['subject'])
                ->html($data['body']);

            if (!empty($ccEmails)) {
                $message->cc($ccEmails);
            }

            if (!empty($bccEmails)) {
                $message->bcc($bccEmails);
            }

            // Attach files
            if (!empty($data['attachments'])) {
                foreach ($data['attachments'] as $file) {
                    $message->attach($file);
                }
            }
        });

        // Store email log in the database
        return EmailLog::create([
            'to_email'   => json_encode($data['to_email']), // Store as JSON
            'cc_email'   => json_encode($data['cc_email'] ?? []),
            'bcc_email'  => json_encode($data['bcc_email'] ?? []),
            'subject'    => $data['subject'],
            'body'       => $data['body'],
            'model_type' => $data['model_type'],
            'model_id'   => $data['model_id'],
            'source'     => $data['source'],
            'attachments' => json_encode($data['attachments'] ?? []),
        ]);
    }
}
