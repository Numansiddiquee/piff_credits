<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Create a new notification
     *
     * @param int $userId      Recipient user ID
     * @param int|null $senderId Sender user ID (who triggered the notification)
     * @param string $type     Notification type
     * @param string $title    Notification title
     * @param string $message  Notification message
     * @param string|null $url Optional URL to redirect when clicked
     * @return Notification
     */
    public function createNotification(int $userId, ?int $senderId, string $type, string $title, string $message, ?string $url = null): Notification
    {
        return Notification::create([
            'user_id'   => $userId,
            'sender_id' => $senderId,
            'type'      => $type,
            'title'     => $title,
            'message'   => $message,
            'url'       => $url,
        ]);
    }
}
