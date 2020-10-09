<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
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


$factory->define(\App\Domain::class, function (Faker $faker) {
  return [
    'name' => $this->faker->name,
    'create_date' => now(),
    'expiry_date' => now(),
    'is_present' =>$this->faker->boolean
  ];
});
