<?php

use App\Criteria;
use App\Event;
use Faker\Generator as Faker;


$factory->define(Criteria::class, function (Faker $faker) {
    return array(
        'name' => $faker->text,
        'event_id' => factory(Event::class)->create()->id,
        'description' => $faker->paragraph,
        'max_points' => $faker->numberBetween(10, 20),
        'percentage' => $faker->numberBetween(1, 100)
    );
});

