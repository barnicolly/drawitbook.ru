<?php

namespace App\Containers\Tag\Enums;

use BenSampo\Enum\Enum;

final class SprTagsColumnsEnum extends Enum
{
    public const TABlE = 'spr_tags';

    public const ID = 'id';
    public const NAME = 'name';
    public const NAME_EN = 'name_en';
    public const SEO = 'seo';
    public const SLUG_EN = 'slug_en';

    public const tId = self::TABlE . '.' . self::ID;
    public const tNAME = self::TABlE . '.' . self::NAME;
    public const tNAME_EN = self::TABlE . '.' . self::NAME_EN;
    public const tSEO = self::TABlE . '.' . self::SEO;
    public const tSLUG_EN = self::TABlE . '.' . self::SLUG_EN;
}
