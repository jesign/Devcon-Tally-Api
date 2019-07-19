<?php

use App\Event;
use Faker\Generator as Faker;


$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->text,
        'description' => $faker->paragraph,
    ];
});

