<?php

namespace App\Containers\Like\Enums;

use BenSampo\Enum\Enum;

final class LikesColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'likes';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const IP = 'ip';
    /**
     * @var string
     */
    public const USER_ID = 'user_id';
    /**
     * @var string
     */
    public const PICTURE_ID = 'picture_id';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tIP = self::TABlE . '.' . self::IP;
    /**
     * @var string
     */
    public const tUSER_ID = self::TABlE . '.' . self::USER_ID;
    /**
     * @var string
     */
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
