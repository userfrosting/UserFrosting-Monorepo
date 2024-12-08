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

use UserFrosting\I18n\PluralRules\Rule14;

class Rule14Test extends RuleBase
{
    protected string $ruleToTest = Rule14::class;

    /**
     * Families: Slavic (Macedonian)
     * 1 - ends in 1: 1, 11, 21, ...
     * 2 - ends in 2: 2, 12, 22, ...
     * 3 - everything else: 0, 3, 4, ... 10, 13, 14, ... 20, 23, ...
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
    {
        return [
            [0, 3],
            [1, 1],
            [2, 2],
            [3, 3],
            [11, 1],
            [12, 2],
            [13, 3],
            [19, 3],
            [20, 3],
            [21, 1],
            [40, 3],
            [100, 3],
            [101, 1],
            [102, 2],
            [103, 3],
            [109, 3],
            [110, 3],
            [111, 1],
            [112, 2],
            [120, 3],
            [121, 1],
            [122, 2],
            [123, 3],
            [124, 3],
            [125, 3],
            [200, 3],
        ];
    }
}
