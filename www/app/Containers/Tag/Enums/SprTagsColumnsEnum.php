<?php

namespace App\Containers\Tag\Enums;

use BenSampo\Enum\Enum;

final class SprTagsColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'spr_tags';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const NAME = 'name';
    /**
     * @var string
     */
    public const NAME_EN = 'name_en';
    /**
     * @var string
     */
    public const SEO = 'seo';
    /**
     * @var string
     */
    public const SLUG_EN = 'slug_en';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tNAME = self::TABlE . '.' . self::NAME;
    /**
     * @var string
     */
    public const tNAME_EN = self::TABlE . '.' . self::NAME_EN;
    /**
     * @var string
     */
    public const tSEO = self::TABlE . '.' . self::SEO;
    /**
     * @var string
     */
    public const tSLUG_EN = self::TABlE . '.' . self::SLUG_EN;
}
