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
use Slim\Views\Twig;
use UserFrosting\Sprinkle\Core\Mail\TwigMailMessage;

/**
 * StaticMailMessageTest
 */
class TwigMailMessageTest extends TestCase
{
    public function testTwigMessage(): void
    {
        $twig = Twig::create(__DIR__);
        $message = new TwigMailMessage($twig, 'test.html.twig');

        $this->assertSame('Test email subject', $message->renderSubject());
        $this->assertSame('Test email body', $message->renderBody());
    }

    public function testTwigMessageSetGeTemplate(): void
    {
        $twig = Twig::create(__DIR__);
        $message = new TwigMailMessage($twig, '');

        $this->assertSame('', $message->getTemplate());
        $this->assertSame('test.html.twig', $message->setTemplate('test.html.twig')->getTemplate());
        $this->assertSame('Test email subject', $message->renderSubject());
        $this->assertSame('Test email body', $message->renderBody());
    }

    public function testTwigMessageWihCustomParam(): void
    {
        $twig = Twig::create(__DIR__);
        $message = new TwigMailMessage($twig, 'test.html.twig');

        $data = ['foo' => ' 123', 'bar' => ' 321'];
        $this->assertSame('Test email subject 123', $message->renderSubject($data));
        $this->assertSame('Test email body 321', $message->renderBody($data));
    }

    public function testTwigMessageWihGlobalCustomParam(): void
    {
        $twig = Twig::create(__DIR__);
        $message = new TwigMailMessage($twig, 'test.html.twig');

        $data = ['foo' => ' 123', 'bar' => ' 321'];
        $message->addParams($data);
        $this->assertSame('Test email subject 123', $message->renderSubject());
        $this->assertSame('Test email body 321', $message->renderBody());
    }
}
