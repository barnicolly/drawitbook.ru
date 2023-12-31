<?php

declare(strict_types=1);

namespace App\Ship\Kernels;

use App\Containers\SocialMediaPosting\Console\VkPostingCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as LaravelConsoleKernel;

final class ConsoleKernel extends LaravelConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * Пример linux: crontab -e; * * * * * php /var/www/deployer/data/repo/drawitbook.com/current/www/artisan schedule:run >/dev/null 2>&1
     */
    protected function schedule(Schedule $schedule): void
    {
        //        $schedule->command('sitemap:generate')
        //            ->weeklyOn(1, '8:00');

        $schedule->command(VkPostingCommand::class)
            ->hourlyAt(2)
            ->unlessBetween('1:00', '5:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require app_path('Ship/Commands/Routes.php');
    }
}
