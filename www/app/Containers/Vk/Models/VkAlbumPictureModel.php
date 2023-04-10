<?php

namespace App\Containers\Vk\Models;

use App\Containers\Vk\Data\Factories\VkAlbumPictureModelFactory;
use App\Containers\Vk\Enums\VkAlbumPictureColumnsEnum;
use App\Ship\Parents\Models\CoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $vk_album_id
 * @property int $picture_id
 * @property int $out_vk_image_id
 *
 * @method static VkAlbumPictureModelFactory factory
 */
class VkAlbumPictureModel extends CoreModel
{
    use HasFactory;

    protected $table = VkAlbumPictureColumnsEnum::TABlE;

    protected $fillable = [];
    public $timestamps = false;

    protected static function newFactory(): VkAlbumPictureModelFactory
    {
        return VkAlbumPictureModelFactory::new();
    }
}
