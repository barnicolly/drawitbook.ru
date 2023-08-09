<?php

declare(strict_types=1);

namespace App\Ship\Providers;

use App\Ship\ViewComposers\Error404Composer;
use App\Ship\ViewComposers\Error500Composer;
use App\Ship\ViewComposers\FooterComposer;
use App\Ship\ViewComposers\HeaderComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        view()->composer('errors::404', Error404Composer::class);

        view()->composer('errors::500', Error500Composer::class);

        view()->composer('layouts.public.header.index', HeaderComposer::class);

        view()->composer('layouts.public.footer.index', FooterComposer::class);
    }
}
