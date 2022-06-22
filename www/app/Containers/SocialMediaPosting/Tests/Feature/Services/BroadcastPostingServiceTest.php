<?php

namespace App\Containers\SocialMediaPosting\Tests\Feature\Services;

use App\Containers\Picture\Enums\PictureColumnsEnum;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException;
use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;
use App\Containers\SocialMediaPosting\Services\BroadcastPostingService;
use App\Containers\SocialMediaPosting\Tests\Traits\CreateSocialMediaPostingHistoryTrait;
use App\Containers\Vk\Enums\VkPostingStatusEnum;
use App\Containers\Vk\Services\VkWallPostingStrategy;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see BroadcastPostingService
 */
class BroadcastPostingServiceTest extends TestCase
{
    use CreateSocialMediaPostingHistoryTrait, CreatePictureWithRelationsTrait;

    public function testExpectNotFoundPictureIdForPostingException(): void
    {
        $mock = $this->createMock(VkWallPostingStrategy::class);
        $this->app->bind(VkWallPostingStrategy::class, function () use ($mock) {
            return $mock;
        });

        $this->expectException(NotFoundPictureIdForPostingException::class);
        $command = app(BroadcastPostingService::class);
        $command->broadcast();
    }

    public function testOk(): void
    {
        $picture = $this->createPicture([PictureColumnsEnum::IN_VK_POSTING => VkPostingStatusEnum::TRUE]);
        $pictureFile = $this->createPictureFile($picture);
        $mock = $this->createMock(VkWallPostingStrategy::class);
        $strategyParams = [];
        $this->app->bind(VkWallPostingStrategy::class, function ($app, $params) use ($mock, &$strategyParams) {
            $strategyParams = $params;
            return $mock;
        });

        $command = app(BroadcastPostingService::class);
        $command->broadcast();

        $resultHistoryItems = SocialMediaPostingHistoryModel::all();
        self::assertSame(1, $resultHistoryItems->count());
        /** @var SocialMediaPostingHistoryModel $firstResultHistoryItem */
        $firstResultHistoryItem = $resultHistoryItems->first();
        self::assertSame($picture->id, $firstResultHistoryItem->picture_id);
        self::assertSame([], $strategyParams['tags']);
        self::assertSame(formArtFsPath($pictureFile->path), $strategyParams['artFsPath']);
    }

}
