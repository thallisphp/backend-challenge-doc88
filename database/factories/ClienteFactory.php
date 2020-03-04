<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cliente;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function ( Faker $faker ) {
    return [
        'nome'               => $faker->name,
        'email'              => $faker->email,
        'telefone'           => $faker->phoneNumber,
        'data_de_nascimento' => $faker->dateTimeThisCentury(Carbon::now()->subYears(14)),
        'endereco'           => $faker->streetAddress,
        'complemento'        => $faker->secondaryAddress,
        'bairro'             => $faker->company,
        'cep'                => $faker->postcode,
    ];
});
