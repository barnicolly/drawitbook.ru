<?php

namespace App\Containers\Claim\Enums;

use BenSampo\Enum\Enum;

final class UserClaimColumnsEnum extends Enum
{
    public const TABlE = 'user_claim';

    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const IP = 'ip';
    public const PICTURE_ID = 'picture_id';
    public const REASON_ID = 'reason_id';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tUSER_ID = self::TABlE . '.' . self::USER_ID;
    public static string $tIP = self::TABlE . '.' . self::IP;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public static string $tREASON_ID = self::TABlE . '.' . self::REASON_ID;
}
