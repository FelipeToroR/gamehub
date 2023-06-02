<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameParameter;
use Faker\Generator as Faker;

$factory->define(GameParameter::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'type' => $faker->word,
        'game_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
