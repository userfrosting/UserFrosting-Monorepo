<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\ServicesProvider;

use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\StoppableEventInterface;
use UserFrosting\Sprinkle\Core\Event\Helper\StoppableTrait;

/**
 * Test StoppableTrait
 */
class StoppableTraitTest extends TestCase
{
    public function testTrait(): void
    {
        $event = new StoppableEvent();

        $this->assertFalse($event->isPropagationStopped());
        $event->stop();
        $this->assertTrue($event->isPropagationStopped());
    }
}

class StoppableEvent implements StoppableEventInterface
{
    use StoppableTrait;
}
