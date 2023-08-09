<?php

declare(strict_types=1);

namespace App\Containers\Menu\Enums;

use BenSampo\Enum\Enum;

final class MenuLevelsColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'menu_levels';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const SPR_TAG_ID = 'spr_tag_id';
    /**
     * @var string
     */
    public const PARENT_LEVEL_ID = 'parent_level_id';
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
    public const SHOW_RU = 'show_ru';
    /**
     * @var string
     */
    public const SHOW_EN = 'show_en';
    /**
     * @var string
     */
    public const COLUMN = 'column';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tSPR_TAG_ID = self::TABlE . '.' . self::SPR_TAG_ID;
    /**
     * @var string
     */
    public const tPARENT_LEVEL_ID = self::TABlE . '.' . self::PARENT_LEVEL_ID;
    /**
     * @var string
     */
    public const tCUSTOM_NAME_RU = self::TABlE . '.' . self::CUSTOM_NAME_RU;
    /**
     * @var string
     */
    public const tCUSTOM_NAME_EN = self::TABlE . '.' . self::CUSTOM_NAME_EN;
    /**
     * @var string
     */
    public const tSHOW_RU = self::TABlE . '.' . self::SHOW_RU;
    /**
     * @var string
     */
    public const tSHOW_EN = self::TABlE . '.' . self::SHOW_EN;
    /**
     * @var string
     */
    public const tCOLUMN = self::TABlE . '.' . self::COLUMN;
}
