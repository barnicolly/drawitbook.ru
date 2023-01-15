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

    public const tId = self::TABlE . '.' . self::ID;
    public const tIP = self::TABlE . '.' . self::IP;
    public const tUSER_ID = self::TABlE . '.' . self::USER_ID;
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
