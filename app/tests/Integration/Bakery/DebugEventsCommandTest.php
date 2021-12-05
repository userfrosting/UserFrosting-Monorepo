<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Bakery;

use UserFrosting\Sprinkle\Core\Bakery\DebugEventsCommand;
use UserFrosting\Sprinkle\Core\Bakery\DebugLocatorCommand;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase;
use UserFrosting\Testing\BakeryTester;

/**
 * Test DebugLocatorCommand
 *
 * Warning: As with most bakery command testing, this test make sure all code
 * is executed and doesn't throw errors, but the actual display is not tested.
 */
class DebugEventsCommandTest extends CoreTestCase
{
    public function testCommand(): void
    {
        $command = $this->ci->get(DebugEventsCommand::class);
        $result = BakeryTester::runCommand($command);
        $this->assertSame(0, $result->getStatusCode());
    }
}
