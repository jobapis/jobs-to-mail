<?php namespace JobApis\JobsToMail\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;
use JobApis\Jobs\Client\Job;

class JobMailMessage extends MailMessage
{
    public $jobListings = [];
    public $advertisement = null;

    /**
     * Add a Job listing to the notification
     *
     * @param  Job $job
     *
     * @return $this
     */
    public function listing(Job $job)
    {
        $this->jobListings[] = [
            'link' => $job->getUrl(),
            'title' => $this->getTitle($job->getTitle()),
            'company' => $this->getCompany($job->getCompanyName(), $job->getIndustry()),
            'location' => $this->getLocation($job->getLocation()),
            'date' => $this->getDate($job->getDatePosted()),
        ];
        return $this;
    }

    /**
     * Sets the advertisement to be shown in this message.
     *
     * @param null $name
     *
     * @return $this
     */
    public function advertisement($name = null)
    {
        $this->advertisement = $name;
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
            [
                'jobListings' => $this->jobListings,
                'advertisement' => $this->advertisement,
            ]
        );
    }

    private function getTitle($title)
    {
        return $title ?: null;
    }

    private function getLocation($location)
    {
        return $location ? " in {$location}" : null;
    }

    private function getCompany($company, $industry = null)
    {
        $response = null;
        if ($company) {
            $response = " at {$company}";
            if ($industry == "Staffing") {
                $response .= " (Professional Recruiter)";
            }
        }
        return $response;
    }

    private function getDate($dateTime)
    {
        if (is_object($dateTime) && \DateTime::class == get_class($dateTime)) {
            return $dateTime->format('F j, Y');
        }
        return null;
    }
}
