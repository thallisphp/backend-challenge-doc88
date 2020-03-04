<?php

namespace Tests\Feature\Controllers\ClientesController;

use App\Models\Cliente;
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

    /**
     * @testdox ID de cliente inválido
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->deleteJson($this->route());

        $response->assertNotFound();
    }

    /**
     * @testdox ID de cliente deletado
     */
    public function testDeleted() : void {
        $this->actingAs($this->user());

        /** @var Cliente $cliente */
        $cliente = factory(Cliente::class)->create();
        $cliente->delete();

        $response = $this->getJson($this->route($cliente->id));

        $response->assertNotFound();
    }

    /**
     * @testdox ID de cliente válido
     */
    public function testValid() : void {
        $this->actingAs($this->user());

        /** @var Cliente $cliente */
        $cliente = factory(Cliente::class)->create();

        $response = $this->getJson($this->route($cliente->id));

        $response->assertOk();

        $response->assertJsonStructure([
            'nome',
            'email',
            'telefone',
            'data_de_nascimento',
            'endereco',
            'complemento',
            'bairro',
            'cep',
            'created_at',
        ]);

        $response->assertJson($cliente->toArray());
    }
}
