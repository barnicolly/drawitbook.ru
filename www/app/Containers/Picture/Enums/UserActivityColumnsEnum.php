<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class UserActivityColumnsEnum extends Enum
{
    public const TABlE = 'user_activity';

    public const ID = 'id';
    public const IP = 'ip';
    public const USER_ID = 'user_id';
    public const PICTURE_ID = 'picture_id';
    public const ACTIVITY = 'activity';
    public const STATUS = 'status';
    public const IS_DEL = 'is_del';

    public static $tId = self::TABlE . '.' . self::ID;
    public static $tIP = self::TABlE . '.' . self::IP;
    public static $tUSER_ID = self::TABlE . '.' . self::USER_ID;
    public static $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public static $tACTIVITY = self::TABlE . '.' . self::ACTIVITY;
    public static $tSTATUS = self::TABlE . '.' . self::STATUS;
    public static $tIS_DEL = self::TABlE . '.' . self::IS_DEL;
}
