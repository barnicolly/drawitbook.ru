<?php

namespace App\Containers\Category\Enums;

use BenSampo\Enum\Enum;

final class CategoryColumnsEnum extends Enum
{
    public const TABlE = 'category';

    public const ID = 'id';
    public const PARENT_ID = 'parent_id';
    public const SPR_TAG_ID = 'spr_tag_id';
    public const CUSTOM_NAME_RU = 'custom_name_ru';
    public const CUSTOM_NAME_EN = 'custom_name_en';
    public const SHOW_RU = 'show_ru';
    public const SHOW_EN = 'show_en';

    public const tId = self::TABlE . '.' . self::ID;
    public const tPARENT_ID = self::TABlE . '.' . self::PARENT_ID;
    public const tSPR_TAG_ID = self::TABlE . '.' . self::SPR_TAG_ID;
    public const tCUSTOM_NAME_RU = self::TABlE . '.' . self::CUSTOM_NAME_RU;
    public const tCUSTOM_NAME_EN = self::TABlE . '.' . self::CUSTOM_NAME_EN;
    public const tSHOW_RU = self::TABlE . '.' . self::SHOW_RU;
    public const tSHOW_EN = self::TABlE . '.' . self::SHOW_EN;
}
