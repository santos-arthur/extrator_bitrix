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
        $schedule->command('app:import-groups')->everyFifteenMinutes();
        $schedule->command('app:import-users')->everyFifteenMinutes();
        $schedule->command('app:import-stages')->everyFifteenMinutes();
        $schedule->command('app:import-tasks')->everyFifteenMinutes();
        $schedule->command('app:import-leadtimes')->everyFifteenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
