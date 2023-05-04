<?php

namespace App\Ship\Enums;

use BenSampo\Enum\Enum;

final class FlagsEnum extends Enum
{
    /**
     * @var string
     */
    private const TAGS_PREFIX = 'tags';
    /**
     * @var string
     */
    public const TAG_IS_POPULAR = self::TAGS_PREFIX . '_is_popular';
    /**
     * @var string
     */
    public const TAG_HIDDEN_VK = self::TAGS_PREFIX . '_hidden_vk';
    /**
     * @var string
     */
    public const TAG_HIDDEN = self::TAGS_PREFIX . '_hidden';

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
