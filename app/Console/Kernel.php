<?php

namespace App\Console;

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
        Commands\SurveyClosed::class,
        Commands\VoteStarted::class,
        Commands\VoteClosed::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // アンケート終了の自動告知
        $schedule->command('SurveyClosed:closed')
                    ->everyMinute()
                    ->between('00:00', '00:05');

        // 試合の投票開始の自動告知
        $schedule->command('VoteStarted:started')
                    ->hourly()
                    ->unlessBetween('1:00', '5:00');

        // 試合の投票終了の自動告知
        $schedule->command('VoteClosed:closed')
                    ->everyMinute()
                    ->between('9:00', '21:00');
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
