<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JenisMotor;
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
                    JenisMotor::truncate();
                    $this->info('Wiped data from jenis_motor.');
                    break;

                case 'transaksi':
                    Transaksi::truncate();
                    $this->info('Wiped data from transaksi.');
                    break;

                default:
                    $this->warn("Unknown model: $model");
                    break;
            }
        }

        return 0;
    }
}
