<?php

/**
 * List of all packages to analyze
 */
$packages = [
    'packages/framework',
    'packages/skeleton/app',
    'packages/sprinkle-account/app',
    'packages/sprinkle-admin/app',
    'packages/sprinkle-core/app',
];

/**
 * Header Config
 */
// $header = 'UserFrosting Framework (http://www.userfrosting.com)

// @link      https://github.com/userfrosting/framework
// @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
// @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)';

/**
 * Rules
 */
$rules = [
    '@PSR2'                                       => true,
    'array_indentation'                           => true,
    'array_syntax'                                => ['syntax' => 'short'],
    'binary_operator_spaces'                      => ['operators' => ['=>' => 'align', '=' => 'single_space']],
    'blank_line_after_namespace'                  => true,
    'blank_line_after_opening_tag'                => true,
    'blank_line_before_statement'                 => ['statements' => ['return']],
    'braces'                                      => true,
    'cast_spaces'                                 => true,
    'class_definition'                            => true,
    'concat_space'                                => ['spacing' => 'one'],
    'declare_equal_normalize'                     => true,
    'elseif'                                      => true,
    'encoding'                                    => true,
    'full_opening_tag'                            => true,
    'function_declaration'                        => true,
    'function_typehint_space'                     => true,
    'single_line_comment_style'                   => ['comment_types' => ['hash']],
    'heredoc_to_nowdoc'                           => true,
    'include'                                     => true,
    'indentation_type'                            => true,
    'line_ending'                                 => true,
    'lowercase_cast'                              => true,
    'constant_case'                               => ['case' => 'lower'],
    'lowercase_keywords'                          => true,
    'method_argument_space'                       => true,
    'multiline_whitespace_before_semicolons'      => true,
    'native_function_casing'                      => true,
    'new_with_braces'                             => true,
    'no_blank_lines_after_class_opening'          => true,
    'no_blank_lines_after_phpdoc'                 => true,
    'no_break_comment'                            => true,
    'no_closing_tag'                              => true,
    'no_empty_phpdoc'                             => true,
    'no_empty_statement'                          => true,
    'no_extra_blank_lines'                        => true,
    'no_leading_import_slash'                     => true,
    'no_leading_namespace_whitespace'             => true,
    'no_mixed_echo_print'                         => ['use' => 'echo'],
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_short_bool_cast'                          => true,
    'no_singleline_whitespace_before_semicolons'  => true,
    'no_spaces_after_function_name'               => true,
    'no_spaces_around_offset'                     => true,
    'no_spaces_inside_parenthesis'                => true,
    'no_trailing_comma_in_list_call'              => true,
    'no_trailing_comma_in_singleline_array'       => true,
    'no_trailing_whitespace'                      => true,
    'no_trailing_whitespace_in_comment'           => true,
    'no_unneeded_control_parentheses'             => true,
    'no_unreachable_default_argument_value'       => true,
    'no_unused_imports'                           => true,
    'no_useless_return'                           => true,
    'no_whitespace_before_comma_in_array'         => true,
    'no_whitespace_in_blank_line'                 => true,
    'normalize_index_brace'                       => true,
    'object_operator_without_whitespace'          => true,
    'ordered_imports'                             => ['sort_algorithm' => 'alpha'],
    'phpdoc_align'                                => true,
    'phpdoc_indent'                               => true,
    'general_phpdoc_tag_rename'                   => true,
    'phpdoc_inline_tag_normalizer'                => true,
    'phpdoc_tag_type'                             => ['tags' => ['inheritdoc' => 'inline']],
    'phpdoc_no_empty_return'                      => true,
    'phpdoc_no_access'                            => true,
    'phpdoc_no_package'                           => true,
    'phpdoc_order'                                => true,
    'phpdoc_scalar'                               => true,
    'phpdoc_single_line_var_spacing'              => true,
    'phpdoc_trim'                                 => true,
    'phpdoc_types'                                => true,
    'psr_autoloading'                             => true,
    'short_scalar_cast'                           => true,
    'simplified_null_return'                      => true,
    'single_blank_line_at_eof'                    => true,
    'single_blank_line_before_namespace'          => true,
    'single_class_element_per_statement'          => true,
    'single_import_per_statement'                 => true,
    'single_line_after_imports'                   => true,
    'single_quote'                                => true,
    'space_after_semicolon'                       => true,
    'standardize_not_equals'                      => true,
    'switch_case_semicolon_to_colon'              => true,
    'switch_case_space'                           => true,
    'ternary_operator_spaces'                     => true,
    'trim_array_spaces'                           => true,
    'unary_operator_spaces'                       => true,
    'visibility_required'                         => true,
    'whitespace_after_comma_in_array'             => true,

    // 'header_comment' => [
    //     'header'       => $header,
    // ]
];

$folders = [];
foreach ($packages as $package) {
    $folders[] = __DIR__ . '/' . $package . '/src';
    $folders[] = __DIR__ . '/' . $package . '/tests';
}

$finder = PhpCsFixer\Finder::create()
    ->in($folders);

$config = new PhpCsFixer\Config();
return $config->setRules($rules)
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setFinder($finder)
    ->setUsingCache(true)
    ->setRiskyAllowed(true);
