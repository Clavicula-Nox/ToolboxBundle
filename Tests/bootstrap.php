<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Filesystem\Filesystem;

if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

$autoload = require $autoloadFile;

$fs = new Filesystem();

// Remove build dir files
if (is_dir(__DIR__.'/../build')) {
    echo "Removing files in the build directory.\n".__DIR__."\n";

    try {
        $fs->remove(__DIR__.'/../build');
    } catch (Exception $e) {
        fwrite(STDERR, $e->getMessage());
        system('rm -rf '.__DIR__.'/../build');
    }
}

$fs->mkdir(__DIR__.'/../build');

include __DIR__.'/App/AppKernel.php';
$kernel = new AppKernel('test', true);
$kernel->boot();

$application  = new Application($kernel);

$kernel->shutdown();
