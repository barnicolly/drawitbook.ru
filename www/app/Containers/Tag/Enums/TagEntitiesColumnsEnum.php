<?php

namespace App\Containers\Tag\Enums;

use BenSampo\Enum\Enum;

final class TagEntitiesColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'tag_entities';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const TAG_ID = 'tag_id';
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
    public const tTAG_ID = self::TABlE . '.' . self::TAG_ID;
    /**
     * @var string
     */
    public const tENTITY_ID = self::TABlE . '.' . self::ENTITY_ID;
    /**
     * @var string
     */
    public const tENTITY_TYPE = self::TABlE . '.' . self::ENTITY_TYPE;
}
