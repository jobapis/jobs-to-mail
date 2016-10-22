<?php

/*
|--------------------------------------------------------------------------
| Recruiter Factory
|--------------------------------------------------------------------------
*/

$factory->define(\JobApis\JobsToMail\Models\Recruiter::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->company(),
        'url' => $faker->url(),
    ];
});
