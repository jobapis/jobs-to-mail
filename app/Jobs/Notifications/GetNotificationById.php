<?php namespace JobApis\JobsToMail\Jobs\Notifications;

use Illuminate\Database\Query\Builder;
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
     * Get a single notification by ID
     *
     * @return Builder
     */
    public function handle(CustomDatabaseNotification $notifications)
    {
        return $notifications->with('search')
            ->where('id', $this->id)
            ->first();
    }
}
