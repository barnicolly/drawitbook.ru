<?php

namespace App\Containers\Vk\Enums;

use BenSampo\Enum\Enum;

final class VkHistoryPostingColumnsEnum extends Enum
{
    public const TABlE = 'history_vk_posting';

    public const ID = 'id';
    public const PICTURE_ID = 'picture_id';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
