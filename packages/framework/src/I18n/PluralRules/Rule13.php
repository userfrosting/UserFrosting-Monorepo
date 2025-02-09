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
 * Families: Semitic (Maltese)
 * 1 - 1
 * 2 - is 0 or ends in 01-10: 0, 2, 3, ... 9, 10, 101, 102, ...
 * 3 - ends in 11-19: 11, 12, ... 18, 19, 111, 112, ...
 * 4 - everything else: 20, 21, ...
 *
 * @see https://developer.mozilla.org/en-US/docs/Mozilla/Localization/Localization_and_Plurals#Plural_rule_13_(4_forms)
 */
final class Rule13 implements RuleInterface
{
    public static function selectPluralForm(int $number): int
    {
        if ($number === 1) {
            return 1;
        }

        if ($number === 0 || (($number % 100 >= 1) && ($number % 100 < 11))) {
            return 2;
        }

        if (($number % 100 > 10) && ($number % 100 < 20)) {
            return 3;
        }

        return 4;
    }
}
