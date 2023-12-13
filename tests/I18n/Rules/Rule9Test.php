<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2021 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\I18n\Rules;

class Rule9Test extends RuleBase
{
    protected $ruleToTest = "\UserFrosting\I18n\PluralRules\Rule9";

    /**
     * Families: Slavic (Polish)
     * 1 - 1
     * 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ... 104, 122, ...
     * 3 - everything else: 0, 5, 6, ... 11, 12, 13, 14, 15, ... 20, 21, 25, ...
     */
    public static function ruleProvider()
    {
        return [
            [0, 3],
            [1, 1],
            [2, 2],
            [3, 2],
            [11, 3],
            [12, 3],
            [13, 3],
            [19, 3],
            [20, 3],
            [21, 3],
            [40, 3],
            [100, 3],
            [101, 3],
            [120, 3],
            [121, 3],
            [122, 2],
            [123, 2],
            [124, 2],
            [125, 3],
        ];
    }
}
