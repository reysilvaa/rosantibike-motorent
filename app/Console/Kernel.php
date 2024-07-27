<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule your commands here if needed
        // Example: $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        // Load custom commands from the 'Commands' directory
        $this->load(__DIR__.'/Commands');

        // Register any additional commands defined in routes/console.php
        require base_path('routes/console.php');
    }
}
