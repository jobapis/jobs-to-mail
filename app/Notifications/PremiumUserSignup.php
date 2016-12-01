<?php namespace JobApis\JobsToMail\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use JobApis\JobsToMail\Models\Token;

class PremiumUserSignup extends Notification
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @param Token $token
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        $message = (new MailMessage())
            ->subject('New Premium User Signup')
            ->line('A new user is interested in JobsToMail premium: ');

        foreach ($this->data as $key => $value) {
            $message->line($key . ': ' . $value);
        }

        return $message;
    }
}
