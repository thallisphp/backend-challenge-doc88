<?php

namespace Tests\Feature\Controllers\PedidosController;

use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de listagem de pedidos
 *
 * @testdox Listar pedidos
 *
 * @package Tests\Feature\Controllers\PedidosController
 */
class ListTest extends TestCase {
    use RequiresAuthentication;
    use RefreshDatabase;

    private const Method = 'getJson';

    /**
     * Retorna a url que será testada
     *
     * @return string URL final
     */
    private function route() : string {
        return route('api.pedido.index');
    }

    /**
     * @testdox Listar pedidos
     */
    public function testValid() {
        $this->actingAs($this->user());

        /**
         * @var Collection $pedidos Pedidos carregados na primeira página
         * @var Collection $outros  Outros pedidos que serão carregados nas próximas páginas
         */
        $pedidos = factory(Pedido::class)->times(rand(2, 5))->create();
        $outros  = factory(Pedido::class)->times(rand(50, 100))->create();

        $response = $this->getJson($this->route());

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'id',
                    'cliente_id',
                    'cliente_nome',
                    'created_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);

        $response->assertJsonFragment([
            'total' => $pedidos->count() + $outros->count(),
        ]);

        $pedidos->each(function ( Pedido $pedido ) use ( $response ) : void {
            $response->assertJsonFragment($pedido->toListArray());

            $this->assertDatabaseHas($pedido->getTable(), [
                'id'         => $pedido->id,
                'deleted_at' => null,
            ]);
        });
    }
}
