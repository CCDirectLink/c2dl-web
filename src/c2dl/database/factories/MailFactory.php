<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Mail;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Mail::class, function (Faker $faker) {

    //$user = factory(App\User::class)->create();

    return [
        'id' => $faker->re,
        'active' => false,
        'remember_token' => Str::random(10),
    ];
});
