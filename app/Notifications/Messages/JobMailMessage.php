<?php namespace JobApis\JobsToMail\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;
use JobApis\Jobs\Client\Job;

class JobMailMessage extends MailMessage
{
    public $jobListings = [];

    /**
     * Add a Job listing to the notification
     *
     * @param  Job $job
     *
     * @return $this
     */
    public function listing(Job $job)
    {
        $line = "";
        $line .= $job->getTitle();
        if ($job->getCompanyName()) {
            $line .= " at {$job->getCompanyName()}";
        }
        if ($job->getLocation()) {
            $line .= " in {$job->getLocation()}";
        }
        $line .= ".";
        $this->jobListings[] = [
            'link' => $job->getUrl(),
            'text' => $line,
        ];
        return $this;
    }

    /**
     * Get the data array for the mail message.
     *
     * @return array
     */
    public function data()
    {
        return array_merge(
            $this->toArray(),
            $this->viewData,
            ['jobListings' => $this->jobListings]
        );
    }
}
