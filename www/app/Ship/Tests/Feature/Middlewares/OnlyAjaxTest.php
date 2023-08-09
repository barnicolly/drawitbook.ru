<?php

declare(strict_types=1);

namespace App\Ship\Tests\Feature\Middlewares;

use App\Containers\Translation\Enums\LangEnum;
use App\Ship\Middlewares\OnlyAjax;
use App\Ship\Parents\Tests\MiddlewareTestCase;
use App\Ship\Parents\Tests\Traits\RequestsTrait;
use Symfony\Component\HttpFoundation\Response;

class OnlyAjaxTest extends MiddlewareTestCase
{
    use RequestsTrait;

    private string $url = '/ru/dummy-test-route';
    private string $word = 'абстрактность';

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale(LangEnum::RU);
        $this->createTestRouteWithMiddlewares($this->url . '/{word}', [OnlyAjax::class]);
    }

    public function testGetRequestOk(): void
    {
        $response = $this->ajaxGet($this->url . '/' . $this->word);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testPostRequestOk(): void
    {
        $response = $this->ajaxPost($this->url . '/' . $this->word);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testGetRequestNotAjaxFail(): void
    {
        $response = $this->get($this->url . '/' . $this->word);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testPostRequestNotAjaxFail(): void
    {
        $response = $this->post($this->url . '/' . $this->word);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
