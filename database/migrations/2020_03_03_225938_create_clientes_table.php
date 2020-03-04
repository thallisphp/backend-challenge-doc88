<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('clientes', function ( Blueprint $table ) {
            $table->id();

            $table->string('nome', 250);
            $table->string('email', 100);
            $table->string('telefone', 20);
            $table->date('data_de_nascimento');
            $table->string('endereco', 250);
            $table->string('complemento', 250)->nullable();
            $table->string('bairro', 250);
            $table->string('cep', 9);

            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('clientes');
    }
}
