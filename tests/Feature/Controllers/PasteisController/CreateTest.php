<?php

namespace Tests\Feature\Controllers\PasteisController;

use App\Models\Pastel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Controllers\RequiresAuthentication;
use Tests\TestCase;

/**
 * Testes de criação de pastéis
 *
 * @testdox Criar pastel
 *
 * @package Tests\Feature\Controllers\PasteisController
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
        return route('api.pastel.store');
    }

    /**
     * @testdox Dados inválidos informados
     */
    public function testInvalidRequest() : void {
        $this->actingAs($this->user());

        $response = $this->postJson($this->route(), [
            'nome'  => 'a',
            'preco' => 'aaa',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'nome',
            'preco',
            'foto',
        ]);
    }

    /**
     * @testdox Dados válidos informados
     */
    public function testValidRequest() : void {
        $this->actingAs($this->user());

        /** @var Pastel $pastel */
        $pastel = factory(Pastel::class)->make();
        $table  = $pastel->getTable();

        Storage::fake('public');

        $dados         = $pastel->attributesToArray();
        $dados['foto'] = UploadedFile::fake()->image('pastel.jpg');

        $response = $this->postJson($this->route(), $dados);

        $response->assertSuccessful();

        $this->assertDatabaseHas($table, [
            'nome'       => $pastel->nome,
            'preco'      => $pastel->preco,
            'deleted_at' => null,
        ]);

        Storage
            ::disk('public')
            ->assertExists('pasteis/' . $dados['foto']->hashName());
    }
}
