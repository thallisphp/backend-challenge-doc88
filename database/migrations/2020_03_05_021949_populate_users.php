<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class PopulateUsers extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        User::query()->create([
            'name'     => 'Teste da Silva',
            'email'    => 'teste@teste.com',
            'password' => Hash::make('teste'),
        ]);
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
