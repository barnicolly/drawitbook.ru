<?php

namespace App\Containers\Tag\Enums;

use BenSampo\Enum\Enum;

final class SprTagsFlagsEnum extends Enum
{
    private const PREFIX = 'spr_tags';

    public const IS_POPULAR = self::PREFIX . '.is_popular';
}
