<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\RemovingStatic\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\ClassMethod\AddConstructorParentCallRector;
use Rector\Visibility\Rector\ClassMethod\ExplicitPublicClassMethodRector;

/**
 * Перечень правил https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
 * Документация https://getrector.com/documentation
 */
return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel(300);
    // применение FQN для импорта классов (выносит конструкции в use, оставляя название класса)
    $rectorConfig->importNames();

    // Проверяемые директории
    $rectorConfig->paths([
        __DIR__ . '/app/Ship',
        __DIR__ . '/app/Containers',
    ]);

    $rectorConfig->rules([
//        Strict https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md#strict
        AddConstructorParentCallRector::class,
//        Visibility https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md#visibility
        ExplicitPublicClassMethodRector::class,
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::TYPE_DECLARATION,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
    ]);

    $rectorConfig->skip([
        //-- исключения файлов и директорий
        // blade, может поломать его
        __DIR__ . '/app/*/*.blade',
        __DIR__ . '/app/Ship/Configs',

        //--- исключения для LevelSetList::UP_TO_PHP_82
        CountOnNullRector::class,

        //--- исключения для SetList::CODE_QUALITY
        CallableThisArrayToAnonymousFunctionRector::class,
        ExplicitBoolCompareRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        CountArrayToEmptyArrayComparisonRector::class, // изменение ради оптимизации скорости (под вопросом)
        FlipTypeControlToUseExclusiveTypeRector::class,
        JoinStringConcatRector::class,
        RandomFunctionRector::class,
        AddLiteralSeparatorToNumberRector::class,

        //--- исключения для RemovingStatic
        LocallyCalledStaticMethodToNonStaticRector::class => [
            __DIR__ . '*Test.php',
        ],

        //--- исключения для SetList::CODING_STYLE
        NewlineAfterStatementRector::class,
        NewlineBeforeNewAssignSetRector::class,
        NullableCompareToNullRector::class,
        EncapsedStringsToSprintfRector::class,
        PostIncDecToPreIncDecRector::class,
        CatchExceptionNameMatchingTypeRector::class,
    ]);
};
