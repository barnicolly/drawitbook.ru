<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureTagsColumnsEnum extends Enum
{
    public const TABlE = 'picture_tags';

    public const ID = 'id';
    public const PICTURE_ID = 'picture_id';
    public const TAG_ID = 'tag_id';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public static string $tTAG_ID = self::TABlE . '.' . self::TAG_ID;
}
