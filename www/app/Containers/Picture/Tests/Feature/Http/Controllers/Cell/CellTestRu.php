<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Translation\Enum\Lang;
use App\Services\Route\RouteService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CellTestRu extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(Lang::RU);
    }

    public function providerTestCellCategoryResponseCode200(): array
    {
        return [
            [
               'supergeroi',
            ],
            [
                'supermen',
            ],
            [
                'koshka',
            ],
        ];
    }

    /**
     * @dataProvider providerTestCellCategoryResponseCode200
     *
     * @param string $tag
     */
    public function testCellCategoryResponseCode200(string $tag): void
    {
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

    public function testHasRedirectsIfUndefinedLang(): void
    {
        $expectedTag = 'supergeroi';
        $url = '/risunki-po-kletochkam/supergeroi';
        $assetRedirect = (new RouteService())->getRouteArtsCellTagged($expectedTag);
        $response = $this->withHeader('accept-language', 'ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7')
            ->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasRedirects(): void
    {
        $expectedTag = 'supergeroi';
        $url = (new RouteService())->getRouteArtsCellTagged('superheroes');
        $assetRedirect = (new RouteService())->getRouteArtsCellTagged($expectedTag);
        $response = $this->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasAlternate()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('cvety'));
        $response->assertSee('<link rel="alternate" href="', false);
    }

    public function testHasNotAlternate()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('imena'));
        $response->assertDontSee('<link rel="alternate" href="', false);
    }

    public function testHasTranslatedTitle()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('cvety'));
        $response->assertSee('<title>Рисунки по клеточкам «Цветы» ☆ 84 рисунка</title>', false);
    }

    public function testHasTranslatedDescription()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('cvety'));
        $response->assertSee('<meta name="description" content="Рисунки по клеточкам ✎ Цветы ➣ 84 рисунка ➣ Схемы чёрно-белых и цветных рисунков от легких и простых до сложных.">', false);
    }
}
