<?php

namespace App\Http\Modules\Cron\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Modules\Database\Models\Common\Article\ArticleModel;
use Validator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

class Cron extends Controller
{

    public function stat()
    {
        $test = new TestModel();
        $test->name = 1;
        $test->save();
    }

    public function createSitemap()
    {
        $base = config('app.url');
        $sitemap = Sitemap::create()
            ->add(Url::create($base));

        $articles = ArticleModel::whereIsShow(1)->get();

        foreach ($articles as $article) {
            $sitemap->add(Url::create($base . $article->link)
                ->setPriority(0.9)
            );
        }
        $sitemap->writeToFile(public_path('sitemaps/sitemap.xml'));

        SitemapIndex::create()
            ->add(asset('sitemaps/sitemap.xml'))
            ->writeToFile(public_path('sitemap-index.xml'));
    }
}
