<?php

/*
|--------------------------------------------------------------------------
| Notification Factory
|--------------------------------------------------------------------------
*/
$notificationClass = \JobApis\JobsToMail\Models\CustomDatabaseNotification::class;

$factory->define($notificationClass, function (Faker\Generator $faker) {
    return [
        'id' => $faker->uuid(),
        'type' => 'JobApis\JobsToMail\Notifications\JobsCollected',
        'notifiable_id' => null,
        'notifiable_type' => 'user',
        'data' => json_encode([]),
        'read_at' => null,
    ];
});
