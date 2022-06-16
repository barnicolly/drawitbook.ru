<?php

namespace App\Containers\Rate\Enums;

use BenSampo\Enum\Enum;

final class LikesColumnsEnum extends Enum
{
    public const TABlE = 'likes';

    public const ID = 'id';
    public const IP = 'ip';
    public const USER_ID = 'user_id';
    public const PICTURE_ID = 'picture_id';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tIP = self::TABlE . '.' . self::IP;
    public static string $tUSER_ID = self::TABlE . '.' . self::USER_ID;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
