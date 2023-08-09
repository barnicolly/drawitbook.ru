<?php

declare(strict_types=1);

namespace App\Ship\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

final class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require app_path('Ship/Broadcasts/Routes.php');
    }
}
