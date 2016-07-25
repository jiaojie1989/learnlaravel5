<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\Inspire',
            // Commands\Inspire::class,
        Commands\HqCnUpdate::class,
        Commands\HqUsUpdate::class,
        Commands\HqHkUpdate::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->exec('notify-send "' . date("Y-m-d H:i:s") . ' start"');
        $schedule->command('inspire')
                ->sendOutputTo("/tmp/abc", true);
        $schedule->command('inspire');
        $schedule->command('inspire');
        $schedule->exec('notify-send "' . date("Y-m-d H:i:s") . ' end"');
    }

}
