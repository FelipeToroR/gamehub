<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameInstanceParameter;
use Faker\Generator as Faker;

$factory->define(GameInstanceParameter::class, function (Faker $faker) {

    return [
        'slug' => $faker->word,
        'name' => $faker->word,
        'description' => $faker->text,
        'game_instance_id' => $faker->randomDigitNotNull,
        'game_parameter_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
