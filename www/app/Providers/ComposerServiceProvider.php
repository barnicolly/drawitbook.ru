<?php

namespace App\Providers;

use App\Http\ViewComposers\Error500Composer;
use App\Http\ViewComposers\Error404Composer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('errors::404', Error404Composer::class);

        view()->composer('errors::500', Error500Composer::class);
    }
}
