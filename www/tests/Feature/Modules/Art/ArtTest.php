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
            ],
            [
                7,
            ],
        ];
    }

    /**
     * @dataProvider providerTestArtPageResponseCode200
     *
     * @param string $id
     */
    public function testArtPageResponseCode200(string $id): void
    {
        $response = $this->get((new RouteService())->getRouteArt($id));
        $response->assertStatus(200);
    }

    public function testPageHasRobotsNoindex(): void
    {
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
        $url = (new RouteService())->getRouteArt($id) . $postfix;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $assetRedirect = (new RouteService())->getRouteArt($id);
        $response = $this->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testArtResponseCode404() : void
    {
        $response = $this->get('/art');
        $response->assertStatus(404);
    }
}
