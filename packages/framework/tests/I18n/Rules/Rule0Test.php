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

use UserFrosting\I18n\PluralRules\Rule0;

class Rule0Test extends RuleBase
{
    protected string $ruleToTest = Rule0::class;

    /**
     * Families: Asian (Chinese, Japanese, Korean, Vietnamese), Persian, Turkic/Altaic (Turkish), Thai, Lao
     * 1 - everything: 0, 1, 2, ...
     *
     * {@inheritDoc}
     */
    public static function ruleProvider(): array
    {
        return [
            [0, 1],
            [1, 1],
            [2, 1],
            [-2, 1],
            [128, 1],
        ];
    }
}
