<?php

namespace Tests\Feature\Controllers\ClientesController;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de remoção de clientes
 *
 * @testdox Remover cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class DestroyTest extends TestCase {
    use RequiresAuthentication;
    use WithFaker;
    use RefreshDatabase;

    private const Method = 'deleteJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do cliente
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.cliente.destroy', ['cliente' => $id]);
    }

    /**
     * @testdox ID inválido informado
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->deleteJson($this->route());

        $response->assertStatus(404);
    }

    /**
     * @testdox ID válido informado
     */
    public function testValidRequest() : Cliente {
        $this->actingAs($this->user());

        /** @var Cliente $cliente */
        $cliente = factory(Cliente::class)->create();
        $table   = $cliente->getTable();

        $response = $this->deleteJson($this->route($cliente->id));

        $response->assertOk();

        $this->assertDatabaseMissing($table, [
            'id'         => $cliente->id,
            'deleted_at' => null,
        ]);

        return $cliente;
    }
}
