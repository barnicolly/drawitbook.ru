<?php

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Rate\Enums\RateEnum;
use App\Containers\Rate\Enums\UserActivityColumnsEnum;
use App\Containers\Rate\Models\UserActivityModel;
use App\Containers\Rate\Tests\Traits\CreateUserActivityTrait;
use App\Ship\Enums\SoftDeleteStatusEnum;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\RateHttpController::like
 */
class RateHttpControllerLikeTest extends TestCase
{
    use CreatePictureWithRelationsTrait, CreateUserActivityTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testLikeWithoutUserActivityRecordResponseOk(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        /** @var UserActivityModel $userActivity */
        $userActivity = UserActivityModel::first();
        self::assertSame(RateEnum::LIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
        self::assertSame(SoftDeleteStatusEnum::FALSE, $userActivity->is_del);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testLikeWithUserActivityRecordNoChangeActivityAndSoftDelete(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $userActivity = $this->createUserActivity($picture, [UserActivityColumnsEnum::ACTIVITY => RateEnum::LIKE]);

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        $userActivity->refresh();
        self::assertSame(RateEnum::LIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
        self::assertSame(SoftDeleteStatusEnum::FALSE, $userActivity->is_del);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testLikeWithUserActivityRecordChangeActivityAndSoftDelete(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $userActivity = $this->createUserActivity(
            $picture,
            [
                UserActivityColumnsEnum::ACTIVITY => RateEnum::DISLIKE,
                UserActivityColumnsEnum::IS_DEL => SoftDeleteStatusEnum::TRUE,
            ]
        );

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'false',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        $userActivity->refresh();
        self::assertSame(RateEnum::LIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
        self::assertSame(SoftDeleteStatusEnum::FALSE, $userActivity->is_del);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     *
     * @param string $locale
     */
    public function testOffLikeWithUserLikeActivityRecordSoftDelete(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $userActivity = $this->createUserActivity(
            $picture,
            [
                UserActivityColumnsEnum::ACTIVITY => RateEnum::LIKE,
                UserActivityColumnsEnum::IS_DEL => SoftDeleteStatusEnum::FALSE,
            ]
        );

        $url = $this->routeService->getRouteArt($picture->id) . '/like';
        $requestData = [
            'off' => 'true',
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        $userActivity->refresh();
        self::assertSame(RateEnum::LIKE, $userActivity->activity);
        self::assertSame($picture->id, $userActivity->picture_id);
        self::assertSame(SoftDeleteStatusEnum::TRUE, $userActivity->is_del);
    }

}