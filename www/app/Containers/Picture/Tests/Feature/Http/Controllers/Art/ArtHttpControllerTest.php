<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Services\Route\RouteService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\ArtHttpController::index()
 */
class ArtHttpControllerTest extends TestCase
{

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testPageHasRobotsNoindex(string $locale): void
    {
        $this->app->setLocale($locale);
        $id = 144;
        $response = $this->get((new RouteService())->getRouteArt($id));
        $response->assertSee('<meta name="robots" content="noindex">', false);
    }

    public function providerTestHasRedirects(): array
    {
        return [
            //TODO-misha добиться исполнения теста;
            /*  [
                  '?',
                  [],
              ],*/
            [
                ' ?',
                [],
            ],
            [
                '',
                ['test' => 1],
            ],
            [
                ' ?',
                [],
            ],
            [
                '',
                ['test' => 1],
            ]
        ];
    }

    /**
     * @dataProvider providerTestHasRedirects
     *
     * @param string $postfix
     * @param array $params
     */
    public function testHasRedirects(string $postfix, array $params): void
    {
        $id = 144;
        $locales = LangEnum::asArray();
        foreach ($locales as $locale) {
            $this->app->setLocale($locale);
            $url = (new RouteService())->getRouteArt($id) . $postfix;
            if (!empty($params)) {
                $url .= '?' . http_build_query($params);
            }
            $assetRedirect = (new RouteService())->getRouteArt($id);
            $response = $this->get($url);
            $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
            $response->assertRedirect($assetRedirect);
        }
    }

    public function providerTestArtPageResponseCode200(): array
    {
        return [
            [
                144,
            ],
            [
                7,
            ],
        ];
    }

    /**
     * @dataProvider providerTestArtPageResponseCode200
     *
     * @param int $id
     */
    public function testArtPageResponseCode200(int $id): void
    {
        $locales = LangEnum::asArray();
        foreach ($locales as $locale) {
            $this->app->setLocale($locale);
            $response = $this->get((new RouteService())->getRouteArt($id));
            $response->assertStatus(200);
        }
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testArtResponseCode404(string $locale) : void
    {
        $this->app->setLocale($locale);
        $response = $this->followingRedirects()
            ->get('/art');
        $response->assertStatus(404);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testHasAlternate(string $locale): void
    {
        $this->app->setLocale($locale);
        $id = 144;
        $response = $this->get((new RouteService())->getRouteArt($id));
        $response->assertSee('<link rel="alternate" href="', false);
    }
}
