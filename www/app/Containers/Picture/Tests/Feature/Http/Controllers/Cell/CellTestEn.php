<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Cell;

use App\Containers\Translation\Enums\LangEnum;
use App\Services\Route\RouteService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CellTestEn extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::EN);
    }

    public function providerTestCellCategoryResponseCode200(): array
    {
        return [
            [
               'superheroes',
            ],
            [
                'wolverine',
            ],
            [
                'pussycat',
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
                'Superheroes',
                [],
            ],
            [
                'Superheroes ',
                [],
            ],
            [
                'Superheroes ?',
                [],
            ],
            [
                'superheroes ?',
                [],
            ],
            [
                'superheroes',
                ['test' => 1],
            ],
            [
                'Superheroes',
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
        $expectedTag = 'superheroes';
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
        $expectedTag = 'superheroes';
        $url = '/pixel-arts/superheroes';
        $assetRedirect = (new RouteService())->getRouteArtsCellTagged($expectedTag);
        $response = $this->withHeader('accept-language', 'en-us,en;q=0.5')
            ->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasRedirects(): void
    {
        $expectedTag = 'superheroes';
        $url = (new RouteService())->getRouteArtsCellTagged('supergeroi');
        $assetRedirect = (new RouteService())->getRouteArtsCellTagged($expectedTag);
        $response = $this->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testHasNotRedirect()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('imena'));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testHasAlternate()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('flowers'));
        $response->assertSee('<link rel="alternate" href="', false);
    }

    public function testHasTranslatedTitle()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('flowers'));
        $response->assertSee('<title>Pixel arts «Flowers» ☆ 84 arts</title>', false);
    }

    public function testHasTranslatedDescription()
    {
        $response = $this->get((new RouteService())->getRouteArtsCellTagged('flowers'));
        $response->assertSee('<meta name="description" content="Pixel arts ✎ Flowers ➣ 84 arts ➣ Black/white and colored schemes of pixel arts from light and simple to complex.">', false);
    }
}
