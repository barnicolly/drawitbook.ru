<?php
namespace App\Ship\Providers;

use App\Ship\Services\Route\RouteService;
use Illuminate\Support\ServiceProvider;

class RouterServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind('Router',function(){
            return new RouteService();
        });
    }
}
