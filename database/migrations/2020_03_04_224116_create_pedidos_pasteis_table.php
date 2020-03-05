<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosPasteisTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pedidos_pasteis', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId('pedido_id');
            $table->foreignId('pastel_id');
            $table->unsignedTinyInteger('quantidade');

            $table->foreign('pedido_id')
                  ->references('id')
                  ->on('pedidos')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');

            $table->foreign('pastel_id')
                  ->references('id')
                  ->on('pasteis')
                  ->onUpdate('restrict')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pedidos_pasteis');
    }
}
