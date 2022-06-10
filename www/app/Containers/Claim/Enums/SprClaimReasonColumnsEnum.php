<?php

namespace App\Containers\Claim\Enums;

use BenSampo\Enum\Enum;

final class SprClaimReasonColumnsEnum extends Enum
{
    public const TABlE = 'spr_claim_reason';

    public const ID = 'id';
    public const REASON = 'reason';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tREASON = self::TABlE . '.' . self::REASON;
}
