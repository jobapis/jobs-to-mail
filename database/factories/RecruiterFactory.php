<?php

/*
|--------------------------------------------------------------------------
| Recruiter Factory
|--------------------------------------------------------------------------
*/

$factory->define(\JobApis\JobsToMail\Models\Recruiter::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company(),
        'url' => $faker->url(),
    ];
});
