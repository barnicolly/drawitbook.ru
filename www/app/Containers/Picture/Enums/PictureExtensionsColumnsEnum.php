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
    public const IS_DEL = 'is_del';

    public static string $tId = self::TABlE . '.' . self::ID;
    public static string $tPICTURE_ID = self::TABlE . '.' . self::PICTURE_ID;
    public static string $tPATH = self::TABlE . '.' . self::PATH;
    public static string $tWIDTH = self::TABlE . '.' . self::WIDTH;
    public static string $tHEIGHT = self::TABlE . '.' . self::HEIGHT;
    public static string $tEXT = self::TABlE . '.' . self::EXT;
    public static string $tIS_DEL = self::TABlE . '.' . self::IS_DEL;
}
