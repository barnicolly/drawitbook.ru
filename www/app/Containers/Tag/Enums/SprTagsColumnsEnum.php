<?php

namespace App\Containers\Tag\Enums;

use BenSampo\Enum\Enum;

final class SprTagsColumnsEnum extends Enum
{
    public const TABlE = 'spr_tags';

    public const ID = 'id';
    public const NAME = 'name';
    public const NAME_EN = 'name_en';
    public const HIDDEN = 'hidden';
    public const HIDDEN_VK = 'hidden_vk';
    public const SEO = 'seo';
    public const SLUG_EN = 'slug_en';
    public const IS_POPULAR = 'is_popular';

    public static $tId = self::TABlE . '.' . self::ID;
    public static $tNAME = self::TABlE . '.' . self::NAME;
    public static $tNAME_EN = self::TABlE . '.' . self::NAME_EN;
    public static $tHIDDEN = self::TABlE . '.' . self::HIDDEN;
    public static $tHIDDEN_VK = self::TABlE . '.' . self::HIDDEN_VK;
    public static $tSEO = self::TABlE . '.' . self::SEO;
    public static $tSLUG_EN = self::TABlE . '.' . self::SLUG_EN;
    public static $tIS_POPULAR = self::TABlE . '.' . self::IS_POPULAR;
}
