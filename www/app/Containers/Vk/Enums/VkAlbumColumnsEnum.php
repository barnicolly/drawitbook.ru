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

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tALBUM_ID = self::TABlE . '.' . self::ALBUM_ID;
    public static string $tDESCRIPTION = self::TABlE . '.' . self::DESCRIPTION;
    public static string $tSHARE = self::TABlE . '.' . self::SHARE;
}
