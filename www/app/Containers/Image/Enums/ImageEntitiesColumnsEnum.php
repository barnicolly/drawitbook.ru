<?php

namespace App\Containers\Image\Enums;

use BenSampo\Enum\Enum;

final class ImageEntitiesColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'image_entities';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const IMAGE_ID = 'image_id';
    /**
     * @var string
     */
    public const ENTITY_ID = 'entity_id';
    /**
     * @var string
     */
    public const ENTITY_TYPE = 'entity_type';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tImageId = self::TABlE . '.' . self::IMAGE_ID;
    /**
     * @var string
     */
    public const tEntityId = self::TABlE . '.' . self::ENTITY_ID;
    /**
     * @var string
     */
    public const tEntityType = self::TABlE . '.' . self::ENTITY_TYPE;
}
