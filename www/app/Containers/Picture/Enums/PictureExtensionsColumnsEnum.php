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

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public static string $tPATH = self::TABlE . '.' . self::PATH;
    public static string $tWIDTH = self::TABlE . '.' . self::WIDTH;
    public static string $tHEIGHT = self::TABlE . '.' . self::HEIGHT;
    public static string $tEXT = self::TABlE . '.' . self::EXT;
    public static string $tMIME_TYPE = self::TABlE . '.' . self::MIME_TYPE;
}
