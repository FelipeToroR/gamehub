<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\games;
use Faker\Generator as Faker;

$factory->define(games::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'enabled' => $faker->word,
        'file' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
