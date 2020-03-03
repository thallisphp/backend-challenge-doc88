<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\TestCase;

/**
 * Testes de remoção de clientes
 *
 * @testdox Remover cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class DestroyTest extends TestCase {
    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do cliente
     *
     * @return string URL final
     */
    private function route( int $id ) : string {
        return route('api.cliente.destroy', ['cliente' => $id]);
    }
}
