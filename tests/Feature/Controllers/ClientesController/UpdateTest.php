<?php

namespace Tests\Feature\Controllers\ClientesController;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
    use WithFaker;
    use RefreshDatabase;

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

    /**
     * Gera um cliente para executar os testes
     *
     * @return Cliente
     */
    private function cliente() : Cliente {
        return factory(Cliente::class)->create();
    }

    /**
     * @testdox ID de cliente inválido
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

        $cliente   = $this->cliente();
        $table     = $cliente->getTable();
        $modificar = [
            'nome' => 'a',
        ];

        $response = $this->patchJson($this->route($cliente->id), $modificar);

        $response->assertJsonValidationErrors([
            'nome',
        ]);

        $this->assertDatabaseHas($table, [
            'id'         => $cliente->id,
            'nome'       => $cliente->nome,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseMissing($table, [
            'id'         => $cliente->id,
            'nome'       => $modificar['nome'],
            'deleted_at' => null,
        ]);
    }

    /**
     * @testdox Cliente deletado
     */
    public function testDeleted() : void {
        $this->actingAs($this->user());

        $cliente   = $this->cliente();
        $modificar = [
            'nome'  => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $response = $this->patchJson($this->route($cliente->id), $modificar);

        $response->assertNotFound();
    }

    /**
     * @testdox Dados válidos informados
     */
    public function testValid() : void {
        $this->actingAs($this->user());

        $cliente   = $this->cliente();
        $table     = $cliente->getTable();
        $modificar = [
            'nome'  => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $response = $this->patchJson($this->route($cliente->id), $modificar);

        $response->assertOk();

        $this->assertDatabaseMissing($table, [
            'id'         => $cliente->id,
            'nome'       => $cliente->nome,
            'email'      => $cliente->email,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseHas($table, [
            'id'         => $cliente->id,
            'nome'       => $modificar['nome'],
            'email'      => $modificar['email'],
            'deleted_at' => null,
        ]);
    }
}
