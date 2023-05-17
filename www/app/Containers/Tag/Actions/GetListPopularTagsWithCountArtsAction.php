<?php

namespace App\Containers\Tag\Actions;

use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsWithCountArtTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Facades\Cache;

class GetListPopularTagsWithCountArtsAction extends Action
{
    public function __construct(
        private readonly RouteService $routeService,
        private readonly GetPictureTagsWithCountArtTask $getPictureTagsWithCountArtTask,
    ) {
    }

    public function run(): array
    {
        $locale = app()->getLocale();
        $responseList = [];
        $tagList = $this->getCachedMostPopularTags($locale);
        foreach ($tagList as $tag) {
            $responseList[] = [
                'link' => $this->routeService->getRouteArtsCellTagged($tag['seo']),
                'text' => $tag['name'],
                'weight' => $tag['pictures_count'],
            ];
        }
        return $responseList;
    }

    private function getCachedMostPopularTags(string $locale): array
    {
        $limit = 40;
        $cacheName = $locale . '.spr.tag_cloud';
        $results = Cache::get($cacheName);
        if (!$results) {
            $results = Cache::remember(
                $cacheName,
                config('cache.expiration'),
                fn (): array => $this->getPictureTagsWithCountArtTask->run($limit, $locale),
            );
        }
        return $results;
    }
}
