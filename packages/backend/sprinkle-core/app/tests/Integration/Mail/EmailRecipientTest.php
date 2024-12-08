<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Mail;

use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;

/**
 * StaticMailMessageTest
 */
class EmailRecipientTest extends TestCase
{
    public function testEmailRecipient(): void
    {
        $recipient = new EmailRecipient('email@test.com', 'Name');

        $this->assertSame('email@test.com', $recipient->getEmail());
        $this->assertSame('Name', $recipient->getName());
        $this->assertSame([], $recipient->getParams());

        // cc
        $this->assertSame([], $recipient->getCCs());
        $this->assertSame([
            [
                'email' => 'foo@foo.com',
                'name'  => 'foo',
            ]
        ], $recipient->cc('foo@foo.com', 'foo')->getCCs());

        // bcc
        $this->assertSame([], $recipient->getBCCs());
        $this->assertSame([
            [
                'email' => 'bar@bar.com',
                'name'  => '',
            ]
        ], $recipient->bcc('bar@bar.com')->getBCCs());
    }
}
