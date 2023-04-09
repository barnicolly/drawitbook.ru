<?php
$finder = PhpCsFixer\Finder::create()
    ->exclude(['bootstrap', 'node_modules', 'public', 'storage', 'vendor'])
    ->notPath('*')
    ->in(__DIR__);

return (new PhpCsFixer\Config())->setRules([
    '@PSR12' => true,
    '@PHP82Migration' => true,
    '@PhpCsFixer' => true,
    'array_syntax' => ['syntax' => 'short'],
    'no_blank_lines_after_class_opening' => false,
    'global_namespace_import' => ['import_classes' => true, 'import_constants' => false, 'import_functions' => false],
    'ordered_imports' => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'none'],
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
    'concat_space' => ['spacing' => 'one'],
    'blank_line_before_statement' => false,
    'ordered_class_elements' => false,
    'phpdoc_var_without_name' => false,
    'php_unit_test_class_requires_covers' => false,
    'php_unit_internal_class' => false,
    'no_superfluous_phpdoc_tags' => false,
    'phpdoc_no_empty_return' => false,
    'yoda_style' => false,
    'new_with_braces' => false,
    'phpdoc_align' => false,
    'phpdoc_types_order' => false,
    'function_declaration' => ['closure_function_spacing' => 'one', 'closure_fn_spacing' => 'one'],
    'increment_style' => false,
])
    ->setFinder($finder);
