<?php

namespace App\Containers\Admin\Tests\Feature\Http\Controllers;

use PHPUnit\Framework\MockObject\MockObject;
use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Containers\Vk\Tests\Traits\CreateVkAlbumTrait;
use App\Ship\Parents\Tests\TestCase;

/**
 * @see ArtController::attachPictureOnAlbum()
 */
class AttachPictureOnAlbumTest extends TestCase
{
    use CreatePictureWithRelationsTrait, CreateVkAlbumTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $mock = $this->createMock(VkApi::class);
        $this->app->bind(VkApi::class, function () use ($mock): MockObject&VkApi {
            return $mock;
        });
    }

    private function formUrl(int $pictureId): string
    {
        return route('admin.posting.vk.album.attach', ['id' => $pictureId]);
    }

    public function testPageOk(): void
    {
        $this->actingAsAdmin();
        $vkAlbum = $this->createVkAlbum();
        [$picture] = $this->createPictureWithFile();
        $outVkImageId = 100;

        $mock = $this->createMock(PhotoService::class);
        $mock->method('saveOnAlbum')
            ->willReturn($outVkImageId);
        $mock->method('edit');
        $mock->method('timeout');
        $this->app->bind(PhotoService::class, function () use ($mock): MockObject&PhotoService {
            return $mock;
        });

        $data = [
            'id' => $picture->id,
            'album_id' => $vkAlbum->id,
        ];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertOk()
            ->assertJsonStructure([]);

        $vkAlbumPictures = $vkAlbum->pictures();
        self::assertSame(1, $vkAlbumPictures->count());
        /** @var VkAlbumPictureModel $firstVkAlbumPicture */
        $firstVkAlbumPicture = $vkAlbumPictures->first();
        self::assertSame($outVkImageId, $firstVkAlbumPicture->out_vk_image_id);
        self::assertSame($picture->id, $firstVkAlbumPicture->picture_id);
    }

    public function testPageNotFoundPicture(): void
    {
        $this->actingAsAdmin();
        $vkAlbum = $this->createVkAlbum();

        $undefinedPictureId = 1111;
        $data = [
            'id' => $undefinedPictureId,
            'album_id' => $vkAlbum->id,
        ];
        $response = $this->ajaxPost($this->formUrl($undefinedPictureId), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('id');
    }

    public function testPageNotFoundVkAlbumId(): void
    {
        $this->actingAsAdmin();
        $picture = $this->createPicture();

        $undefinedVkAlbumId = 1111;
        $data = [
            'id' => $picture->id,
            'album_id' => $undefinedVkAlbumId,
        ];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertUnprocessable()
            ->assertJsonValidationErrorFor('album_id');
    }

    public function testPageUnauthorized(): void
    {
        $picture = $this->createPicture();

        $data = [];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertUnauthorized();
    }

    public function testPageForbidden(): void
    {
        $this->actingAsUser();
        $picture = $this->createPicture();

        $data = [];
        $response = $this->ajaxPost($this->formUrl($picture->id), $data);

        $response->assertForbidden();
    }

}
