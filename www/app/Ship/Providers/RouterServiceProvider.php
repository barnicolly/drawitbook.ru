<?php

declare(strict_types=1);

namespace App\Ship\Providers;

use App\Ship\Services\Route\RouteService;
use Illuminate\Support\ServiceProvider;

final class RouterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('Router', static fn (): RouteService => new RouteService());
    }
}
