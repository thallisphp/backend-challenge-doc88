<?php

use App\Models\Pastel;
use Illuminate\Database\Seeder;

class PastelSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Pastel::class)
            ->times(100)
            ->create();
    }
}
