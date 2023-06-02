<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RewardDayItem;
use Faker\Generator as Faker;

$factory->define(RewardDayItem::class, function (Faker $faker) {

    return [
        'quantity' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
