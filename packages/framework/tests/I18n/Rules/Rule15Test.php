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

use UserFrosting\I18n\PluralRules\Rule15;

class Rule15Test extends RuleBase
{
    protected string $ruleToTest = Rule15::class;

    /**
     * Families: Icelandic
     * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, 131, ...
     * 2 - everything else: 0, 2, 3, ... 10, 11, 12, ... 20, 22, ...
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
            [20, 2],
            [21, 1],
            [40, 2],
            [100, 2],
            [101, 1],
            [102, 2],
            [103, 2],
            [109, 2],
            [110, 2],
            [111, 2],
            [112, 2],
            [120, 2],
            [121, 1],
            [122, 2],
            [123, 2],
            [124, 2],
            [125, 2],
            [200, 2],
        ];
    }
}
