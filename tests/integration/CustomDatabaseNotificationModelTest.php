<?php namespace JobApis\JobsToMail\Tests\Integration;

use JobApis\JobsToMail\Models\CustomDatabaseNotification;
use JobApis\JobsToMail\Models\Search;
use JobApis\JobsToMail\Tests\TestCase;

class CustomDatabaseNotificationModelTest extends TestCase
{
    public function testItCanGetAssociatedModelSearch()
    {
        $notification = CustomDatabaseNotification::with('search')->first();
        $this->assertEquals($notification->search_id, $notification->search->id);
    }

    public function testItCanSaveDataAndSearchId()
    {
        $jobs = [
            ['name' => uniqid()]
        ];
        $search_id = Search::first()->id;

        $attributes = [
            'id' => $this->faker->uuid(),
            'type' => 'JobApis\JobsToMail\Notifications\JobsCollected',
            'notifiable_id' => $this->faker->uuid(),
            'notifiable_type' => 'user',
            'data' => [
                'jobs' => $jobs,
                'search_id' => $search_id,
            ],
            'read_at' => null,
        ];
        $notification = new CustomDatabaseNotification($attributes);
        $notification->save();

        $this->assertEquals($search_id, $notification->search_id);
        $this->assertEquals($jobs, $notification->data);
    }
}
