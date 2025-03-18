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
        
        // Add motor seeder
        $this->call(MotorSeeder::class);
    }
}