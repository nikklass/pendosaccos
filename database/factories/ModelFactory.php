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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'gender' => $faker->randomElement($array = array ('m','f')),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Sacco::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->realText(rand(15, 30)),
        'description' => $faker->paragraph,
        'physical_address' => $faker->address,
        'email' => $faker->unique()->safeEmail,
        'box' => $faker->realText(rand(25, 50)),
        'phone' => $faker->phone,
        'latitude' => $faker->phone,
        'longitude' => $faker->phone
    ];
});

