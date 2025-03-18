<?php

use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/database',
    ])
    ->exclude([
        __DIR__ . 'tests/Feature/Auth',
        __DIR__ . '/config'
    ]);

$rules = [
    '@Symfony' => true,

    'single_line_empty_body' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one',
        ],
    ],
    'braces_position' => [
        'control_structures_opening_brace' => 'same_line',
        'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
        'anonymous_functions_opening_brace' => 'same_line',
        'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        'anonymous_classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        'allow_single_line_empty_anonymous_classes' => true,
        'allow_single_line_anonymous_functions' => false,
    ],
    'explicit_string_variable' => true,
    'global_namespace_import' => [
        'import_classes' => true,
        'import_constants' => true,
        'import_functions' => true,
    ],
    'new_with_parentheses' => [
        'named_class' => false,
        'anonymous_class' => false,
    ],
    'ordered_imports' => [
        'sort_algorithm' => 'alpha',
        'imports_order' => [
            'const',
            'class',
            'function',
        ],
    ],
    'simple_to_complex_string_variable' => true,
    'attribute_empty_parentheses' => [
        'use_parentheses' => false,
    ],
    'phpdoc_order' => [
        'order' => ['property', 'method', 'param', 'return', 'throws', 'mixin'],
    ],
    'trailing_comma_in_multiline' => ['after_heredoc' => true, 'elements' => ['array_destructuring', 'arrays', 'match', 'parameters']],
];

return (new PhpCsFixer\Config)
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules($rules)
    ->setFinder($finder);
