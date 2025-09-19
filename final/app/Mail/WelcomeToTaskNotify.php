<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeToTaskNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $passwordPlain;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\User $user
     * @param string $passwordPlain
     * @return void
     */
    public function __construct($user, $passwordPlain)
    {
        $this->user = $user;
        $this->passwordPlain = $passwordPlain;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome To Task Notify',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'newuser',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
