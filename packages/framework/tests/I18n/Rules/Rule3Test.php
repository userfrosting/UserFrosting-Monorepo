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

use UserFrosting\I18n\PluralRules\Rule3;

class Rule3Test extends RuleBase
{
    protected string $ruleToTest = Rule3::class;

    /**
     * Families: Baltic (Latvian)
     * 1 - 0
     * 2 - ends in 1, not 11: 1, 21, ... 101, 121, ...
     * 3 - everything else: 2, 3, ... 10, 11, 12, ... 20, 22, ...
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
    {
        return [
            [0, 1],
            [1, 2],
            [2, 3],
            [11, 3],
            [21, 2],
            [141, 2],
            [128, 3],
        ];
    }
}
