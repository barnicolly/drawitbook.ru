<?php

namespace App\Containers\Vk\Models;

use App\Containers\Vk\Data\Factories\VkAlbumModelFactory;
use App\Containers\Vk\Enums\VkAlbumColumnsEnum;
use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $album_id
 * @property string $description
 * @property string $share
 *
 * @method static VkAlbumModelFactory factory
 */
class VkAlbumModel extends CoreModel
{
    use HasFactory;

    protected $table = VkAlbumColumnsEnum::TABlE;

    protected $fillable = [];

//    todo-misha переделать под repository;
    public static function getById(int $vkAlbumId): ?array
    {
        $album = self::query()
            ->find($vkAlbumId);
        return $album
            ? $album->toArray()
            : null;
    }

    public static function getAll(): array
    {
        $result = self::query()
            ->getQuery()
            ->get()
            ->toArray();
        return self::mapToArray($result);
    }

    public function pictures(): HasMany
    {
        return $this->hasMany(
            VkAlbumPictureModel::class,
            VkAlbumPictureColumnsEnum::VK_ALBUM_ID,
            VkAlbumColumnsEnum::ID
        );
    }

    protected static function newFactory(): VkAlbumModelFactory
    {
        return VkAlbumModelFactory::new();
    }

}
