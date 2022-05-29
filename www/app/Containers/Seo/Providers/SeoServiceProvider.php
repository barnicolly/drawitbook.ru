<?php

namespace App\Containers\Seo\Providers;

use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Seo';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'seo';

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
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
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
                             module_path($this->moduleName, 'Config/config.php') => config_path(
                                 $this->moduleNameLower . '.php'
                             ),
                         ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'),
            $this->moduleNameLower
        );

        $this->publishes([
                             module_path($this->moduleName, 'Config/breadcrumbs.php') => config_path(
                                 'breadcrumbs.php'
                             ),
                         ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/breadcrumbs.php'),
            'breadcrumbs'
        );

        $this->publishes([
                             module_path($this->moduleName, 'Config/seotools.php') => config_path('seotools.php'),
                         ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/seotools.php'),
            'seotools'
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
                             $sourcePath => $viewPath,
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