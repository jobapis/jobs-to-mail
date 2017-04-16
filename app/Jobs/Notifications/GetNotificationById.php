<?php namespace JobApis\JobsToMail\Jobs\Notifications;

use JobApis\JobsToMail\Filters\JobFilter;
use JobApis\JobsToMail\Models\CustomDatabaseNotification;

class GetNotificationById
{
    /**
     * @var string $id Notification ID
     */
    protected $id;

    /**
     * Create a new job instance.
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Generate a CSV a single notification and return the file path
     *
     * @return string file path for download
     */
    public function handle(
        CustomDatabaseNotification $notifications,
        JobFilter $jobFilter
    ) {
        // Get the jobs from the Database
        return $notifications->with('search')
            ->where('id', $this->id)
            ->first();
    }
}
