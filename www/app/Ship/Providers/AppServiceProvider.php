<?php

namespace App\Ship\Providers;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Models\SprTagsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(!$this->app->isProduction());

        Relation::enforceMorphMap(
            [
                'tag' => SprTagsModel::class,
                'art' => PictureModel::class,
            ]
        );

        if (config('app.forceHttps') === true) {
            URL::forceScheme('https');
        }
    }
}
