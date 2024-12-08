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

use UserFrosting\I18n\PluralRules\Rule13;

class Rule13Test extends RuleBase
{
    protected string $ruleToTest = Rule13::class;

    /**
     * Families: Semitic (Maltese)
     * 1 - 1
     * 2 - is 0 or ends in 01-10: 0, 2, 3, ... 9, 10, 101, 102, ...
     * 3 - ends in 11-19: 11, 12, ... 18, 19, 111, 112, ...
     * 4 - everything else: 20, 21, ...
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
            [11, 3],
            [12, 3],
            [13, 3],
            [19, 3],
            [20, 4],
            [21, 4],
            [40, 4],
            [100, 4],
            [101, 2],
            [102, 2],
            [103, 2],
            [109, 2],
            [110, 2],
            [111, 3],
            [112, 3],
            [120, 4],
            [121, 4],
            [122, 4],
            [123, 4],
            [124, 4],
            [125, 4],
            [200, 4],
            [201, 2],
            [202, 2],
        ];
    }
}
