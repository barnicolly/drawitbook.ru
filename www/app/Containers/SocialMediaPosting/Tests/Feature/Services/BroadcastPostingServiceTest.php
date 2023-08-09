<?php

declare(strict_types=1);

namespace App\Containers\SocialMediaPosting\Tests\Feature\Services;

use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\SocialMediaPosting\Exceptions\NotFoundPictureIdForPostingException;
use App\Containers\SocialMediaPosting\Models\SocialMediaPostingHistoryModel;
use App\Containers\SocialMediaPosting\Services\BroadcastPostingService;
use App\Containers\SocialMediaPosting\Tests\Traits\CreateSocialMediaPostingHistoryTrait;
use App\Containers\Tag\Tests\Traits\CreateTagTrait;
use App\Containers\Vk\Services\VkWallPostingStrategy;
use App\Ship\Enums\FlagsEnum;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see BroadcastPostingService
 */
final class BroadcastPostingServiceTest extends TestCase
{
    use CreateSocialMediaPostingHistoryTrait;
    use CreatePictureWithRelationsTrait;
    use CreateTagTrait;

    public function testExpectNotFoundPictureIdForPostingException(): void
    {
        $this->mock(VkWallPostingStrategy::class, static function (MockInterface $mock) : void {
            $mock
                ->shouldReceive('run')
                ->andReturn([]);
        });

        $this->expectException(NotFoundPictureIdForPostingException::class);
        $command = app(BroadcastPostingService::class);
        $command->broadcast();
    }

    public function testOk(): void
    {
        $picture = $this->createPicture();
        $picture->flag(FlagsEnum::PICTURE_IN_VK_POSTING);
        $pictureFile = $this->createPictureFile($picture);

        $tagHiddenVk = $this->createTag();
        $tagHiddenVk->flag(FlagsEnum::TAG_HIDDEN_VK);
        $this->createPictureTag($picture, $tagHiddenVk);

        $tagNotHiddenVk = $this->createTag();
        $this->createPictureTag($picture, $tagNotHiddenVk);

        $mock = $this->createMock(VkWallPostingStrategy::class);
        $strategyParams = [];
        $this->app->bind(
            VkWallPostingStrategy::class,
            static function ($app, $params) use ($mock, &$strategyParams): MockObject&VkWallPostingStrategy {
                $strategyParams = $params;
                return $mock;
            },
        );

        $command = app(BroadcastPostingService::class);
        $command->broadcast();

        $resultHistoryItems = SocialMediaPostingHistoryModel::all();
        self::assertSame(1, $resultHistoryItems->count());
        /** @var SocialMediaPostingHistoryModel $firstResultHistoryItem */
        $firstResultHistoryItem = $resultHistoryItems->first();
        self::assertSame($picture->id, $firstResultHistoryItem->picture_id);
        self::assertSame([$tagNotHiddenVk->name], $strategyParams['tags']);
        self::assertSame(formArtFsPath($pictureFile->path), $strategyParams['artPath']);
    }
}
