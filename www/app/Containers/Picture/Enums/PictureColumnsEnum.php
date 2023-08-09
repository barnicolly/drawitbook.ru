<?php

declare(strict_types=1);

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'pictures';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const CREATED_AT = 'created_at';
    /**
     * @var string
     */
    public const UPDATED_AT = 'updated_at';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
}
