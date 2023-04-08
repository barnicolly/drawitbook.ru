<?php

namespace App\Containers\Seo\Providers;

use Config;
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

    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Data/Migrations'));
    }

    public function register(): void
    {
    }

    protected function registerConfig(): void
    {
        $this->publishes([
                             module_path($this->moduleName, 'Configs/config.php') => config_path(
                                 $this->moduleNameLower . '.php'
                             ),
                         ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Configs/config.php'),
            $this->moduleNameLower
        );

        $this->publishes([
                             module_path($this->moduleName, 'Configs/breadcrumbs.php') => config_path(
                                 'breadcrumbs.php'
                             ),
                         ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Configs/breadcrumbs.php'),
            'breadcrumbs'
        );

        $this->publishes([
                             module_path($this->moduleName, 'Configs/seotools.php') => config_path('seotools.php'),
                         ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Configs/seotools.php'),
            'seotools'
        );
    }

    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Http/Views');

        $this->publishes([
                             $sourcePath => $viewPath,
                         ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
