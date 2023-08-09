<?php

declare(strict_types=1);

namespace App\Ship\Parents\Tests;

class TruncateDatabaseState
{
    /**
     * Указывает на то, что база данных была полностью очищена (запускается перед первым тестом, остальные тесты откатываются через транзакции)
     */
    public static bool $truncated = false;
}
