<?php

namespace App\Containers\Vk\Enums;

use BenSampo\Enum\Enum;

final class VkAlbumColumnsEnum extends Enum
{
    public const TABlE = 'vk_album';

    public const ID = 'id';
    public const ALBUM_ID = 'album_id';
    public const DESCRIPTION = 'description';
    public const SHARE = 'share';

    public const tId = self::TABlE . '.' . self::ID;
    public const tALBUM_ID = self::TABlE . '.' . self::ALBUM_ID;
    public const tDESCRIPTION = self::TABlE . '.' . self::DESCRIPTION;
    public const tSHARE = self::TABlE . '.' . self::SHARE;
}
