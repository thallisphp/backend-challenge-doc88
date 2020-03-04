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

            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->date('data_de_nascimento');
            $table->string('endereco');
            $table->string('complemento')->nullable();
            $table->string('bairro');
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
