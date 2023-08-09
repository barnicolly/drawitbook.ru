<?php

declare(strict_types=1);

namespace App\Containers\Admin\Tests\Feature\Http\Controllers;

use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;
use App\Containers\Admin\Http\Controllers\ArtController;
use App\Containers\Picture\Tests\Traits\CreatePictureWithRelationsTrait;
use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Containers\Vk\Models\VkAlbumPictureModel;
use App\Containers\Vk\Services\Api\PhotoService;
use App\Containers\Vk\Services\Api\VkApi;
use App\Containers\Vk\Tests\Traits\CreateVkAlbumTrait;
use App\Ship\Parents\Tests\TestCase;
use Illuminate\Support\Collection;

/**
 * @see ArtController::detachPictureFromAlbum()
 */
final class DetachPictureFromAlbumTest extends TestCase
{
    use CreatePictureWithRelationsTrait;
    use CreateVkAlbumTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mock(VkApi::class);
    }

    private function formUrl(int $pictureId): string
    {
        return route('admin.posting.vk.album.detach', ['id' => $pictureId]);
    }

    public function testPageOk(): void
    {
        $this->actingAsAdmin();
        $vkAlbum = $this->createVkAlbum();
        $vkAlbumPictures = new Collection();
        $vkAlbumPictures->push($this->createVkAlbumPicture($vkAlbum));
        $vkAlbumPictures->push($this->createVkAlbumPicture($vkAlbum));

        $this->mock(PhotoService::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('delete');
        });

        /** @var VkAlbumPictureModel $vkAlbumPictureForDelete */
        $vkAlbumPictureForDelete = $vkAlbumPictures->shift();
        $data = [
            'id' => $vkAlbumPictureForDelete->picture_id,
            'album_id' => $vkAlbum->id,
        ];
        $response = $this->ajaxPost($this->formUrl($vkAlbumPictureForDelete->picture_id), $data);

        $response->assertOk()
            ->assertJsonStructure([]);

        $vkAlbumPictures = $vkAlbum->pictures();
        self::assertSame(1, $vkAlbumPictures->count());
        /** @var VkAlbumPictureModel $firstVkAlbumPicture */
        $firstVkAlbumPicture = $vkAlbumPictures->first();
        $expectedPictureId = $vkAlbumPictures->first()->{VkAlbumPictureColumnsEnum::PICTURE_ID};
        self::assertSame($expectedPictureId, $firstVkAlbumPicture->picture_id);
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
