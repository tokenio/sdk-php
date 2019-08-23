<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Proto')
    ->in('./lib');

return new Sami($iterator, array(
    'build_dir' => __DIR__.'/generated'
));