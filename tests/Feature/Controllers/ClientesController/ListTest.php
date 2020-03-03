<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de listagem de clientes
 *
 * @testdox Listar clientes
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class ListTest extends TestCase {
    use RequiresAuthentication;

    private const Method = 'getJson';

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
