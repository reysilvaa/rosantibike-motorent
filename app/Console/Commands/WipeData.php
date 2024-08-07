<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Galeri;
use Illuminate\Console\Command;
use App\Models\JenisMotor;
use App\Models\Rating;
use App\Models\Stok;
use App\Models\Transaksi;

class WipeData extends Command
{
    protected $signature = 'data:wipe {--model=* : The models to wipe data from}';
    protected $description = 'Wipe data from specified models';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $models = $this->option('model');

        if (empty($models)) {
            $this->error('No models specified. Use --model option to specify models.');
            return 1;
        }

        foreach ($models as $model) {
            switch ($model) {
                case 'jenis_motor':
                    JenisMotor::query()->delete(); // Menggunakan delete() alih-alih truncate()
                    $this->info('Wiped data from jenis_motor.');
                    break;

                case 'stok':
                    Stok::query()->delete(); // Menggunakan delete() alih-alih truncate()
                    $this->info('Wiped data from stok.');
                    break;

                case 'transaksi':
                    Transaksi::query()->delete(); // Menggunakan delete() alih-alih truncate()
                    $this->info('Wiped data from transaksi.');
                    break;

                case 'booking':
                    Booking::query()->delete(); // Menggunakan delete() alih-alih truncate()
                    $this->info('Wiped data from booking.');
                    break;

                case 'galeri':
                    Galeri::query()->delete(); // Menggunakan delete() alih-alih truncate()
                    $this->info('Wiped data from galeri.');
                    break;

                case 'rating':
                    Rating::query()->delete(); // Menggunakan delete() alih-alih truncate()
                    $this->info('Wiped data from rating.');
                    break;

                default:
                    $this->warn("Unknown model: $model");
                    break;
            }
        }

        return 0;
    }
}
