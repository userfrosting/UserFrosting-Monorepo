<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Bakery;

use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Bakery\Event\AbstractAggregateCommandEvent;

class AbstractAggregateCommandEventTest extends TestCase
{
    public function testBaseCommand(): void
    {
        $event = new StubCommandEvent(['foo', 'bar']);
        $this->assertSame(['foo', 'bar'], $event->getCommands());

        $event->setCommands([]);
        $this->assertSame([], $event->getCommands());

        $event->addCommand('foo');
        $this->assertSame(['foo'], $event->getCommands());

        $event->prependCommand('bar');
        $this->assertSame(['bar', 'foo'], $event->getCommands());

        $event->addCommands(['foobar', '123']);
        $this->assertSame(['bar', 'foo', 'foobar', '123'], $event->getCommands());

        $event->prependCommands(['owl', 'egg']);
        $this->assertSame(['owl', 'egg', 'bar', 'foo', 'foobar', '123'], $event->getCommands());
    }
}

class StubCommandEvent extends AbstractAggregateCommandEvent
{
}
