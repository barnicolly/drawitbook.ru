<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureColumnsEnum extends Enum
{
    public const TABlE = 'picture';

    public const ID = 'id';
    public const DESCRIPTION = 'description';
    public const IN_COMMON = 'in_common';
    public const IN_VK_POSTING = 'in_vk_posting';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tDESCRIPTION = self::TABlE . '.' . self::DESCRIPTION;
    public static string $tIN_COMMON = self::TABlE . '.' . self::IN_COMMON;
    public static string $tIN_VK_POSTING = self::TABlE . '.' . self::IN_VK_POSTING;
}
