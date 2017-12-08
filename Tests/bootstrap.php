<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;

if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');
}

$autoload = require $autoloadFile;

include __DIR__.'/App/AppKernel.php';
$kernel = new AppKernel('test', true);
$kernel->boot();

$application  = new Application($kernel);

$kernel->shutdown();
