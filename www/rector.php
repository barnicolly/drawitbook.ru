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
use Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector;
use Rector\CodingStyle\Rector\FuncCall\CountArrayToEmptyArrayComparisonRector;
use Rector\CodingStyle\Rector\Property\NullifyUnionNullableRector;
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
//      обязательно применить все правила ниже по разделению use, свойств, переменных в разные строки (при рефакторинге будет проще)
//      \Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector::class,
//      \Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector::class,
//      \Rector\CodingStyle\Rector\ClassConst\SplitGroupedClassConstantsRector::class,
//      \Rector\CodingStyle\Rector\Property\SplitGroupedPropertiesRector::class,
//      \Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector::class,
//      \Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector::class,
//      \Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector::class,
//      \Rector\CodingStyle\Rector\String_\UseClassKeywordForClassNameResolutionRector::class,
//      может пригодится
//      \Rector\Transform\Rector\New_\NewToConstructorInjectionRector::class,
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
        SetList::TYPE_DECLARATION,
        SetList::CODE_QUALITY,
    ]);

    $rectorConfig->skip([
        //-- исключения файлов и директорий
        // blade, может поломать его
        __DIR__ . '/app/*/*.blade',
        __DIR__ . '/app/Ship/Configs',

        //-- исключения для SetList::TYPE_DECLARATION
        AddClosureReturnTypeRector::class,
        AddVoidReturnTypeWhereNoReturnRector::class,
        ArrayShapeFromConstantArrayReturnRector::class,
        AddArrowFunctionReturnTypeRector::class,
        // добавляет typehint функции, основываясь на вызовах метода
        // требуется дополнительная проверка позже (как подключим все контейнеры)
        // вероятно если запуск был только одного модуля, не поймет
        ParamTypeByMethodCallTypeRector::class,
        AddMethodCallBasedStrictParamTypeRector::class => [
            // наличие спред операторов в параметрах функции не может обработать корректно
            __DIR__ . '/app/Containers/Asup/Actions/AsupAdaptationSendCoursesAction.php',
            __DIR__ . '/app/Containers/Calendar/Actions/GetCalendarAction.php',
        ],

        //--- исключения для LevelSetList::UP_TO_PHP_74
        CountOnNullRector::class,
        AddDefaultValueForUndefinedVariableRector::class,
        NullCoalescingOperatorRector::class,
        TypedPropertyFromAssignsRector::class,
        // замена на стрелочные функции (под вопросом)
        ClosureToArrowFunctionRector::class,

        //--- исключения для SetList::CODE_QUALITY
        ExplicitBoolCompareRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,
        // изменение ради оптимизации скорости (под вопросом)
        CountArrayToEmptyArrayComparisonRector::class,
        // https://3v4l.org/TI8XL под вопросом
        IssetOnPropertyObjectToPropertyExistsRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        // обязательно к добавлению, но позже (необходимо проверить трейты)
        CompleteDynamicPropertiesRector::class,
        SwitchNegatedTernaryRector::class,
        JsonThrowOnErrorRector::class,
        OptionalParametersAfterRequiredRector::class,
        JoinStringConcatRector::class,
        RandomFunctionRector::class,
        ExplicitMethodCallOverMagicGetSetRector::class,
        AddLiteralSeparatorToNumberRector::class,
    ]);
};
