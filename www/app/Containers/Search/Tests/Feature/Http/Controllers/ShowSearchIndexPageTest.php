<?php

declare(strict_types=1);

namespace App\Containers\Search\Tests\Feature\Http\Controllers;

use App\Containers\Search\Tasks\SearchInElasticSearchTask;
use Mockery\MockInterface;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Search\Http\Controllers\SearchController;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see SearchController::index()
 */
final class ShowSearchIndexPageTest extends TestCase
{
    use CreateTagTrait;
    use CreatePictureWithRelationsTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
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
        $this->mock(SearchInElasticSearchTask::class, static function (MockInterface $mock) use ($pictureIds): void {
            $mock
                ->shouldReceive('run')
                ->andReturn($pictureIds);
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
        $this->mock(SearchInElasticSearchTask::class, static function (MockInterface $mock) use ($pictureIds): void {
            $mock
                ->shouldReceive('run')
                ->andReturn($pictureIds);
        });

        $response = $this->get($url);

        $response->assertNotFound();
    }
}
