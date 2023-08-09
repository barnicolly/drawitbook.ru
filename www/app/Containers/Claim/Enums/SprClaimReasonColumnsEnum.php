<?php

declare(strict_types=1);

namespace App\Containers\Claim\Enums;

use BenSampo\Enum\Enum;

final class SprClaimReasonColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'spr_claim_reason';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const REASON = 'reason';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tREASON = self::TABlE . '.' . self::REASON;
}
