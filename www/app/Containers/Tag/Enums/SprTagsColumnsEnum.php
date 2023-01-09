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
//    todo-misha переименовать в hidden_for_posting и вынести в отдельную таблицу;
    public const HIDDEN_VK = 'hidden_vk';
    public const SEO = 'seo';
    public const SLUG_EN = 'slug_en';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tNAME = self::TABlE . '.' . self::NAME;
    public static string $tNAME_EN = self::TABlE . '.' . self::NAME_EN;
    public static string $tHIDDEN = self::TABlE . '.' . self::HIDDEN;
    public static string $tHIDDEN_VK = self::TABlE . '.' . self::HIDDEN_VK;
    public static string $tSEO = self::TABlE . '.' . self::SEO;
    public static string $tSLUG_EN = self::TABlE . '.' . self::SLUG_EN;
}
