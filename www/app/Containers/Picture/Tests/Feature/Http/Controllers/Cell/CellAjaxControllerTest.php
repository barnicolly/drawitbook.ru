<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Picture\Http\Controllers\Cell\CellAjaxController;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Services\Route\RouteService;
use Illuminate\Support\Arr;
use Tests\TestCase;

/**
 * @see CellAjaxController::slice()
 */
class CellAjaxControllerTest extends TestCase
{

    private string $url;

    public function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::RU);
        $tag = 'medved';
        $url = (new RouteService())->getRouteArtsCellTagged($tag);
        $this->url = $url . '/slice';
    }

    public function testGetCellTaggedArtsSliceOk(): void
    {
        $page = 2;
        $params = ['page' => $page];
        $this->url .= '?' . http_build_query($params);

        $response = $this->ajaxGet($this->url);

        $response->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'html',
                        'countLeftArtsText',
                    ],
                    'meta' => [
                        'pagination' => [
                            'isLastPage',
                            'page',
                        ],
                    ],
                ]
            );
        $result = $response->decodeResponseJson();
        self::assertSame($page, Arr::get($result, 'meta.pagination.page'));
        self::assertFalse(Arr::get($result, 'meta.pagination.isLastPage'));
    }

    public function testGetCellTaggedArtsSliceWithoutRequiredParam(): void
    {
        $response = $this->ajaxGet($this->url);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('page');
    }

}
