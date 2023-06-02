<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserEntrypoint;
use Faker\Generator as Faker;

$factory->define(UserEntrypoint::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'information' => $faker->word,
        'obfuscated' => $faker->randomDigitNotNull,
        'user_response' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
