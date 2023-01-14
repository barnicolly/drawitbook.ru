<?php

namespace App\Ship\Enums;

use BenSampo\Enum\Enum;

final class FlagsEnum extends Enum
{
    private const SPR_TAGS_PREFIX = 'spr_tags';
    public const TAG_IS_POPULAR = self::SPR_TAGS_PREFIX . '.is_popular';
    public const TAG_HIDDEN_VK = self::SPR_TAGS_PREFIX . '.hidden_vk';

    private const PICTURE_PREFIX = 'picture';
    public const PICTURE_COMMON = self::PICTURE_PREFIX . '.in_common';
    public const PICTURE_IN_VK_POSTING = self::PICTURE_PREFIX . '.in_vk_posting';
}
