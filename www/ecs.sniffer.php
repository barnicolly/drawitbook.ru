<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Classes\DuplicateClassNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyPHPStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnconditionalIfStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnusedFunctionParameterSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

// https://github.com/easy-coding-standard/easy-coding-standard/blob/main/full_ecs_build.sh
// https://tomasvotruba.com/blog/2018/06/04/how-to-migrate-from-php-code-sniffer-to-easy-coding-standard
// https://github.com/squizlabs/PHP_CodeSniffer/wiki/Usage
return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__ . '/app']);

    $ecsConfig->skip([
        __DIR__ . 'storage',
        __DIR__ . 'vendor',
    ]);

    $ecsConfig->rule(UnusedFunctionParameterSniff::class);
    $ecsConfig->rule(DuplicateClassNameSniff::class);
    $ecsConfig->rule(EmptyStatementSniff::class);
    $ecsConfig->rule(EmptyPHPStatementSniff::class);
    $ecsConfig->rule(UnconditionalIfStatementSniff::class);

    // configure cache paths & namespace - useful for Gitlab CI caching, where getcwd() produces always different path
    // [default: sys_get_temp_dir() . '/_changed_files_detector_tests']
    $ecsConfig->cacheDirectory(__DIR__ . '/cache/esc/.ecs_sniffer_cache');
};
