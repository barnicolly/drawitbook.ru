<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureTagsColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'picture_tags';

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
    public const TAG_ID = 'tag_id';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    /**
     * @var string
     */
    public const tTAG_ID = self::TABlE . '.' . self::TAG_ID;
}
