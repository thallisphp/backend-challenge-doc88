<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\TestCase;

/**
 * Testes de leitura de clientes
 *
 * @testdox Ler cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class ReadTest extends TestCase {
    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do cliente
     *
     * @return string URL final
     */
    private function route( int $id ) : string {
        return route('api.cliente.show', ['cliente' => $id]);
    }
}
