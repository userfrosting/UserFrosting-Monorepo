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

use UserFrosting\I18n\PluralRules\Rule5;

class Rule5Test extends RuleBase
{
    protected string $ruleToTest = Rule5::class;

    /**
     * Families: Romanic (Romanian)
     * 1 - 1
     * 2 - is 0 or ends in 01-19: 0, 2, 3, ... 19, 101, 102, ... 119, 201, ...
     * 3 - everything else: 20, 21, ...
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
    {
        return [
            [0, 2],
            [1, 1],
            [2, 2],
            [3, 2],
            [11, 2],
            [12, 2],
            [13, 2],
            [19, 2],
            [20, 3],
            [21, 3],
            [100, 3],
            [101, 2],
            [110, 2],
            [111, 2],
            [128, 3],
        ];
    }
}
