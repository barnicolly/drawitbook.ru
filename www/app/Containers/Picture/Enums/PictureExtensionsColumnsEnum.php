<?php

namespace App\Containers\Picture\Enums;

use BenSampo\Enum\Enum;

final class PictureExtensionsColumnsEnum extends Enum
{
    public const TABlE = 'picture_extensions';

    public const ID = 'id';
    public const PICTURE_ID = 'picture_id';
    public const PATH = 'path';
    public const WIDTH = 'width';
    public const HEIGHT = 'height';
    public const EXT = 'ext';
    public const MIME_TYPE = 'mime_type';

    public const tId = self::TABlE . '.' . self::ID;
    public const tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public const tPATH = self::TABlE . '.' . self::PATH;
    public const tWIDTH = self::TABlE . '.' . self::WIDTH;
    public const tHEIGHT = self::TABlE . '.' . self::HEIGHT;
    public const tEXT = self::TABlE . '.' . self::EXT;
    public const tMIME_TYPE = self::TABlE . '.' . self::MIME_TYPE;
}
