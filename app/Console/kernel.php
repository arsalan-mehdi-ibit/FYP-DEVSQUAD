<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        
        $schedule->command('app:emailremindersforsubmittedtimesheets')->everyFiveMinutes();

        // $schedule->call(function () {
        //     \Log::info('📆 Laravel scheduler is running correctly.');
        // })->everyMinute();
       
        $schedule->command('app:emailremindersforpendingtimesheets')->everyFiveMinutes();
        $schedule->command('app:emailremindersforrejectedtimesheets')->everyFiveMinutes();

    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
