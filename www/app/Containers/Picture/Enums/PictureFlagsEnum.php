<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureFlagsEnum extends Enum
{
    private const PREFIX = 'picture';

    public const IN_COMMON = self::PREFIX . '.in_common';
}
