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

use UserFrosting\I18n\PluralRules\Rule12;

class Rule12Test extends RuleBase
{
    protected string $ruleToTest = Rule12::class;

    /**
     * Families: Semitic (Arabic).
     *
     * 1 - 1
     * 2 - 2
     * 3 - ends in 03-10: 3, 4, ... 10, 103, 104, ... 110, 203, 204, ...
     * 4 - ends in 11-99: 11, ... 99, 111, 112, ...
     * 5 - everything else: 100, 101, 102, 200, 201, 202, ...
     * 6 - 0
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
    {
        return [
            [0, 6],
            [1, 1],
            [2, 2],
            [3, 3],
            [11, 4],
            [12, 4],
            [13, 4],
            [19, 4],
            [20, 4],
            [21, 4],
            [40, 4],
            [100, 5],
            [101, 5],
            [102, 5],
            [103, 3],
            [109, 3],
            [110, 3],
            [111, 4],
            [112, 4],
            [120, 4],
            [121, 4],
            [122, 4],
            [123, 4],
            [124, 4],
            [125, 4],
            [200, 5],
        ];
    }
}
