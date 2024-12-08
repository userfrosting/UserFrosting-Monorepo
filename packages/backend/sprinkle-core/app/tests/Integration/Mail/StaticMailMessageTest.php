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

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Mail\EmailRecipient;
use UserFrosting\Sprinkle\Core\Mail\StaticMailMessage;

/**
 * StaticMailMessageTest
 */
class StaticMailMessageTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testStaticMessage(): void
    {
        $message = new StaticMailMessage('subject', 'body');
        $this->assertSame('subject', $message->renderSubject());
        $this->assertSame('body', $message->renderBody());

        $message->setSubject('My Subject')->setBody('My Body');

        $this->assertSame('My Subject', $message->renderSubject());
        $this->assertSame('My Body', $message->renderBody());
    }

    public function testAbstractMessage(): void
    {
        $message = new StaticMailMessage();
        $emailRecipient = Mockery::mock(EmailRecipient::class);

        // recipients
        $this->assertSame([], $message->getRecipients());
        $this->assertSame([$emailRecipient], $message->addEmailRecipient($emailRecipient)->getRecipients());
        $this->assertSame([], $message->clearRecipients()->getRecipients());

        // FromEmail
        $email = 'foo@bar.com';
        $this->assertSame('', $message->getFromEmail());
        $this->assertSame($email, $message->setFromEmail($email)->getFromEmail());

        // FromName
        $this->assertSame($email, $message->getFromName());
        $this->assertSame('From Name', $message->setFromName('From Name')->getFromName());

        // replyEmail
        $this->assertSame($email, $message->getReplyEmail());
        $this->assertSame('bar@foo.com', $message->setReplyEmail('bar@foo.com')->getReplyEmail());

        // replyName
        $this->assertSame('From Name', $message->getReplyName());
        $this->assertSame('Reply Name', $message->setReplyName('Reply Name')->getReplyName());

        // from
        $message->from([]); // Null all data
        $this->assertSame('', $message->getFromEmail());
        $this->assertSame('', $message->getFromName());
        $this->assertSame('', $message->getReplyEmail());
        $this->assertSame('', $message->getReplyName());

        // Apply real data
        $message->from([
            'email'       => 'email@test.com',
            'name'        => 'Test name',
            'reply_email' => 'replay@test.com',
            'reply_name'  => 'Test Reply',
            'foo'         => 'bar',
        ]);
        $this->assertSame('email@test.com', $message->getFromEmail());
        $this->assertSame('Test name', $message->getFromName());
        $this->assertSame('replay@test.com', $message->getReplyEmail());
        $this->assertSame('Test Reply', $message->getReplyName());
    }
}
