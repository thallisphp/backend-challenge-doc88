<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cliente;
use App\Models\Pedido;
use Faker\Generator as Faker;

$factory->define(Pedido::class, function ( Faker $faker ) {
    /** @var Cliente $cliente */
    $cliente = factory(Cliente::class)->create();

    return [
        'cliente_id' => $cliente->id,
    ];
});
