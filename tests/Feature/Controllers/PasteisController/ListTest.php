<?php

namespace Tests\Feature\Controllers\PasteisController;

use App\Models\Pastel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de listagem de pasteís
 *
 * @testdox Listar pasteís
 *
 * @package Tests\Feature\Controllers\PasteisController
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
        return route('api.pastel.index');
    }

    /**
     * @testdox Listar pasteís
     */
    public function testValid() {
        $this->actingAs($this->user());

        /**
         * @var Collection $pasteis Pasteís carregados na primeira página
         * @var Collection $outros  Outros pasteís que serão carregados nas próximas páginas
         */
        $pasteis = factory(Pastel::class)->times(rand(2, 5))->create();
        $outros  = factory(Pastel::class)->times(rand(50, 100))->create();

        $response = $this->getJson($this->route());

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                [
                    'id',
                    'nome',
                    'preco',
                    'foto',
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
            'total' => $pasteis->count() + $outros->count(),
        ]);

        $pasteis->each(function ( Pastel $pastel ) use ( $response ) : void {
            $response->assertJsonFragment($pastel->toArray());

            $this->assertDatabaseHas($pastel->getTable(), [
                'id'         => $pastel->id,
                'deleted_at' => null,
            ]);
        });
    }
}
