<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $coreSrc = realpath(__DIR__ . '/../../core/src') . '/';

    $types = [];
    foreach (glob($coreSrc . '*/Infrastructure/Persistence/Doctrine/Type/*Type.php') ?: [] as $file) {
        $class = 'Core\\' . str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($coreSrc)));
        $types[$class::NAME] = $class;
    }

    $mappings = [];
    foreach (glob($coreSrc . '*/Infrastructure/Persistence/Doctrine/Mapping', GLOB_ONLYDIR) ?: [] as $dir) {
        preg_match('|/(\w+)/Infrastructure/|', $dir, $m);
        $module = $m[1];
        $mappings["Core{$module}"] = [
            'type' => 'xml',
            'dir' => $dir,
            'prefix' => "Core\\{$module}\\Domain",
            'is_bundle' => false,
        ];
    }

    $container->extension('doctrine', [
        'dbal' => ['types' => $types],
        'orm' => ['mappings' => $mappings],
    ]);
};
