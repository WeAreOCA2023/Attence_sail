<?php

namespace App\Console;

use App\Http\Controllers\HomeController;
use App\Models\AllWorkHours;
use App\Models\WeeklyWorkHours;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
//        $schedule->command('inspire')->everyFiveSeconds();
        $schedule->call(fn () => HomeController::weeklyProcess())->weekly();
        $schedule->call(fn () => HomeController::monthlyProcess())->monthly();
        $schedule->call(fn () => HomeController::yearlyProcess())->yearly();
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
