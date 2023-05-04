<?php

namespace App\Containers\Vk\Enums;

use BenSampo\Enum\Enum;

final class VkAlbumPictureColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'vk_album_picture';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const VK_ALBUM_ID = 'vk_album_id';
    /**
     * @var string
     */
    public const PICTURE_ID = 'picture_id';
    /**
     * @var string
     */
    public const OUT_VK_IMAGE_ID = 'out_vk_image_id';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tVK_ALBUM_ID = self::TABlE . '.' . self::VK_ALBUM_ID;
    /**
     * @var string
     */
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    /**
     * @var string
     */
    public const tOUT_VK_IMAGE_ID = self::TABlE . '.' . self::OUT_VK_IMAGE_ID;
}
