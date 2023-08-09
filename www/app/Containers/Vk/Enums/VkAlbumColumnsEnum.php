<?php

declare(strict_types=1);

namespace App\Containers\Vk\Enums;

use BenSampo\Enum\Enum;

final class VkAlbumColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'vk_album';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const ALBUM_ID = 'album_id';
    /**
     * @var string
     */
    public const DESCRIPTION = 'description';
    /**
     * @var string
     */
    public const SHARE = 'share';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tALBUM_ID = self::TABlE . '.' . self::ALBUM_ID;
    /**
     * @var string
     */
    public const tDESCRIPTION = self::TABlE . '.' . self::DESCRIPTION;
    /**
     * @var string
     */
    public const tSHARE = self::TABlE . '.' . self::SHARE;
}
