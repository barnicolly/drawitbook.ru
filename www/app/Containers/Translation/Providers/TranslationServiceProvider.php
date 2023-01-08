<?php

namespace App\Containers\Translation\Providers;

use Illuminate\Support\ServiceProvider;
use Mariuzzo\LaravelJsLocalization\LaravelJsLocalizationServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Translation';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'translation';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Data/Migrations'));
        $this->app->register(LaravelJsLocalizationServiceProvider::class);
        $this->app->register(\Waavi\Translation\TranslationServiceProvider::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Configs/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Configs/config.php'), $this->moduleNameLower
        );
        $this->publishes([
                             module_path($this->moduleName, 'Configs/localization-js.php') => config_path('localization-js.php'),
                         ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Configs/localization-js.php'),
            'localization-js'
        );
        $this->publishes([
                             module_path($this->moduleName, 'Configs/translator.php') => config_path('translator.php'),
                         ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Configs/translator.php'),
            'translator'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Http/Views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
