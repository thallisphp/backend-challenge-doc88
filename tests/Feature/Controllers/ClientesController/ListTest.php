<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\TestCase;

/**
 * Testes de listagem de clientes
 *
 * @testdox Listar clientes
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class ListTest extends TestCase {
    /**
     * Retorna a url que será testada
     *
     * @param array $params Parâmetros extras da url passados por GET
     *
     * @return string URL final
     */
    private function route( array $params = [] ) : string {
        return route('api.cliente.index', $params);
    }
}
