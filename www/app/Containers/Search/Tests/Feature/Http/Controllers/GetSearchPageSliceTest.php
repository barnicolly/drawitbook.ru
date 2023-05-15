<?php

namespace App\Containers\Search\Tests\Feature\Http\Controllers;

use App\Containers\Search\Tasks\SearchInElasticSearchTask;
use PHPUnit\Framework\MockObject\MockObject;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Search\Http\Controllers\SearchController;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Parents\Tests\TestCase;
use Illuminate\Support\Arr;

/**
 * @see SearchController::slice()
 */
class GetSearchPageSliceTest extends TestCase
{
    use CreateTagTrait;
    use CreatePictureWithRelationsTrait;

    public function testSearchSliceOk(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteSearch();
        $page = 1;
        $params = ['page' => $page, 'query' => $tag->name];
        $url .= '/slice?' . http_build_query($params);
        $pictureIds = [];
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
            $pictureIds[] = $picture->id;
        }
        $mock = $this->createMock(SearchInElasticSearchTask::class);
        $mock->method('run')
            ->willReturn($pictureIds);
        $this->app->bind(SearchInElasticSearchTask::class, static fn (): MockObject&SearchInElasticSearchTask => $mock);

        $response = $this->ajaxGet($url);

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'html',
                        'countLeftArtsText',
                    ],
                    'meta' => [
                        'pagination' => [
                            'hasMore',
                            'page',
                            'total',
                            'left',
                        ],
                    ],
                ],
            );
        $result = $response->decodeResponseJson();
        self::assertSame($page, Arr::get($result, 'meta.pagination.page'));
        self::assertTrue(Arr::get($result, 'meta.pagination.hasMore'));
    }

    public function testSearchSliceNotFound(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteSearch();
        $page = 1;
        $params = ['page' => $page, 'query' => $tag->name];
        $url .= '/slice?' . http_build_query($params);
        [$picture] = $this->createPictureWithFile();
        $this->createPictureTag($picture, $tag);

        $response = $this->ajaxGet($url);

        $response->assertNotFound();
    }

    public function testSearchSliceEmptyQuery(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteSearch();
        $page = 1;
        $params = ['page' => $page, 'query' => ''];
        $url .= '/slice?' . http_build_query($params);
        [$picture] = $this->createPictureWithFile();
        $this->createPictureTag($picture, $tag);

        $response = $this->ajaxGet($url);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('query');
    }
}
