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

use PHPUnit\Framework\TestCase;
use UserFrosting\I18n\PluralRules\RuleInterface;

abstract class RuleBase extends TestCase
{
    /**
     * @var string Rule number to test. Reference to instance of \UserFrosting\I18n\PluralRules\RuleInterface
     **/
    protected string $ruleToTest;

    /**
     * Test rule class implement the right interface.
     */
    public function testRuleClass(): void
    {
        $this->assertInstanceOf(RuleInterface::class, new $this->ruleToTest());
    }

    /**
     * @dataProvider ruleProvider
     *
     * @param int $number         Input number
     * @param int $expectedResult Expected result
     */
    public function testRule(int $number, int $expectedResult): void
    {
        $rule = $this->ruleToTest;
        $result = $rule::getRule($number);
        $this->assertSame($expectedResult, $result);
    }

    /**
     * Data provider for `testRule`.
     *
     * @return array<int, array<int, int>>
     */
    abstract public static function ruleProvider(): array;
}
