<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\DowngradeSetList;
use Rector\Core\ValueObject\PhpVersion;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
    ]);

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
       // DowngradeSetList::PHP_80,
       // DowngradeSetList::PHP_74,
       // DowngradeSetList::PHP_73,
        //DowngradeSetList::PHP_72,
    ]);

    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_71);
};
