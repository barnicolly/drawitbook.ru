<?php

namespace App\Ship\Enums;

use BenSampo\Enum\Enum;

final class FlagsEnum extends Enum
{
    /**
     * @var string
     */
    private const SPR_TAGS_PREFIX = 'spr_tags';
    /**
     * @var string
     */
    public const TAG_IS_POPULAR = self::SPR_TAGS_PREFIX . '.is_popular';
    /**
     * @var string
     */
    public const TAG_HIDDEN_VK = self::SPR_TAGS_PREFIX . '.hidden_vk';
    /**
     * @var string
     */
    public const TAG_HIDDEN = self::SPR_TAGS_PREFIX . '.hidden';

    /**
     * @var string
     */
    private const PICTURE_PREFIX = 'picture';
    /**
     * @var string
     */
    public const PICTURE_COMMON = self::PICTURE_PREFIX . '.in_common';
    /**
     * @var string
     */
    public const PICTURE_IN_VK_POSTING = self::PICTURE_PREFIX . '.in_vk_posting';
}
