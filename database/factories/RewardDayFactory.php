<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RewardDay;
use Faker\Generator as Faker;

$factory->define(RewardDay::class, function (Faker $faker) {

    return [
        'day' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
