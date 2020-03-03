<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\TestCase;

/**
 * Testes de criação de clientes
 *
 * @testdox Criar cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class CreateTest extends TestCase {
    /**
     * Retorna a url que será testada
     *
     * @return string URL final
     */
    private function route() : string {
        return route('api.cliente.store');
    }
}
