<?php

namespace Tests\Feature\Controllers\PasteisController;

use App\Models\Pastel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de remoção de pastéis
 *
 * @testdox Remover pastel
 *
 * @package Tests\Feature\Controllers\PasteisController
 */
class DestroyTest extends TestCase {
    use RequiresAuthentication;
    use RefreshDatabase;

    private const Method = 'deleteJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do pastel
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.pastel.destroy', ['pastel' => $id]);
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
    public function testValidRequest() : void {
        $this->actingAs($this->user());

        /** @var Pastel $pastel */
        $pastel = factory(Pastel::class)->create();
        $table  = $pastel->getTable();

        $response = $this->deleteJson($this->route($pastel->id));

        $response->assertOk();

        $this->assertDatabaseMissing($table, [
            'id'         => $pastel->id,
            'deleted_at' => null,
        ]);
    }
}
