<?php

namespace App\Containers\Category\Enums;

use BenSampo\Enum\Enum;

final class CategoryColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'category';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const PARENT_ID = 'parent_id';
    /**
     * @var string
     */
    public const SPR_TAG_ID = 'spr_tag_id';
    /**
     * @var string
     */
    public const CUSTOM_NAME_RU = 'custom_name_ru';
    /**
     * @var string
     */
    public const CUSTOM_NAME_EN = 'custom_name_en';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tPARENT_ID = self::TABlE . '.' . self::PARENT_ID;
    /**
     * @var string
     */
    public const tSPR_TAG_ID = self::TABlE . '.' . self::SPR_TAG_ID;
    /**
     * @var string
     */
    public const tCUSTOM_NAME_RU = self::TABlE . '.' . self::CUSTOM_NAME_RU;
    /**
     * @var string
     */
    public const tCUSTOM_NAME_EN = self::TABlE . '.' . self::CUSTOM_NAME_EN;
}
