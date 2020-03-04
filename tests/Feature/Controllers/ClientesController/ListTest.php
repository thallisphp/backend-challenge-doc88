<?php

namespace Tests\Feature\Controllers\ClientesController;

use App\Models\Cliente;
use Illuminate\Support\Collection;
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
     * @return string URL final
     */
    private function route() : string {
        return route('api.cliente.index');
    }

    /**
     * @testdox Listar clientes
     */
    public function testValid() {
        $this->actingAs($this->user());

        /**
         * @var Collection $clientes Clientes carregados na primeira página
         * @var Collection $outros   Outros clientes que serão carregados nas próximas páginas
         */
        $clientes = factory(Cliente::class)->times(rand(2, 5))->create();
        $outros   = factory(Cliente::class)->times(rand(50, 100))->create();

        $response = $this->getJson($this->route());

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
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
            'total' => $clientes->count() + $outros->count(),
        ]);

        $clientes->each(function ( Cliente $cliente ) use ( $response ) : void {
            $response->assertJsonFragment($cliente->toArray());

            $this->assertDatabaseHas($cliente->getTable(), [
                'id' => $cliente->id,
            ]);
        });
    }
}
