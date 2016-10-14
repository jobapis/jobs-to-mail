<?php

/*
|--------------------------------------------------------------------------
| Token Factory
|--------------------------------------------------------------------------
*/

$factory->define(\JobApis\JobsToMail\Models\Token::class, function (Faker\Generator $faker) {
    return [
        'user_id' => null,
        'type' => 'confirm',
    ];
});
