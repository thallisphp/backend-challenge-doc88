<?php

/** @var Factory $factory */

use App\Models\Pastel;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Http\UploadedFile;

$factory->define(Pastel::class, function ( Faker $faker ) {
    $foto = UploadedFile::fake()->image('pastel.jpg');

    return [
        'nome'  => $faker->name,
        'preco' => $faker->randomFloat(2, 1, 1000),
        'foto'  => $foto->store('pasteis'),
    ];
});
