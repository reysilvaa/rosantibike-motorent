<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stok;
use App\Models\JenisMotor;
use App\Models\Transaksi;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed users first
        $this->call(UserSeeder::class);

        // Create stock data
        Stok::factory(10)->create()->each(function ($stok) {
            // Create related motor types
            JenisMotor::factory(5)->create(['id_stok' => $stok->id])->each(function ($jenisMotor) {
                // Create related transactions
                // Transaksi::factory(3)->create(['id_jenis' => $jenisMotor->id]);
            });
        });
    }
}
