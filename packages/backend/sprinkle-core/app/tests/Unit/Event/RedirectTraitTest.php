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
use UserFrosting\Sprinkle\Core\Event\Contract\RedirectingEventInterface;
use UserFrosting\Sprinkle\Core\Event\Helper\RedirectTrait;

/**
 * Test RedirectTrait
 */
class RedirectTraitTest extends TestCase
{
    public function testTrait(): void
    {
        $event = new RedirectedEvent();

        $this->assertNull($event->getRedirect());
        $event->setRedirect('/home');
        $this->assertSame('/home', $event->getRedirect());
    }
}

class RedirectedEvent implements RedirectingEventInterface
{
    use RedirectTrait;
}
