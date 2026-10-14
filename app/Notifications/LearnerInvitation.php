<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LearnerInvitation extends Notification
{
    public function __construct(
        public string $token
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/invitations/accept/'.$this->token);

        return (new MailMessage)
            ->subject('You are invited to NeuralPath')
            ->greeting('Welcome to NeuralPath!')
            ->line(
                'You have been invited to join our private AI Engineering learning platform.'
            )
            ->line(
                'Your invitation is valid for 24 hours.'
            )
            ->action('Accept Invitation', $url)
            ->line(
                'If you were not expecting this invitation, you can ignore this email.'
            );
    }
}
