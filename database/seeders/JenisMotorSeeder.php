<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisMotorSeeder extends Seeder
{
    public function run()
    {
        $jenis_motor = [
            ['merk' => 'Yamaha Lexi', 'nopol' => 'N 1234 AA', 'harga_perHari' => 100000],
            ['merk' => 'Honda Vario 150CC', 'nopol' => 'N 5678 BB', 'harga_perHari' => 120000],
            ['merk' => 'Honda Vario 125CC', 'nopol' => 'N 9012 CC', 'harga_perHari' => 110000],
            ['merk' => 'Honda Beat FI', 'nopol' => 'N 3456 DD', 'harga_perHari' => 90000],
            ['merk' => 'Honda Beat New', 'nopol' => 'N 7890 EE', 'harga_perHari' => 95000],
            ['merk' => 'Honda Beat', 'nopol' => 'N 1122 FF', 'harga_perHari' => 80000],
            ['merk' => 'Honda Revo', 'nopol' => 'N 3344 GG', 'harga_perHari' => 70000],
        ];

        DB::table('jenis_motor')->insert($jenis_motor);
    }
}
