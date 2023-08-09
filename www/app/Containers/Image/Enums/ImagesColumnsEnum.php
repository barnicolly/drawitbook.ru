<?php

declare(strict_types=1);

namespace App\Containers\Image\Enums;

use BenSampo\Enum\Enum;

final class ImagesColumnsEnum extends Enum
{
    /**
     * @var string
     */
    public const TABlE = 'images';

    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const PATH = 'path';
    /**
     * @var string
     */
    public const WIDTH = 'width';
    /**
     * @var string
     */
    public const HEIGHT = 'height';
    /**
     * @var string
     */
    public const EXT = 'ext';
    /**
     * @var string
     */
    public const MIME_TYPE = 'mime_type';

    /**
     * @var string
     */
    public const tId = self::TABlE . '.' . self::ID;
    /**
     * @var string
     */
    public const tPATH = self::TABlE . '.' . self::PATH;
    /**
     * @var string
     */
    public const tWIDTH = self::TABlE . '.' . self::WIDTH;
    /**
     * @var string
     */
    public const tHEIGHT = self::TABlE . '.' . self::HEIGHT;
    /**
     * @var string
     */
    public const tEXT = self::TABlE . '.' . self::EXT;
    /**
     * @var string
     */
    public const tMIME_TYPE = self::TABlE . '.' . self::MIME_TYPE;
}
