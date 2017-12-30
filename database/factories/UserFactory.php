<?php

/*
|--------------------------------------------------------------------------
| User Factory
|--------------------------------------------------------------------------
*/

$factory->define(\JobApis\JobsToMail\Models\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->safeEmail(),
        'confirmed_at' => null,
        'max_searches' => $faker->optional()->numberBetween(5, 10),
    ];
});
$factory->state(\JobApis\JobsToMail\Models\User::class, 'active', function (Faker\Generator $faker) {
    return [
        'confirmed_at' => $faker->dateTimeThisYear(),
    ];
});
$factory->state(\JobApis\JobsToMail\Models\User::class, 'deleted', function (Faker\Generator $faker) {
    return [
        'deleted_at' => $faker->dateTimeThisYear(),
    ];
});
