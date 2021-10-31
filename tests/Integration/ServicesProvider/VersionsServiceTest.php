<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\ServicesProvider;

use UserFrosting\Sprinkle\Core\Tests\CoreTestCase as TestCase;
use UserFrosting\Sprinkle\Core\Validators\NodeVersionValidator;
use UserFrosting\Sprinkle\Core\Validators\NpmVersionValidator;
use UserFrosting\Sprinkle\Core\Validators\PhpDeprecationValidator;
use UserFrosting\Sprinkle\Core\Validators\PhpVersionValidator;

/**
 * Test service implementation.
 */
class VersionsServiceTest extends TestCase
{
    public function testService(): void
    {
        $this->assertIsString($this->ci->get('PHP_MIN_VERSION'));
        $this->assertIsString($this->ci->get('PHP_RECOMMENDED_VERSION'));
        $this->assertIsString($this->ci->get('NODE_MIN_VERSION'));
        $this->assertIsString($this->ci->get('NPM_MIN_VERSION'));

        $this->assertIsString($this->ci->get('PHP_VERSION'));
        $this->assertIsString($this->ci->get('NODE_VERSION'));
        $this->assertIsString($this->ci->get('NPM_VERSION'));

        $this->assertInstanceOf(PhpVersionValidator::class, $this->ci->get(PhpVersionValidator::class));
        $this->assertInstanceOf(PhpDeprecationValidator::class, $this->ci->get(PhpDeprecationValidator::class));
        $this->assertInstanceOf(NodeVersionValidator::class, $this->ci->get(NodeVersionValidator::class));
        $this->assertInstanceOf(NpmVersionValidator::class, $this->ci->get(NpmVersionValidator::class));
    }
}
