<?php

use App\Participant;
use App\Event;
use Faker\Generator as Faker;


$factory->define(Participant::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class)->create()->id,
        'name' => $faker->name
    ];
});
