<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ClientCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $temporaryPassword;

    public function __construct(User $user, string $temporaryPassword)
    {
        $this->user = $user;
        $this->temporaryPassword = $temporaryPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Your Account Has Been Created');
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.client_created',
            with: [
                'user' => $this->user,
                'temporaryPassword' => $this->temporaryPassword,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
