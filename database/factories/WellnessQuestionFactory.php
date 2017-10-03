<?php

use Faker\Generator as Faker;

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

$factory->define(App\WellnessQuestion::class, function (Faker $faker) {

    return [
        'question' => $faker->text($maxNbChars = 100).'?',
        'category' => 'Wellness',
        'option_1'=> $faker->word(),
        'option_2'=> $faker->word(),
        'option_3'=> $faker->word(),
        'option_4'=> $faker->word(),
    ];
});
