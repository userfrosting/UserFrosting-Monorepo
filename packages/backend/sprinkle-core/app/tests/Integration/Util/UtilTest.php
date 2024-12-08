<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Util;

use UserFrosting\Sprinkle\Core\Tests\CoreTestCase;
use UserFrosting\Sprinkle\Core\Util\Util;

class UtilTest extends CoreTestCase
{
    public function testExtractFields(): void
    {
        $input = ['red' => true, 'blue' => false];
        $field = ['red'];

        $result = Util::extractFields($input, $field, false);
        $this->assertSame(['red' => true], $result);

        // Check input wasn't changed
        $this->assertSame(['red' => true, 'blue' => false], $input);
    }

    public function testExtractFieldsWithRemove(): void
    {
        $input = ['red' => true, 'blue' => false];
        $field = ['red'];

        $result = Util::extractFields($input, $field, true);
        $this->assertSame(['red' => true], $result);

        // Check input was changed
        $this->assertSame(['blue' => false], $input);
    }

    public function testExtractDigits(): void
    {
        $result = Util::extractDigits('Phone : 123-456-7890');
        $this->assertSame('1234567890', $result);
    }

    public function testFormatPhoneNumber(): void
    {
        // 10 digits
        $result = Util::formatPhoneNumber('1234567890');
        $this->assertSame('(123) 456-7890', $result);

        // 7 digits
        $result = Util::formatPhoneNumber('1234567');
        $this->assertSame('123-4567', $result);

        // Other length
        $result = Util::formatPhoneNumber('123456789');
        $this->assertSame('123456789', $result);
    }

    public function testPrettyPrintArray(): void
    {
        /**
         * {
         *   "red": true,
         *   "blue": false
         * }
         */
        $result = Util::prettyPrintArray(['red' => true, 'blue' => false]);
        $this->assertSame('{<br>&nbsp;&nbsp;"red": true,<br>&nbsp;&nbsp;"blue": false<br>}', $result);

        $result = Util::prettyPrintArray(['Bar "the real" truth']); // Test escape
        $this->assertSame('[<br>&nbsp;&nbsp;"Bar \"the real\" truth"<br>]', $result);
    }

    public function testRandomPhrase(): void
    {
        $result = Util::randomPhrase(2);
        $this->assertNotSame('', $result);
        $this->assertStringContainsString('-', $result);
    }

    public function testRandomPhraseEmptyResult(): void
    {
        // Use impossible param :)
        $result = Util::randomPhrase(4, 1);
        $this->assertSame('', $result);
    }
}
