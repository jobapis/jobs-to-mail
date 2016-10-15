<?php

/*
|--------------------------------------------------------------------------
| Search Factory
|--------------------------------------------------------------------------
*/

$factory->define(\JobApis\JobsToMail\Models\Search::class, function (Faker\Generator $faker) {
    return [
        'keyword' => $faker->word(),
        'location' => $faker->word().', '.$this->faker->word(),
    ];
});
$factory->state(\JobApis\JobsToMail\Models\Search::class, 'deleted', function (Faker\Generator $faker) {
    return [
        'deleted_at' => $faker->dateTimeThisYear(),
    ];
});
