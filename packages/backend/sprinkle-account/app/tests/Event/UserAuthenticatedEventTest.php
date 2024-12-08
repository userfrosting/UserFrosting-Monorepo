<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Event;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Event\UserAuthenticatedEvent;

/**
 * Tests UserAuthenticatedEvent
 */
class UserAuthenticatedEventTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testEvent(): void
    {
        $user = Mockery::mock(UserInterface::class);
        $event = new UserAuthenticatedEvent($user, 'email', 'foo', 'password');
        $this->assertEquals($user, $event->user);
        $this->assertSame('email', $event->getIdentityColumn());
        $this->assertSame('foo', $event->getIdentityValue());
        $this->assertSame('password', $event->getPassword());
    }
}
