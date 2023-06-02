<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\GameExercise;
use Faker\Generator as Faker;

$factory->define(GameExercise::class, function (Faker $faker) {

    return [
        'exercise' => $faker->text,
        'user_response' => $faker->text,
        'response' => $faker->text,
        'extra' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
