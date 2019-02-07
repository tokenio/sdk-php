<?php

use Sami\Sami;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('Proto')
    ->in('./lib');

echo "@@@@ " . __DIR__.'/generated';
return new Sami($iterator, array(
    'build_dir' => __DIR__.'/generated'
));