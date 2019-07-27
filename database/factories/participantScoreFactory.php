<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\ParticipantScore;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ParticipantScore::class, function (Faker $faker) {
    return [
        'participant_id' => $faker->randomNumber(1),
        'criteria_id' => $faker->randomNumber(1),
        'score' => $faker->randomNumber(1),
        'user_id' => $faker->randomNumber(3),
    ];
});
