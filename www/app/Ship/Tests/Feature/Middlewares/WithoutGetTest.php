<?php

declare(strict_types=1);

namespace App\Ship\Tests\Feature\Middlewares;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Middlewares\WithoutGet;
use App\Ship\Parents\Tests\MiddlewareTestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

final class WithoutGetTest extends MiddlewareTestCase
{
    private string $url = '/ru/dummy-test-route';
    private static string $correctWord = 'абстрактность';

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::RU);
        $this->createTestRouteWithMiddlewares($this->url . '/{word}', [WithoutGet::class]);
    }

    public static function providerPositive(): array
    {
        return [
            [
                self::$correctWord,
                [],
            ],
            [
                self::$correctWord . '?',
                [],
            ],
        ];
    }

    /**
     * @dataProvider providerPositive
     */
    public function testCallNextCallback(string $word, array $params): void
    {
        $url = implode('/', [$this->url, $word]);
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $request = Request::create($url, 'GET');
        $this->assertCalledNextMiddleware(new WithoutGet(), $request, true);
    }

    public function testHasRedirect(): void
    {
        $params = [
            'test' => 1,
        ];
        $assetRedirect = implode('/', [$this->url, self::$correctWord]);
        $url = $assetRedirect;
        $url .= '?' . http_build_query($params);
        $response = $this->get($url);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    public function testNotCallNextCallback(): void
    {
        $params = [
            'test' => 1,
        ];
        $url = implode('/', [$this->url, self::$correctWord]);
        $url .= '?' . http_build_query($params);
        $request = Request::create($url, 'GET');
        $this->assertCalledNextMiddleware(new WithoutGet(), $request, false);
    }
}
