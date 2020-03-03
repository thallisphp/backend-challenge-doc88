<?php

namespace Tests\Feature\Controllers\ClientesController;

use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de atualização de clientes
 *
 * @testdox Atualizar cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class UpdateTest extends TestCase {
    use RequiresAuthentication;

    private const Method = 'patchJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do cliente
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.cliente.update', ['cliente' => $id]);
    }
}
