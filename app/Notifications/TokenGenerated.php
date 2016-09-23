<?php

namespace JobApis\JobsToMail\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use JobApis\JobsToMail\Models\Token;

class TokenGenerated extends Notification
{
    use Queueable;

    /**
     * @var Token
     */
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = env("APP_URL").'users/confirm/'.$this->token->token;
        return (new MailMessage)
            ->subject('Confirm your email address to start receiving jobs')
            ->line('Thank you for joining JobsToMail.com!')
            ->line('We would like to start sending job opportunities to you at this email address, but we need you to confirm it first.')
            ->action('Confirm Email', $url)
            ->line('Once confirmed, you will start receiving emails within 24 hours.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
