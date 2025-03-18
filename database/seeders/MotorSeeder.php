<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stok;
use App\Models\JenisMotor;
use Carbon\Carbon;

class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        JenisMotor::truncate();
        Stok::truncate();

        // Create stock entries
        $beatFl = Stok::create([
            'merk' => 'Honda',
            'judul' => 'Beat Fl',
            'harga_perHari' => 100000,
            'foto' => 'beat-fl.jpg',
            'deskripsi1' => 'Honda Beat Fl untuk rental',
            'deskripsi2' => 'Kondisi baik dan terawat',
            'deskripsi3' => 'Cocok untuk perjalanan dalam kota',
            'kategori' => 'Matic',
        ]);

        $scoopy = Stok::create([
            'merk' => 'Honda',
            'judul' => 'Scoopy',
            'harga_perHari' => 100000,
            'foto' => 'scoopy.jpg',
            'deskripsi1' => 'Honda Scoopy untuk rental',
            'deskripsi2' => 'Kondisi baik dan terawat',
            'deskripsi3' => 'Desain stylish dan nyaman',
            'kategori' => 'Matic',
        ]);

        $vario125 = Stok::create([
            'merk' => 'Honda',
            'judul' => 'Vario 125cc',
            'harga_perHari' => 120000,
            'foto' => 'vario-125.jpg',
            'deskripsi1' => 'Honda Vario 125cc untuk rental',
            'deskripsi2' => 'Kondisi baik dan terawat',
            'deskripsi3' => 'Cocok untuk perjalanan dalam kota',
            'kategori' => 'Matic',
        ]);

        $vario150 = Stok::create([
            'merk' => 'Honda',
            'judul' => 'Vario 150cc',
            'harga_perHari' => 120000,
            'foto' => 'vario-150.jpg',
            'deskripsi1' => 'Honda Vario 150cc untuk rental',
            'deskripsi2' => 'Performa tinggi dan nyaman',
            'deskripsi3' => 'Cocok untuk perjalanan jauh',
            'kategori' => 'Matic',
        ]);

        $maxiLexi = Stok::create([
            'merk' => 'Yamaha',
            'judul' => 'Maxi Lexi',
            'harga_perHari' => 125000,
            'foto' => 'maxi-lexi.jpg',
            'deskripsi1' => 'Yamaha Maxi Lexi untuk rental',
            'deskripsi2' => 'Desain sporty dan nyaman',
            'deskripsi3' => 'Cocok untuk perjalanan dalam kota',
            'kategori' => 'Matic',
        ]);

        $soulGT = Stok::create([
            'merk' => 'Yamaha',
            'judul' => 'Soul GT',
            'harga_perHari' => 80000,
            'foto' => 'soul-gt.jpg',
            'deskripsi1' => 'Yamaha Soul GT untuk rental',
            'deskripsi2' => 'Kondisi baik dan terawat',
            'deskripsi3' => 'Hemat bahan bakar',
            'kategori' => 'Matic',
        ]);

        $pcx = Stok::create([
            'merk' => 'Honda',
            'judul' => 'PCX',
            'harga_perHari' => 150000,
            'foto' => 'pcx.jpg',
            'deskripsi1' => 'Honda PCX untuk rental',
            'deskripsi2' => 'Motor premium dan nyaman',
            'deskripsi3' => 'Cocok untuk perjalanan jauh',
            'kategori' => 'Matic',
        ]);

        // Current timestamp
        $now = Carbon::now();

        // Create motorcycle types for Beat Fl
        $beatFlNopols = ['N 2045 ADK', 'N 5828 ADF', 'N 5986 ADH'];
        foreach ($beatFlNopols as $nopol) {
            JenisMotor::create([
                'id_stok' => $beatFl->id,
                'status' => 'available',
                'nopol' => $nopol,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Create motorcycle type for Scoopy
        JenisMotor::create([
            'id_stok' => $scoopy->id,
            'status' => 'available',
            'nopol' => 'N 6393 EDN',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create motorcycle type for Vario 125cc
        JenisMotor::create([
            'id_stok' => $vario125->id,
            'status' => 'available',
            'nopol' => 'N 2238 ABV',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create motorcycle types for Vario 150cc
        $vario150Nopols = ['N 3561 AAV', 'N 3317 BAZ'];
        foreach ($vario150Nopols as $nopol) {
            JenisMotor::create([
                'id_stok' => $vario150->id,
                'status' => 'available',
                'nopol' => $nopol,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Create motorcycle types for Maxi Lexi
        $maxiLexiNopols = ['N 5622 ABO', 'N 5644 ABO', 'N 2711 ABP'];
        foreach ($maxiLexiNopols as $nopol) {
            JenisMotor::create([
                'id_stok' => $maxiLexi->id,
                'status' => 'available',
                'nopol' => $nopol,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Create motorcycle type for Soul GT
        JenisMotor::create([
            'id_stok' => $soulGT->id,
            'status' => 'available',
            'nopol' => 'N 5993 ADJ',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Create motorcycle type for PCX
        JenisMotor::create([
            'id_stok' => $pcx->id,
            'status' => 'available',
            'nopol' => 'N 2603 ACA',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}