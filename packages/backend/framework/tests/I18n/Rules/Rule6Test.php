<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\I18n\Rules;

use UserFrosting\I18n\PluralRules\Rule6;

class Rule6Test extends RuleBase
{
    protected string $ruleToTest = Rule6::class;

    /**
     * Families: Baltic (Lithuanian)
     * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ...
     * 2 - ends in 0 or ends in 10-20: 0, 10, 11, 12, ... 19, 20, 30, 40, ...
     * 3 - everything else: 2, 3, ... 8, 9, 22, 23, ... 29, 32, 33, ...
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
    {
        return [
            [0, 2],
            [1, 1],
            [2, 3],
            [3, 3],
            [11, 2],
            [12, 2],
            [13, 2],
            [19, 2],
            [20, 2],
            [21, 1],
            [40, 2],
            [100, 2],
            [101, 1],
            [110, 2],
            [111, 2],
            [128, 3],
        ];
    }
}
