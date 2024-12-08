<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Support\Message;

use PHPUnit\Framework\TestCase;
use UserFrosting\Support\Message\UserMessage;

class UserMessageTest extends TestCase
{
    public function testUserMessage(): void
    {
        $message = new UserMessage('foo', ['bar']);
        $this->assertSame('foo', $message->message);
        $this->assertSame(['bar'], $message->parameters);
    }
}
