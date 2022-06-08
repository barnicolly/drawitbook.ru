<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Services\File\FileService;
use Symfony\Component\HttpFoundation\Response;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\ArtHttpController::index()
 */
class ArtHttpControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testArtPageResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture, $file] = $this->createPictureWithFile();
        $mock = $this->createMock(FileService::class);
        $mock->method('formArtUrlPath')
            ->willReturn($file->path);
        $this->app->bind(FileService::class, function () use ($mock) {
            return $mock;
        });

        $response = $this->get($this->routeService->getRouteArt($picture->id));

        $response->assertOk()
            ->assertSee('<meta name="robots" content="noindex">', false)
            ->assertSee('<link rel="alternate" href="', false);
    }

    public function providerTestHasRedirects(): array
    {
        return [
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
            ],
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
        [$picture, $file] = $this->createPictureWithFile();
        $id = $picture->id;
        $locales = LangEnum::asArray();
        foreach ($locales as $locale) {
            $this->app->setLocale($locale);

            $url = $this->routeService->getRouteArt($id) . $postfix;
            if (!empty($params)) {
                $url .= '?' . http_build_query($params);
            }
            $response = $this->get($url);

            $assetRedirect = $this->routeService->getRouteArt($id);
            $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY)
                ->assertRedirect($assetRedirect);
        }
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testArtResponseCode404(string $locale): void
    {
        $this->app->setLocale($locale);

        $response = $this->followingRedirects()
            ->get('/art');

        $response->assertStatus(404);
    }

}
