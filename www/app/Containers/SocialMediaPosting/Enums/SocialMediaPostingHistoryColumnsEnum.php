<?php

namespace App\Containers\SocialMediaPosting\Enums;

use BenSampo\Enum\Enum;

final class SocialMediaPostingHistoryColumnsEnum extends Enum
{
    public const TABlE = 'social_media_posting_history';

    public const ID = 'id';
    public const PICTURE_ID = 'picture_id';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
