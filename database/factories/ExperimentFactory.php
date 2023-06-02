<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Experiment;
use Faker\Generator as Faker;

$factory->define(Experiment::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->text,
        'status' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
