<?php

namespace App\Ship\Providers;

use App\Ship\ViewComposers\Error404Composer;
use App\Ship\ViewComposers\Error500Composer;
use App\Ship\ViewComposers\FooterComposer;
use App\Ship\ViewComposers\HeaderComposer;
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

        view()->composer('layouts.public.header.index', HeaderComposer::class);

        view()->composer('layouts.public.footer.index', FooterComposer::class);
    }
}
