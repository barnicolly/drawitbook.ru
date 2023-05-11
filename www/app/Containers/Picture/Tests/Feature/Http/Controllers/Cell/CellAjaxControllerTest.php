<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Picture\Http\Controllers\Cell\CellAjaxController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Translation\Enums\LangEnum;
use Illuminate\Support\Arr;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see CellAjaxController::slice()
 */
class CellAjaxControllerTest extends TestCase
{
    use CreateTagTrait;
    use CreatePictureWithRelationsTrait;

    public function testGetCellTaggedArtsSliceOk(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteArtsCellTagged($tag->seo);
        $page = 1;
        $params = ['page' => $page];
        $url .= '/slice?' . http_build_query($params);
        for ($index = 1; $index < 30; $index++) {
            [$picture] = $this->createPictureWithFile();
            $this->createPictureTag($picture, $tag);
        }

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

    public function testGetCellTaggedArtsSliceNotFound(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteArtsCellTagged($tag->seo);
        $page = 2;
        $params = ['page' => $page];
        $url .= '/slice?' . http_build_query($params);
        [$picture] = $this->createPictureWithFile();
        $this->createPictureTag($picture, $tag);

        $response = $this->ajaxGet($url);

        $response->assertNotFound();
    }

    public function testGetCellTaggedArtsSliceWithoutRequiredParam(): void
    {
        $this->app->setLocale(LangEnum::RU);
        $tag = $this->createTag();
        $url = $this->routeService->getRouteArtsCellTagged($tag->seo);
        $url .= '/slice';

        $response = $this->ajaxGet($url);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('page');
    }
}
