<?php

$finder = new PhpCsFixer\Finder()
    ->in(__DIR__)
    ->exclude('var');

return new PhpCsFixer\Config()
    ->setRules([
        '@PER-CS2.0' => true,
        'not_operator_with_successor_space' => true,
        'binary_operator_spaces' => true,
        'phpdoc_align' => [
            'align' => 'left'
        ],
        'yoda_style' => true,
    ])
    ->setFinder($finder);

