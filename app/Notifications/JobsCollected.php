<?php namespace JobApis\JobsToMail\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Notifications\Messages\JobMailMessage;

class JobsCollected extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var array of Job objects
     */
    protected $jobs;

    /**
     * @var Search
     */
    protected $search;

    /**
     * Create a new notification instance.
     *
     * @param array $jobs
     * @param Search $search
     *
     * @return void
     */
    public function __construct(array $jobs, Search $search)
    {
        $this->jobs = $jobs;
        $this->search = $search;
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
            ->line('We found the following jobs that we think you\'ll be interested in based on your search:')
            ->line("\"{$this->search->keyword}\" in \"{$this->search->location}\"");
        foreach ($this->jobs as $job) {
            $message->listing($job);
        }
        return $message;
    }
}
