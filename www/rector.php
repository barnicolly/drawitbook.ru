<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\ClassMethod\OptionalParametersAfterRequiredRector;
use Rector\CodeQuality\Rector\Concat\JoinStringConcatRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodeQuality\Rector\PropertyFetch\ExplicitMethodCallOverMagicGetSetRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\ClassConst\SplitGroupedClassConstantsRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\Property\NullifyUnionNullableRector;
use Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector;
use Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\Php56\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ArrowFunction\AddArrowFunctionReturnTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddMethodCallBasedStrictParamTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ArrayShapeFromConstantArrayReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

/**
 * Перечень правил (в сет листах и исключениях) https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
 * Документация https://getrector.com/documentation
 *
 * $rectorConfig->phpVersion нет необходимости указывать, возьмет версию php из composer.json
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
        ConsistentImplodeRector::class,
        NullifyUnionNullableRector::class,
        SeparateMultiUseImportsRector::class,
        SplitDoubleAssignRector::class,
        SplitGroupedClassConstantsRector::class,
        SplitGroupedPropertiesRector::class,
        TernaryConditionVariableAssignmentRector::class,
        UnSpreadOperatorRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
        UseClassKeywordForClassNameResolutionRector::class,
    ]);

    $rectorConfig->sets([
//        LevelSetList::UP_TO_PHP_82,
        SetList::TYPE_DECLARATION,
        SetList::CODE_QUALITY,
    ]);

    $rectorConfig->skip([
        //-- исключения файлов и директорий
        // blade, может поломать его
        __DIR__ . '/app/*/*.blade',
        __DIR__ . '/app/Ship/Configs',

        //--- исключения для LevelSetList::UP_TO_PHP_82
        CountOnNullRector::class,
        AddDefaultValueForUndefinedVariableRector::class,
        NullCoalescingOperatorRector::class,
        TypedPropertyFromAssignsRector::class,
        // замена на стрелочные функции (под вопросом)
        ClosureToArrowFunctionRector::class,

        //--- исключения для SetList::CODE_QUALITY
        \Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector::class,
        ExplicitBoolCompareRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        // изменение ради оптимизации скорости (под вопросом)
        CountArrayToEmptyArrayComparisonRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        // обязательно к добавлению, но позже (необходимо проверить трейты)
//        CompleteDynamicPropertiesRector::class,
        SwitchNegatedTernaryRector::class,
        JsonThrowOnErrorRector::class,
        OptionalParametersAfterRequiredRector::class,
        JoinStringConcatRector::class,
        RandomFunctionRector::class,
        ExplicitMethodCallOverMagicGetSetRector::class,
        AddLiteralSeparatorToNumberRector::class,
    ]);
};
