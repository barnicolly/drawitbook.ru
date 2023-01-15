<?php

namespace App\Containers\Menu\Enums;

use BenSampo\Enum\Enum;

final class MenuLevelsColumnsEnum extends Enum
{
    public const TABlE = 'menu_levels';

    public const ID = 'id';
    public const SPR_TAG_ID = 'spr_tag_id';
    public const PARENT_LEVEL_ID = 'parent_level_id';
    public const CUSTOM_NAME_RU = 'custom_name_ru';
    public const CUSTOM_NAME_EN = 'custom_name_en';
    public const SHOW_RU = 'show_ru';
    public const SHOW_EN = 'show_en';
    public const COLUMN = 'column';

    public const tId = self::TABlE . '.' . self::ID;
    public const tSPR_TAG_ID = self::TABlE . '.' . self::SPR_TAG_ID;
    public const tPARENT_LEVEL_ID = self::TABlE . '.' . self::PARENT_LEVEL_ID;
    public const tCUSTOM_NAME_RU = self::TABlE . '.' . self::CUSTOM_NAME_RU;
    public const tCUSTOM_NAME_EN = self::TABlE . '.' . self::CUSTOM_NAME_EN;
    public const tSHOW_RU = self::TABlE . '.' . self::SHOW_RU;
    public const tSHOW_EN = self::TABlE . '.' . self::SHOW_EN;
    public const tCOLUMN = self::TABlE . '.' . self::COLUMN;
}
