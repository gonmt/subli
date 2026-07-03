<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/../../src',
        __DIR__ . '/../../core/src',
        __DIR__ . '/../../tests',
        __DIR__ . '/../../core/tests',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony'  => true,
        '@PER-CS2.0' => true,
        'declare_strict_types' => true,
    ])
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setFinder($finder);
