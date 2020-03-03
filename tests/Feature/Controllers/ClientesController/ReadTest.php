<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de leitura de clientes
 *
 * @testdox Ler cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class ReadTest extends TestCase {
    use RequiresAuthentication;

    private const Method = 'getJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do cliente
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.cliente.show', ['cliente' => $id]);
    }
}
