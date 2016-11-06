<?php namespace JobApis\JobsToMail\Models;

use Illuminate\Notifications\DatabaseNotification;

class CustomDatabaseNotification extends DatabaseNotification
{
    /**
     * Overrides the save method so that search IDs can be added to the Notification
     * in the database
     *
     * @param array $options
     */
    public function save(array $options = [])
    {
        // Set the jobs and search id into their own fields
        $data = $this->data;
        if (isset($data['search_id']) && isset($data['jobs'])) {
            $this->data = $data['jobs'];
            $this->search_id = $data['search_id'];
        }
        parent::save();
    }
}
