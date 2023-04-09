<?php

$finder = PhpCsFixer\Finder::create()
//    ->exclude('somedir')
//    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
//    ->in(__DIR__ . 'app/Ship')
    ->in(__DIR__ . '/app/Containers/Admin');

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
//    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
    'no_blank_lines_after_class_opening' => false,
])
    ->setFinder($finder);
