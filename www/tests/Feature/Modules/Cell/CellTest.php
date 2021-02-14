<?php

namespace Tests\Feature\Modules\Cell;

use App\Services\Route\RouteService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CellTest extends TestCase
{

    /**
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testCellIndexResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteArtsCell());
        $response->assertStatus(200);
    }

    public function providerTestCellCategoryResponseCode200(): array
    {
        return [
            [
               'supergeroi',
                'ru',
            ],
            [
                'supermen',
                'ru',
            ],
            [
                'koshka',
                'ru',
            ],
        ];
    }

    /**
     * @dataProvider providerTestCellCategoryResponseCode200
     *
     * @param string $tag
     * @param string $locale
     */
    public function testCellCategoryResponseCode200(string $tag, string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteArtsCellTagged($tag));
        $response->assertStatus(200);
    }

    public function providerTestCellCategoryHasRedirects(): array
    {
        return [
            [
                'Supergeroi',
                [],
            ],
            [
                'Supergeroi ',
                [],
            ],
            [
                'Supergeroi ?',
                [],
            ],
            [
                'supergeroi ?',
                [],
            ],
            [
                'supergeroi',
                ['test' => 1],
            ],
            [
                'Supergeroi',
                ['test' => 1],
            ],
        ];
    }

    /**
     * @dataProvider providerTestCellCategoryHasRedirects
     *
     * @param string $tag
     * @param array $params
     */
    public function testHasCellCategoryRedirects(string $tag, array $params): void
    {
        $this->app->setLocale('ru');
        $expectedTag = 'supergeroi';
        $url = (new RouteService())->getRouteArtsCellTagged($tag);
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $assetRedirect = (new RouteService())->getRouteArtsCellTagged($expectedTag);
        $response = $this->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }
}
