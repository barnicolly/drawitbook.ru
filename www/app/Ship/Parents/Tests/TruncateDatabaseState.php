<?php

namespace App\Ship\Parents\Tests;

class TruncateDatabaseState
{
    /**
     * Указывает на то, что база данных была полностью очищена (запускается перед первым тестом, остальные тесты откатываются через транзакции)
     *
     * @var bool
     */
    public static bool $truncated = false;
}
