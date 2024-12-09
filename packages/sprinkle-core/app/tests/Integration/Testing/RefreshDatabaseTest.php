<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Testing;

use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class RefreshDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function testMissingContainer(): void
    {
        $this->expectExceptionMessage('CI/Container not available. Make sure you extend the correct TestCase');
        $this->refreshDatabase();
    }
}
