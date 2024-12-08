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

use UserFrosting\I18n\PluralRules\Rule8;

class Rule8Test extends RuleBase
{
    protected string $ruleToTest = Rule8::class;

    /**
     * Families: Slavic (Slovak, Czech)
     * 1 - 1
     * 2 - 2, 3, 4
     * 3 - everything else: 0, 5, 6, 7, ...
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
            [4, 2],
            [5, 3],
            [11, 3],
            [12, 3],
            [13, 3],
            [19, 3],
            [20, 3],
            [21, 3],
            [40, 3],
            [100, 3],
            [101, 3],
            [110, 3],
            [111, 3],
            [128, 3],
        ];
    }
}
