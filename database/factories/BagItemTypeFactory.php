<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BagItemType;
use Faker\Generator as Faker;

$factory->define(BagItemType::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->word,
        'actions' => $faker->text,
        'game_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
