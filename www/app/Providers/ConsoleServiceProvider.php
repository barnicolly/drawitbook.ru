<?php

namespace App\Providers;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Finder\Finder;

class ConsoleServiceProvider extends ServiceProvider
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
        //
        $modules = Module::all();
        foreach ($modules as $module) {
            $moduleName = $module->getName();
            $namespace = "App\Containers\\" . $moduleName;
            $this->loadCommands($moduleName, $namespace);
        }
    }

    protected function loadCommands(string $moduleName, string $namespace)
    {
        $paths = module_path($moduleName, 'Console');
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });
        if (empty($paths)) {
            return;
        }
        foreach ((new Finder)->in($paths)->files() as $command) {
            $relativePath = $command->getRelativePath();
            $filename = ($relativePath ? $relativePath . '\\': '') . $command->getFilename();
            $class = $namespace.'\\Console\\'.$filename;
            $command = str_replace(
                ['/', '.php'],
                ['\\', ''],
                $class
            );
            if (is_subclass_of($command, Command::class)) {
                Artisan::starting(function ($artisan) use ($command) {
                    $artisan->resolve($command);
                });
            }
        }
    }
}
