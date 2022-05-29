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

    public static $tId = self::TABlE . '.' . self::ID;
    public static $tALBUM_ID = self::TABlE . '.' . self::ALBUM_ID;
    public static $tDESCRIPTION = self::TABlE . '.' . self::DESCRIPTION;
    public static $tSHARE = self::TABlE . '.' . self::SHARE;
}
