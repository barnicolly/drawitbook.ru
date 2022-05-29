<?php

namespace App\Ship\Providers;

use Illuminate\Support\ServiceProvider;

class ShipServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(AppServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        //        $this->app->register(BroadcastServiceProvider::class);
        $this->app->register(ComposerServiceProvider::class);
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
    }

    private function registerConfig()
    {
        $this->publishes(
            [
                app_path('Ship/Configs/modules.php') => config_path('modules.php'),
            ],
            'config'
        );
        $this->mergeConfigFrom(
            app_path('Ship/Configs/modules.php'),
            'modules'
        );
    }
}
