<?php

declare(strict_types=1);

namespace App\Containers\Claim\Enums;

use BenSampo\Enum\Enum;

final class UserClaimColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'user_claim';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const USER_ID = 'user_id';
    /**
     * @var string
     */
    public const IP = 'ip';
    /**
     * @var string
     */
    public const PICTURE_ID = 'picture_id';
    /**
     * @var string
     */
    public const REASON_ID = 'reason_id';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tUSER_ID = self::TABlE . '.' . self::USER_ID;
    /**
     * @var string
     */
    public const tIP = self::TABlE . '.' . self::IP;
    /**
     * @var string
     */
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    /**
     * @var string
     */
    public const tREASON_ID = self::TABlE . '.' . self::REASON_ID;
}
