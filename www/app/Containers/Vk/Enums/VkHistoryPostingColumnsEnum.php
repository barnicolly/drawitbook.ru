<?php

namespace App\Containers\Vk\Enums;

use BenSampo\Enum\Enum;

final class VkHistoryPostingColumnsEnum extends Enum
{
    public const TABlE = 'history_vk_posting';

    public const ID = 'id';
    public const PICTURE_ID = 'picture_id';

    public static $tId = self::TABlE . '.' . self::ID;
    public static $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
