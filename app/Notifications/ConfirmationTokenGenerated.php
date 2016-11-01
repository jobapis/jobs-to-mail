<?php namespace JobApis\JobsToMail\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use JobApis\JobsToMail\Models\Token;

class ConfirmationTokenGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Token
     */
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param Token $token
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
        $url = config('app.url').'auth/confirm/'.$this->token;
        $message = new MailMessage;
        $message->viewData['user_id'] = $notifiable->id;
        return $message
            ->subject('Confirm your email address to start receiving jobs')
            ->greeting('Thank you for joining '.config('app.name'))
            ->line('In order to start sending you jobs we need you to confirm your email address.')
            ->action('Confirm Email', $url)
            ->line('Once confirmed, you will start receiving emails within 24 hours.');
    }
}
