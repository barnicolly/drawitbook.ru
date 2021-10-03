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
        'App\Console\Commands\CreateSitemap',
        'App\Console\Commands\VkPosting',
        'App\Console\Commands\SingleUse\MigratePictureExtensions',
    ];

    /**
     * Define the application's command schedule.
     *
     * Пример linux: crontab -e; * * * * * php /var/www/deployer/data/repo/drawitbook.com/current/www/artisan schedule:run >/dev/null 2>&1
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//        $schedule->command('sitemap:generate')
//            ->weeklyOn(1, '8:00');

        $schedule->command('vk:posting')
            ->hourlyAt(2)
            ->unlessBetween('1:00', '5:00');
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
