<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Shop::class, function (Faker\Generator $faker) {
    return [
        'width' => rand(5,100),
        'height' => rand(5,100),
    ];
});

$factory->define(App\Models\Robot::class, function (Faker\Generator $faker) {
    $seed = str_split("MLR");
    $result = '';
    for ($i = 0; $i < 20; $i++){
        $result .= $seed[mt_rand(0, 2)];
    }

    return [
        'x' => rand(5,100),
        'y' => rand(5,100),
        'heading' => $faker->randomElement(['N','E','S','W']),
        'commands' => $result,
    ];
});
