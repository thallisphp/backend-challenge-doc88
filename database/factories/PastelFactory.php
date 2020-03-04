<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Pastel;
use Faker\Generator as Faker;

$factory->define(Pastel::class, function ( Faker $faker ) {
    return [
        'nome'  => $faker->name,
        'preco' => $faker->randomFloat(2, 1, 1000),
    ];
});
