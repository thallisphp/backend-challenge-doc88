<?php

namespace Tests\Feature\Controllers\PedidosController;

use App\Models\Pastel;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de leitura de pedidos
 *
 * @testdox Ler pedido
 *
 * @package Tests\Feature\Controllers\PedidosController
 */
class ReadTest extends TestCase {
    use RequiresAuthentication;
    use RefreshDatabase;

    private const Method = 'getJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do pedidos
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.pedido.show', ['pedido' => $id]);
    }

    /**
     * @testdox ID de pedido inválido
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->deleteJson($this->route());

        $response->assertNotFound();
    }

    /**
     * @testdox ID de pedido deletado
     */
    public function testDeleted() : void {
        $this->actingAs($this->user());

        /** @var Pedido $pedido */
        $pedido = factory(Pedido::class)->create();
        $pedido->delete();

        $response = $this->getJson($this->route($pedido->id));

        $response->assertNotFound();
    }

    /**
     * @testdox ID de pedido válido
     */
    public function testValid() : void {
        $this->actingAs($this->user());

        /** @var Pedido $pedido */
        $pedido = factory(Pedido::class)->create();

        $response = $this->getJson($this->route($pedido->id));

        $response->assertOk();

        $response->assertJsonStructure([
            'id',
            'cliente_id',
            'created_at',
            'cliente' => [
                'id',
                'nome',
                'email',
                'telefone',
                'data_de_nascimento',
                'endereco',
                'complemento',
                'bairro',
                'cep',
                'created_at',
            ],
            'pasteis' => [
                'quantidade',
                'pastel' => [
                    'id',
                    'nome',
                    'preco',
                    'foto',
                ],
            ],
        ]);

        $response->assertJson($pedido->toArray());
        $response->assertJsonFragment($pedido->cliente->toArray());

        $pedido->pasteis->each(function ( Pastel $pastel ) use ( $response ): void {
            $response->assertJsonFragment([
                'quantidade' => $pastel->pivot->quantidade,
                'pastel'     => $pastel->toArray(),
            ]);
        });
    }
}
