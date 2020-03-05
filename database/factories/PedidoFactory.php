<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cliente;
use App\Models\Pastel;
use App\Models\Pedido;
use Faker\Generator as Faker;

$factory
    ->define(Pedido::class, function ( Faker $faker ) {
        /** @var Cliente $cliente */
        $cliente = factory(Cliente::class)->create();

        return [
            'cliente_id' => $cliente->id,
        ];
    })
    ->afterCreating(Pedido::class, function ( Pedido $pedido ) : void {
        factory(Pastel::class)
            ->times(rand(1, 20))
            ->create()
            ->each(function ( Pastel $pastel ) use ( $pedido ) : void {
                $pedido->pasteis()->save($pastel, [
                    'quantidade' => rand(1, 100),
                ]);
            });
    });
