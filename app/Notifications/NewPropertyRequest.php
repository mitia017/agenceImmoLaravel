<?php

namespace App\Notifications;

use App\Mail\PropertyContactMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewPropertyRequest extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $property, public array $contact) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'property_id' => $this->property->id,
            'title' => $this->property->title,
            'client' => $this->contact['firstname'].' '.$this->contact['lastname'],
            'email' => $this->contact['email'],
            'phone' => $this->contact['phone'],
            'message' => $this->contact['message'],
        ];
    }

    public function toMail(object $notifiable)
    {
        return (new PropertyContactMail($this->property, $this->contact))
            ->to($notifiable->email); // Sécurité : on précise le destinataire
    }
}
