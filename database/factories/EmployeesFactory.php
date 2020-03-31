<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmployeesModel;
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

$factory->define(EmployeesModel::class, function (Faker $faker) {
    return [
        'position_key' => random_int(1, 10),
        'name' => $faker->name(),
        'last_name' => $faker->lastName(),
        'age' => random_int(20, 50),
        'email' => $faker->unique()->safeEmail,
        'cpf' => random_int(10000000, 40000000),
        'image'=>$faker->name()
    ];
});
