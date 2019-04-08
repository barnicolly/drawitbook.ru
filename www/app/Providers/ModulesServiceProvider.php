<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{

    public function __construct(\Illuminate\Contracts\Foundation\Application $app)
    {
        parent::__construct($app);
        $this->defer = true;
    }

    public function boot()
    {
        $modulesCorePath = 'app/Http/Modules/';
        $modules = listDir(base_path($modulesCorePath));
        foreach ($modules as $module) {
            if (file_exists(base_path($modulesCorePath . $module . '/Routes/web.php'))) {
                $this->loadRoutesFrom(base_path($modulesCorePath . $module . '/Routes/web.php'));
            }
            if (is_dir(base_path($modulesCorePath . $module . '/Lang'))) {
                $this->loadTranslationsFrom(base_path($modulesCorePath . $module . '/Lang'), $module);
            }
            if (is_dir(base_path($modulesCorePath . $module . '/Views'))) {
                $this->loadViewsFrom(base_path($modulesCorePath . $module . '/Views'), $module);
            }
        }
    }

    public function register()
    {

    }

}