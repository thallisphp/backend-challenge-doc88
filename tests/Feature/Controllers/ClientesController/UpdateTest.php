<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\TestCase;

/**
 * Testes de atualização de clientes
 *
 * @testdox Atualizar cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class UpdateTest extends TestCase {
    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do cliente
     *
     * @return string URL final
     */
    private function route( int $id ) : string {
        return route('api.cliente.update', ['cliente' => $id]);
    }
}
