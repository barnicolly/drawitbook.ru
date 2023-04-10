<?php

namespace App\Ship\Tests\Feature\Middlewares;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Middlewares\InLowerCase;
use App\Ship\Parents\Tests\MiddlewareTestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class InLowerCaseTest extends MiddlewareTestCase
{
    private string $url = '/ru/dummy-test-route';
    private string $correctWord = 'абстрактность';

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::RU);
        $this->createTestRouteWithMiddlewares($this->url . '/{word}', [InLowerCase::class]);
    }

    public function testCallNextCallback(): void
    {
        $url = implode('/', [$this->url, $this->correctWord]);
        $request = Request::create($url, 'GET');
        $this->assertCalledNextMiddleware(new InLowerCase(), $request, true);
    }

    public function provider(): array
    {
        return [
            [
                'Абстрактность',
            ],
            [
                'Абстрактность ',
            ],
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testHasRedirect(string $word): void
    {
        $assetRedirect = implode('/', [$this->url, $this->correctWord]);
        $response = $this->get($this->url . '/' . $word);
        $response->assertStatus(Response::HTTP_MOVED_PERMANENTLY);
        $response->assertRedirect($assetRedirect);
    }

    /**
     * @dataProvider provider
     */
    public function testNotCallNextCallback(string $word): void
    {
        $url = implode('/', [$this->url, $word]);
        $request = Request::create($url, 'GET');
        $this->assertCalledNextMiddleware(new InLowerCase(), $request, false);
    }
}
