<?php namespace JobApis\JobsToMail\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use JobApis\JobsToMail\Notifications\Messages\JobMailMessage;

class JobsCollected extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var array of Job objects
     */
    protected $jobs;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($jobs = [])
    {
        $this->jobs = $jobs;
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
        $count = count($this->jobs);
        $message = new JobMailMessage();
        $message->viewData['user_id'] = $notifiable->id;
        $message->subject($count.' job listings found especially for you')
            ->greeting('Hello,')
            ->line('We found the following jobs that we think you\'ll be interested in based on your search:');
        foreach ($this->jobs as $job) {
            $message->listing($job);
        }
        return $message;
    }
}
