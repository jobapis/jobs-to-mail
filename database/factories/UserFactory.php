<?php

/*
|--------------------------------------------------------------------------
| User Factory
|--------------------------------------------------------------------------
*/

$factory->define(\JobApis\JobsToMail\Models\User::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->safeEmail(),
        'keyword' => $faker->word(),
        'location' => $faker->word().', '.$this->faker->word(),
        'confirmed_at' => null,
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
