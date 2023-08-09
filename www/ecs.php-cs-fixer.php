<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/app']);

    $ecsConfig->skip([
        __DIR__ . 'storage',
        __DIR__ . 'vendor',
    ]);

    $ecsConfig->rule(FinalClassFixer::class);

    $ecsConfig->cacheDirectory(__DIR__ . '/cache/esc/.ecs_php_cs_fixer_cache');
};
