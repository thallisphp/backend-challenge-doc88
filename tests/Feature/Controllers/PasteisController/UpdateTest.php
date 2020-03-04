<?php

namespace Tests\Feature\Controllers\PasteisController;

use App\Models\Pastel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de atualização de pastéis
 *
 * @testdox Atualizar pastel
 *
 * @package Tests\Feature\Controllers\PasteisController
 */
class UpdateTest extends TestCase {
    use RequiresAuthentication;
    use WithFaker;
    use RefreshDatabase;

    private const Method = 'patchJson';

    /**
     * Retorna a url que será testada
     *
     * @param int $id ID do pastel
     *
     * @return string URL final
     */
    private function route( int $id = 0 ) : string {
        return route('api.pastel.update', ['pastel' => $id]);
    }

    /**
     * Gera um pastel para executar os testes
     *
     * @return Pastel
     */
    private function pastel() : Pastel {
        return factory(Pastel::class)->create();
    }

    /**
     * @testdox ID de pastel inválido
     */
    public function testNotFound() : void {
        $this->actingAs($this->user());

        $response = $this->patchJson($this->route());

        $response->assertNotFound();
    }

    /**
     * @testdox Dados inválidos informados
     */
    public function testInvalid() : void {
        $this->actingAs($this->user());

        $pastel    = $this->pastel();
        $table     = $pastel->getTable();
        $modificar = [
            'nome' => 'a',
        ];

        $response = $this->patchJson($this->route($pastel->id), $modificar);

        $response->assertJsonValidationErrors([
            'nome',
        ]);

        $this->assertDatabaseHas($table, [
            'id'         => $pastel->id,
            'nome'       => $pastel->nome,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseMissing($table, [
            'id'         => $pastel->id,
            'nome'       => $modificar['nome'],
            'deleted_at' => null,
        ]);
    }

    /**
     * @testdox Pastel deletado
     */
    public function testDeleted() : void {
        $this->actingAs($this->user());

        $pastel    = $this->pastel();
        $modificar = [
            'nome'  => $this->faker->name,
            'preco' => $this->faker->randomFloat(2, 1, 100),
        ];

        $pastel->delete();

        $response = $this->patchJson($this->route($pastel->id), $modificar);

        $response->assertNotFound();
    }

    /**
     * @testdox Dados válidos informados
     */
    public function testValid() : void {
        $this->actingAs($this->user());

        $pastel    = $this->pastel();
        $table     = $pastel->getTable();
        $modificar = [
            'nome'  => $this->faker->name,
            'preco' => $this->faker->randomFloat(2, 1, 100),
        ];

        $response = $this->patchJson($this->route($pastel->id), $modificar);

        $response->assertSuccessful();

        $this->assertDatabaseMissing($table, [
            'id'         => $pastel->id,
            'nome'       => $pastel->nome,
            'preco'      => $pastel->preco,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseHas($table, [
            'id'         => $pastel->id,
            'nome'       => $modificar['nome'],
            'preco'      => $modificar['preco'],
            'deleted_at' => null,
        ]);
    }
}
