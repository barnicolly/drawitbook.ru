<?php

return [
    // использовать транзакции для очистки БД после каждого теста вместо ручной очистки
    // (отключение - false пригодится когда нужно посмотреть содержимое БД после теста или во время его прохождения при локальной разработке)
    'use_transactions_for_truncate_tables' => env('PHPUNIT_USE_TRANSACTIONS_FOR_TRUNCATE_TABLES', false),
];
