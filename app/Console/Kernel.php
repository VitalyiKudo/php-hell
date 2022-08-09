<?php

namespace App\Console;

use App\Jobs\SendEmailOperatorDailyJobs;
use App\Jobs\DeactivateEmptyLegsOld;
use Carbon;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('sitemap:generate')->daily();
        $schedule->command('command:SendEmailOperatorDaily')->dailyAt('07:00')->timezone('America/New_York')->weekdays();
        #$schedule->command('command:SendEmailOperatorDaily')->everyMinute()->appendOutputTo(storage_path('logs/SendEmailOperatorDaily.log'));
        $schedule->command('command:DeactivateEmptyLegsOld')->daily();

        if ($this->app->environment() === 'local') {
            $schedule->command('telescope:prune')->daily()->timezone('America/New_York');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
