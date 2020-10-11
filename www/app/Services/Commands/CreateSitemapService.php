<?php

namespace App\Services\Commands;

use Illuminate\Support\Facades\DB;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class CreateSitemapService
{

    public function __construct()
    {
    }

    public function create()
    {
        $base = config('app.url');
        $sitemap = Sitemap::create()
            ->add(Url::create($base));

        $taggedRisunkiPoKletochkam = $this->_getTags();
        if ($taggedRisunkiPoKletochkam) {
            foreach ($taggedRisunkiPoKletochkam as $item) {
                $sitemap->add(
                    Url::create(route('arts.cell.tagged', $item->seo))
                        ->setPriority(0.9)
                );
            }
        }

        $sitemap->writeToFile(public_path('sitemaps/sitemap.xml'));

        SitemapIndex::create()
            ->add(asset('sitemaps/sitemap.xml'))
            ->writeToFile(public_path('sitemap-index.xml'));
    }

    private function _getTags()
    {
        $results = DB::select(
            DB::raw(
                'select spr_tags.*
from spr_tags
join picture_tags on picture_tags.tag_id = spr_tags.id
join picture on picture.id = picture_tags.picture_id
where picture.is_del = 0
group by spr_tags.id'
            )
        );

        if ($results) {
            return $results;
        }
        return [];
    }
}
