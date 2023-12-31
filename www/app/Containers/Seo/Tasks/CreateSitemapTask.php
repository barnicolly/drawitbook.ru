<?php

declare(strict_types=1);

namespace App\Containers\Seo\Tasks;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Services\Route\RouteService;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

final class CreateSitemapTask extends Task
{
    public function __construct(private readonly RouteService $routeService)
    {
    }

    public function run(): void
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
        $tags = $this->getTagsForSitemap();
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $locales = [];
                if ($tag['slug_en']) {
                    $locales[] = LangEnum::EN;
                }
                if ($tag['seo']) {
                    $locales[] = LangEnum::RU;
                }
                foreach ($locales as $locale) {
                    $slug = $locale === LangEnum::RU
                        ? $tag['seo']
                        : $tag['slug_en'];
                    $url = Url::create($this->routeService->getRouteArtsCellTagged($slug, true, $locale))
                        ->setPriority(0.9);
                    if (count($locales) > 1) {
                        foreach ($locales as $alternateLocale) {
                            $slug = $alternateLocale === LangEnum::RU
                                ? $tag['seo']
                                : $tag['slug_en'];
                            $url->addAlternate(
                                $this->routeService->getRouteArtsCellTagged($slug, true, $alternateLocale),
                                $alternateLocale,
                            );
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

    private function getTagsForSitemap(): array
    {
        //        todo-misha восстановить;
        return [];
    }
}
