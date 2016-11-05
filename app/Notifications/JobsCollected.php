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
        return ['mail', 'database'];
    }

    /**
     * Get the array representation of the notification for saving to the database.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'search_id' => $this->search->id,
            'jobs' => $this->jobs,
        ];
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
        // Add user and search ID to view data
        $message->viewData['user_id'] = $notifiable->id;
        $message->viewData['search_id'] = $this->search->id;
        // Update the message and subject
        $message->subject($count.' job listings found especially for you')
            ->greeting('Hello,')
            ->line('We found the following jobs that we think you\'ll be interested in based on your search:')
            ->line("\"{$this->search->keyword}\" in \"{$this->search->location}\"");
        // Add jobs
        foreach ($this->jobs as $job) {
            $message->listing($job);
        }
        $message->action('Download jobs as .csv', url('/notifications/'.$this->id));
        return $message;
    }
}
