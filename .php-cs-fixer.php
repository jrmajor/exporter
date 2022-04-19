<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->ignoreVCS(true);

return Major\CS\config($finder, [
    'ordered_class_elements' => false,
])->setCacheFile('.cache/.php-cs-fixer.cache');
