<?php

declare(strict_types=1);

namespace App\Containers\Picture\Tests\Feature\Http\Controllers\Art;

use App\Containers\Claim\Models\UserClaimModel;
use App\Containers\Claim\Tests\Traits\CreateClaimTrait;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see \App\Containers\Picture\Http\Controllers\Art\ClaimAjaxController::register()
 */
class ClaimAjaxControllerTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateClaimTrait;

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testResponseCode200(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $sprClaimReason = $this->createSprClaimReason();

        $url = $this->routeService->getRouteArt($picture->id) . '/claim';
        $requestData = [
            'reason' => $sprClaimReason->id,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk()
            ->assertJsonStructure([]);
        /** @var UserClaimModel $userClaim */
        $userClaim = UserClaimModel::first();
        self::assertSame($userClaim->reason_id, $sprClaimReason->id);
        self::assertSame($userClaim->picture_id, $picture->id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testResponseCodeIfExistSameClaim200(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();
        $sprClaimReason = $this->createSprClaimReason();
        $userClaim = $this->createUserClaim($picture, $sprClaimReason);

        $url = $this->routeService->getRouteArt($picture->id) . '/claim';
        $requestData = [
            'reason' => $sprClaimReason->id,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertOk();
        self::assertSame(1, UserClaimModel::count());
        $userClaim->refresh();
        self::assertSame($userClaim->reason_id, $sprClaimReason->id);
        self::assertSame($userClaim->picture_id, $picture->id);
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testNotFoundPicture(string $locale): void
    {
        $this->app->setLocale($locale);
        $sprClaimReason = $this->createSprClaimReason();
        $pictureId = 111111;

        $url = $this->routeService->getRouteArt($pictureId) . '/claim';
        $requestData = [
            'reason' => $sprClaimReason->id,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    /**
     * @dataProvider \App\Containers\Translation\Tests\Providers\CommonProvider::providerLanguages
     */
    public function testUndefinedClaimReason(string $locale): void
    {
        $this->app->setLocale($locale);
        [$picture] = $this->createPictureWithFile();

        $url = $this->routeService->getRouteArt($picture->id) . '/claim';
        $requestData = [
            'reason' => 111111,
        ];
        $response = $this->ajaxPost($url, $requestData);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('reason');
    }
}
