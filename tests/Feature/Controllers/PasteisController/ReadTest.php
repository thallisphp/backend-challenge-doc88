<?php

namespace Tests\Feature\Controllers\PasteisController;

use App\Models\Pastel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de leitura de pastéis
 *
 * @testdox Ler pastel
 *
 * @package Tests\Feature\Controllers\PasteisController
 */
class ReadTest extends TestCase {
    use RequiresAuthentication;
    use RefreshDatabase;

    private const Method = 'getJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do pastel
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.pastel.show', ['pastel' => $id]);
    }

    /**
     * @testdox ID de pastel inválido
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->getJson($this->route());

        $response->assertNotFound();
    }

    /**
     * @testdox ID de pastel deletado
     */
    public function testDeleted() : void {
        $this->actingAs($this->user());

        /** @var Pastel $pastel */
        $pastel = factory(Pastel::class)->create();
        $pastel->delete();

        $response = $this->getJson($this->route($pastel->id));

        $response->assertNotFound();
    }

    /**
     * @testdox ID de pastel válido
     */
    public function testValid() : void {
        $this->actingAs($this->user());

        /** @var Pastel $pastel */
        $pastel = factory(Pastel::class)->create();

        $response = $this->getJson($this->route($pastel->id));

        $response->assertOk();

        $response->assertJsonStructure([
            'nome',
            'preco',
            'foto',
        ]);

        $response->assertJson($pastel->toArray());
    }
}
