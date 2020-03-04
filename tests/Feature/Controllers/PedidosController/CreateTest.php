<?php

namespace Tests\Feature\Controllers\PedidosController;

use App\Models\Cliente;
use App\Models\Pastel;
use App\Models\Pedido;
use App\Notifications\PedidoRealizado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de criação de pedidos
 *
 * @testdox Criar pedido
 *
 * @package Tests\Feature\Controllers\PedidosController
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
        return route('api.pedido.store');
    }

    /**
     * Cria um cliente para executar os testes
     *
     * @return Cliente
     */
    private function cliente() : Cliente {
        return factory(Cliente::class)->create();
    }

    /**
     * @testdox Dados inválidos informados
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->postJson($this->route(), [
            'cliente_id' => 'a',
            'pasteis'    => [
                'a',
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'cliente_id',
            'pasteis',
        ]);
    }

    /**
     * @testdox Cliente válido, nenhum pastel
     */
    public function testInvalidRequest2() : void {
        $this->actingAs($this->user());

        $response = $this->postJson($this->route(), [
            'cliente_id' => $this->cliente()->id,
            'pasteis'    => [],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'pasteis',
        ]);
    }

    /**
     * @testdox Dados válidos informados
     */
    public function testValidRequest() : void {
        $this->actingAs($this->user());

        Notification::fake();

        /** @var Pedido $pedido */
        $table   = (new Pedido)->getTable();
        $cliente = $this->cliente();

        $pasteis = factory(Pastel::class)->times(rand(1, 20))->create();
        $pasteis = collect($pasteis)->shuffle()->map(function ( Pastel $pastel ) : array {
            return [
                'pastel_id'  => $pastel->id,
                'quantidade' => rand(1, 20),
            ];
        });

        $response = $this->postJson($this->route(), [
            'cliente_id' => $cliente->id,
            'pasteis'    => $pasteis,
        ]);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'id',
            'total',
        ]);

        ['id' => $pedido] = $response->json();

        $this->assertDatabaseHas($table, [
            'id'         => $pedido,
            'cliente_id' => $cliente->id,
            'deleted_at' => null,
        ]);

        $pasteis->each(function ( array $pastel ) use ( $pedido, $table ) : void {
            $this->assertDatabaseHas("{$table}_pasteis", [
                'pedido_id'  => $pedido,
                'pastel_id'  => $pastel['pastel_id'],
                'quantidade' => $pastel['quantidade'],
            ]);
        });

        Notification::assertSentTo(
            $cliente,
            PedidoRealizado::class,
            function ( $notification, $channels ) use ( $pedido ) {
                return in_array('mail', $channels)
                       && $notification->pedido->id === $pedido;
            }
        );
    }
}
