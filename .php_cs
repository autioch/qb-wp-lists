<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setUsingCache(false)
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'braces' => false,
        'class_keyword_remove' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'one'],
        'dir_constant' => true,
        'ereg_to_preg' => true,
        'full_opening_tag' => true,
        'linebreak_after_opening_tag' => true,
        'mb_str_functions' => true,
        'native_function_invocation' => false,
        'no_multiline_whitespace_before_semicolons' => true,
        'no_php4_constructor' => true,
        'no_short_echo_tag' => true,
        'no_useless_return' => true,
        'not_operator_with_space' => false,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'protected_to_private' => true,
        'psr0' => true,
        'psr4' => true,
        // 'semicolon_after_instruction' => true,
        'simplified_null_return' => true,
    ])
    ->setFinder($finder);
