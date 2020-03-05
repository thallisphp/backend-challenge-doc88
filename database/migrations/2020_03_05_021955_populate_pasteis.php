<?php

use App\Models\Pastel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class PopulatePasteis extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        collect([
            'Frango'             => 7.5,
            'Carne'              => 8.25,
            'Queijo'             => 4.99,
            'Escarola com bacon' => 10.05,
        ])->each(function ( float $preco, string $nome ) : void {
            Pastel::query()->create([
                'nome'  => $nome,
                'preco' => $preco,
                'foto'  => 'pasteis/' . Str::slug($nome) . '.jpg',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
