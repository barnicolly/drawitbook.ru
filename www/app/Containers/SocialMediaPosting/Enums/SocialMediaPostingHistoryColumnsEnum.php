<?php

namespace App\Containers\SocialMediaPosting\Enums;

use BenSampo\Enum\Enum;

final class SocialMediaPostingHistoryColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'social_media_posting_history';

    /**
     * @var string
     */
    public const ID = 'id';
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
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
}
