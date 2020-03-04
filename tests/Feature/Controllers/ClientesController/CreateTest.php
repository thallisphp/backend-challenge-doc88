<?php

namespace Tests\Feature\Controllers\ClientesController;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de criação de clientes
 *
 * @testdox Criar cliente
 *
 * @package Tests\Feature\Controllers\ClientesController
 */
class CreateTest extends TestCase {
    use RequiresAuthentication;
    use WithFaker;
    use RefreshDatabase;

    private const Method = 'postJson';

    /**
     * Retorna a url que será testada
     *
     * @return string URL final
     */
    private function route() : string {
        return route('api.cliente.store');
    }

    /**
     * @testdox Dados inválidos informados
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->postJson($this->route(), [
            'nome'               => 'a',
            'email'              => 'aaaaaa',
            'telefone'           => 'aaaaaa',
            'data_de_nascimento' => Carbon::tomorrow()->format('d/m/Y'),
            'endereco'           => 'aaa',
            'complemento'        => $this->faker->paragraphs(10),
            'bairro'             => 'a',
            'cep'                => $this->faker->phoneNumber,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'nome',
            'email',
            'telefone',
            'data_de_nascimento',
            'endereco',
            'complemento',
            'bairro',
            'cep',
        ]);
    }

    /**
     * @testdox Dados válidos informados
     */
    public function testValidRequest() : Cliente {
        $this->actingAs($this->user());

        /** @var Cliente $cliente */
        $cliente = factory(Cliente::class)->make();
        $table   = $cliente->getTable();

        $response = $this->postJson($this->route(), $cliente->attributesToArray());

        $response->assertSuccessful();

        $this->assertDatabaseHas($table, [
            'nome'       => $cliente->nome,
            'email'      => $cliente->email,
            'deleted_at' => null,
        ]);

        return $cliente;
    }

    /**
     * @testdox Dados válidos informados porém o email já foi cadastrado
     */
    public function testDuplicatedEmail() : void {
        $cliente = $this->testValidRequest();

        $response = $this->postJson($this->route(), $cliente->attributesToArray());

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email',
        ]);
    }
}
