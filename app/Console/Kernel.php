<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendReminderEmails;

class Kernel extends ConsoleKernel
{

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:send-reminders')->daily(); // Atur sesuai kebutuhan
        $schedule->command('bookings:move')->daily(); // Atur sesuai kebutuhan
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
