<?php

declare(strict_types=1);

namespace App\Ship\Providers;

use Illuminate\Support\ServiceProvider;

final class HelperServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once app_path('Ship/Helpers/Functions.php');
        require_once app_path('Ship/Helpers/Path_helper.php');
    }
}
