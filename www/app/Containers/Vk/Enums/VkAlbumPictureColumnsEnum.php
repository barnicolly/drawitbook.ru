<?php

namespace App\Containers\Vk\Enums;

use BenSampo\Enum\Enum;

final class VkAlbumPictureColumnsEnum extends Enum
{
    public const TABlE = 'vk_album_picture';

    public const ID = 'id';
    public const VK_ALBUM_ID = 'vk_album_id';
    public const PICTURE_ID = 'picture_id';
    public const OUT_VK_IMAGE_ID = 'out_vk_image_id';

    public static $tId = self::TABlE . '.' . self::ID;
    public static $tVK_ALBUM_ID = self::TABlE . '.' . self::VK_ALBUM_ID;
    public static $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public static $tOUT_VK_IMAGE_ID = self::TABlE . '.' . self::OUT_VK_IMAGE_ID;
}
