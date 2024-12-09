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

use UserFrosting\I18n\PluralRules\Rule7;

class Rule7Test extends RuleBase
{
    protected string $ruleToTest = Rule7::class;

    /**
     * Families: Slavic (Croatian, Serbian, Russian, Ukrainian)
     * 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ...
     * 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ...
     * 3 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25, 26, ...
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
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
            [21, 1],
            [40, 3],
            [100, 3],
            [101, 1],
            [110, 3],
            [111, 3],
            [120, 3],
            [121, 1],
            [122, 2],
            [123, 2],
            [124, 2],
            [125, 3],
        ];
    }
}
