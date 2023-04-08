<?php

namespace App\Ship\Providers;

use Illuminate\Support\ServiceProvider;

class ShipServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->registerConfig();
    }

    public function boot(): void
    {
        $this->app->register(AppServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        //        $this->app->register(BroadcastServiceProvider::class);
        $this->app->register(ComposerServiceProvider::class);
        $this->app->register(RouterServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);
        /**
         * @see \Nwidart\Modules\Commands\MigrationMakeCommand::getTemplateContents()
         * @see \Nwidart\Modules\Support\Migrations\NameParser::getPattern()
         */
        $this->loadMigrationsFrom(app_path('Ship/Migrations'));
    }

    private function registerConfig(): void
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
