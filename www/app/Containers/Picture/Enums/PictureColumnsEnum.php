<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureColumnsEnum extends Enum
{
    public const TABlE = 'picture';

    public const ID = 'id';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    public static string $tId = self::TABlE . '.' . self::ID;
}
