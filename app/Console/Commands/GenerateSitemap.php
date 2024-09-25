<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ganti URL dengan URL website Anda
        SitemapGenerator::create('https://rosantibikemotorent.com')
            ->getSitemap()
            ->writeToDisk('public', 'sitemap.xml');

        $this->info('Sitemap berhasil dibuat di: ' . public_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}
