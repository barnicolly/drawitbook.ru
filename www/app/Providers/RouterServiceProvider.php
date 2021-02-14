<?php
namespace App\Providers;

use App\Services\Route\RouteService;
use Illuminate\Support\ServiceProvider;

class RouterServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('Router',function(){
            return new RouteService();
        });
    }
}
