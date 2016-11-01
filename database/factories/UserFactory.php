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
        'tier' => config('app.user_tiers.free'),
    ];
});
$factory->state(\JobApis\JobsToMail\Models\User::class, 'active', function (Faker\Generator $faker) {
    return [
        'confirmed_at' => $faker->dateTimeThisYear(),
    ];
});
$factory->state(\JobApis\JobsToMail\Models\User::class, 'premium', function (Faker\Generator $faker) {
    return [
        'tier' => config('app.user_tiers.premium'),
    ];
});
$factory->state(\JobApis\JobsToMail\Models\User::class, 'deleted', function (Faker\Generator $faker) {
    return [
        'deleted_at' => $faker->dateTimeThisYear(),
    ];
});
