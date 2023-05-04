<?php

namespace App\Ship\Providers;

use App\Containers\Picture\Models\PictureModel;
use App\Containers\Tag\Models\TagsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(!$this->app->isProduction());

        Relation::enforceMorphMap(
            [
                'tag' => TagsModel::class,
                'art' => PictureModel::class,
            ]
        );

        if (config('app.forceHttps') === true) {
            URL::forceScheme('https');
        }
    }
}
