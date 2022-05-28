<?php

namespace App\Services\Commands;

use App\Containers\Picture\Models\PictureTagsModel;
use App\Enums\Lang;
use App\Services\Route\RouteService;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class CreateSitemapService
{

    private $routeService;

    public function __construct()
    {
        $this->routeService = (new RouteService());
    }

    public function create()
    {
        $sitemap = Sitemap::create();
        $locales = config('translator.available_locales');
        foreach ($locales as $locale) {
            $url = Url::create($this->routeService->getRouteHome([], true, $locale));
            foreach ($locales as $alternateLocale) {
                $url->addAlternate($this->routeService->getRouteHome([], true, $alternateLocale), $alternateLocale);
            }
            $sitemap->add($url);
        }
        foreach ($locales as $locale) {
            $url = Url::create($this->routeService->getRouteArtsCell([], true, $locale));
            foreach ($locales as $alternateLocale) {
                $url->addAlternate($this->routeService->getRouteArtsCell([], true, $alternateLocale), $alternateLocale);
            }
            $sitemap->add($url);
        }
        $tags = PictureTagsModel::getTagsForSitemap();
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $locales = [];
                if ($tag['slug_en']) {
                    $locales[] = Lang::EN;
                }
                if ($tag['seo']) {
                    $locales[] = Lang::RU;
                }
                foreach ($locales as $locale) {
                    $slug = $locale === Lang::RU
                        ? $tag['seo']
                        : $tag['slug_en'];
                    $url = Url::create($this->routeService->getRouteArtsCellTagged($slug, true, $locale))
                        ->setPriority(0.9);
                    if (count($locales) > 1) {
                        foreach ($locales as $alternateLocale) {
                            $slug = $alternateLocale === Lang::RU
                                ? $tag['seo']
                                : $tag['slug_en'];
                            $url->addAlternate($this->routeService->getRouteArtsCellTagged($slug, true, $alternateLocale), $alternateLocale);
                        }
                    }
                    $sitemap->add($url);
                }

            }
        }
        $sitemap->writeToFile(public_path('sitemaps/sitemap.xml'));
        SitemapIndex::create()
            ->add(asset('sitemaps/sitemap.xml'))
            ->writeToFile(public_path('sitemap-index.xml'));
    }
}
