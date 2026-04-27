<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array $data,
        public $agent
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->agent->email,
            subject: 'Réponse à votre demande'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.client-reply',
            with: [
                'data' => $this->data,
                'agent' => $this->agent,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
