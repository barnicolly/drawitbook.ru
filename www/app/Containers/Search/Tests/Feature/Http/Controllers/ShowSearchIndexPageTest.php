<?php

namespace App\Containers\Search\Tests\Feature\Http\Controllers;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Search\Http\Controllers\SearchController;
use App\Containers\Search\Services\SearchService;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see SearchController::index()
 */
class ShowSearchIndexPageTest extends TestCase
{

    use CreateTagTrait, CreatePictureWithRelationsTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testSearchOk(string $locale): void
    {
        $this->app->setLocale($locale);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteSearch();
        $page = 1;
        $params = ['page' => $page, 'query' => $tag->name];
        $url .= '?' . http_build_query($params);
        $pictureIds = [];
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
            $pictureIds[] = $picture->id;
        }
        $mock = $this->createMock(SearchService::class);
        $mock->method('searchByQuery')
            ->willReturn($pictureIds);
        $mock->method('setLimit')
            ->willReturnSelf();
        $this->app->bind(SearchService::class, function () use ($mock) {
            return $mock;
        });

        $response = $this->get($url);

        $response->assertOk();
        $response->assertSee('<meta name="robots" content="noindex, follow">', false);
        $response->assertSee('<link rel="alternate" href="', false);
    }

    public function testSearchEmptyQuery(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteSearch();
        $page = 1;
        $params = ['page' => $page, 'query' => null];
        $url .= '?' . http_build_query($params);
        $pictureIds = [];
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
            $pictureIds[] = $picture->id;
        }
        $mock = $this->createMock(SearchService::class);
        $mock->method('searchByQuery')
            ->willReturn($pictureIds);
        $mock->method('setLimit')
            ->willReturnSelf();
        $this->app->bind(SearchService::class, function () use ($mock) {
            return $mock;
        });

        $response = $this->get($url);

        $response->assertNotFound();
    }
}
