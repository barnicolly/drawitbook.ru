<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $modules = listDir(base_path('app/Modules/'));

        foreach ($modules as $module) {

            if (file_exists(base_path('app/Modules/' . $module . '/Routes/web.php'))) {
                $this->loadRoutesFrom(base_path('app/Modules/' . $module . '/Routes/web.php'));
            }

            if (is_dir(base_path('app/Modules/' . $module . '/Views'))) {
                $this->loadTranslationsFrom(base_path('app/Modules/' . $module . '/Lang'), $module);
            }

            if (is_dir(base_path('app/Modules/' . $module . '/Views'))) {
                $this->loadViewsFrom(base_path('app/Modules/' . $module . '/Views'), $module);
            }
        }
    }

    public function register()
    {

    }

}