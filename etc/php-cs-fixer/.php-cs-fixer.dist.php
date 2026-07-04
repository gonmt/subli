<?php

// ponytail: excludes files using PHP 8.4 asymmetric visibility — CS Fixer 3.x doesn't support private(set) syntax yet
$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/../../src',
        __DIR__ . '/../../core/src',
        __DIR__ . '/../../tests',
        __DIR__ . '/../../core/tests',
    ])
    ->notPath('#/Domain/[^/]+\.php$#');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PER-CS2.0' => true,
        'declare_strict_types' => true,
    ])
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setFinder($finder);
