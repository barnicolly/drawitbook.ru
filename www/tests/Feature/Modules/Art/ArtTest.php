<?php

namespace Tests\Feature\Modules\Art;

use App\Services\Route\RouteService;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ArtTest extends TestCase
{

    public function providerTestArtPageResponseCode200(): array
    {
        return [
            [
                144,
                'ru',
            ],
            [
                7,
                'ru',
            ],
            [
                144,
                'en',
            ],
            [
                7,
                'en',
            ],
        ];
    }

    /**
     * @dataProvider providerTestArtPageResponseCode200
     *
     * @param int $id
     * @param string $locale
     */
    public function testArtPageResponseCode200(int $id, string $locale): void
    {
        $this->app->setLocale($locale);
        $response = $this->get((new RouteService())->getRouteArt($id));
        $response->assertStatus(200);
    }

    /**
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testPageHasRobotsNoindex(string $locale): void
    {
        $id = 144;
        $this->app->setLocale($locale);
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
                'ru',
            ],
            [
                '',
                ['test' => 1],
                'ru',
            ],
            [
                ' ?',
                [],
                'en',
            ],
            [
                '',
                ['test' => 1],
                'en',
            ]
        ];
    }

    /**
     * @dataProvider providerTestHasRedirects
     *
     * @param string $postfix
     * @param array $params
     * @param string $locale
     */
    public function testHasRedirects(string $postfix, array $params, string $locale): void
    {
        $id = 144;
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

    /**
     * @dataProvider \Tests\Providers\CommonProvider::providerLanguages
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
}
