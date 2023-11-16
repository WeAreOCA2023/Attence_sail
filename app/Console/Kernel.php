<?php

namespace App\Console;

use App\Http\Controllers\HomeController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->everyFiveSeconds();
        $schedule->call(fn () => HomeController::testFunc())->everyFiveSeconds();
        $schedule->call(fn () => HomeController::weeklyProcess())->weeklyOn(4, '15:57');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $middleware = [
        \App\Http\Middleware\AdminMiddleware::class,
    ];
}
