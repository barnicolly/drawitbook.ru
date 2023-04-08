<?php

namespace App\Containers\Tag\Actions;

use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\Picture\Tasks\PictureTag\GetPictureTagsWithCountArtTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Facades\Cache;

class GetListPopularTagsWithCountArtsAction extends Action
{

    private RouteService $routeService;
    private GetPictureTagsWithCountArtTask $getPictureTagsWithCountArtTask;

    public function __construct(RouteService $routeService, GetPictureTagsWithCountArtTask $getPictureTagsWithCountArtTask)
    {
        $this->routeService = $routeService;
        $this->getPictureTagsWithCountArtTask = $getPictureTagsWithCountArtTask;
    }

    /**
     * @return array
     * @throws RepositoryException
     */
    public function run(): array
    {
        $locale = app()->getLocale();
        $responseList = [];
        $tagList = $this->getCachedMostPopularTags($locale);
        foreach ($tagList as $tag) {
            $responseList[] = [
                'link' => $this->routeService->getRouteArtsCellTagged($tag['seo']),
                'text' => $tag['name'],
                'weight' => $tag['count'],
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
                function () use ($limit, $locale) {
                    return $this->getPictureTagsWithCountArtTask->run($limit, $locale);
                }
            );
        }
        return $results;
    }

}


