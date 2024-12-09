<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\I18n\PluralRules;

/**
 * Interface for Rule Definition.
 *
 * The plural rules are based on a list published by the Mozilla Developer Network & code from phpBB Group
 *
 * @see https://developer.mozilla.org/en-US/docs/Mozilla/Localization/Localization_and_Plurals
 */
interface RuleInterface
{
    /**
     * Return the rule to apply.
     *
     * @param int $number The number we want the rule for
     *
     * @return int The rule
     */
    public static function getRule(int $number): int;
}
