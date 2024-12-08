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

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPUnit\Framework\TestCase;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\TestMailCommand;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * Test `webpack` command.
 *
 * Warning : This test doesn't fully test the output format.
 */
class TestMailCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCommand(): void
    {
        // Set mocks
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('address_book.admin.email', '')->once()->andReturn('example@example.com')
            ->shouldReceive('getString')->with('site.title')->times(2)->andReturn('userFrosting')
            ->shouldReceive('getArray')->with('address_book.admin', [])->once()->andReturn([
                'email' => 'admin@example.com',
                'name'  => 'Site Administrator'
            ])
            ->getMock();
        $mailer = Mockery::mock(Mailer::class)
            ->shouldReceive('send')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Config::class, $config);
        $ci->set(Mailer::class, $mailer);

        /** @var TestMailCommand */
        $command = $ci->get(TestMailCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Test email sent to example@example.com !', $result->getDisplay());
    }

    public function testCommandWithTo(): void
    {
        // Set mocks
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('getString')->with('address_book.admin.email')
            ->shouldReceive('getString')->with('site.title')->times(2)->andReturn('userFrosting')
            ->shouldReceive('getArray')->with('address_book.admin', [])->once()->andReturn([
                'email' => 'admin@example.com',
                'name'  => 'Site Administrator'
            ])
            ->getMock();
        $mailer = Mockery::mock(Mailer::class)
            ->shouldReceive('send')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Config::class, $config);
        $ci->set(Mailer::class, $mailer);

        /** @var TestMailCommand */
        $command = $ci->get(TestMailCommand::class);
        $result = BakeryTester::runCommand($command, ['--to' => 'foo@bar.com']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Test email sent to foo@bar.com !', $result->getDisplay());
    }

    public function testCommandWithFaillure(): void
    {
        // Set mocks
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('address_book.admin.email', '')->once()->andReturn('example@example.com')
            ->shouldReceive('getString')->with('site.title')->times(2)->andReturn('userFrosting')
            ->shouldReceive('getArray')->with('address_book.admin', [])->once()->andReturn([
                'email' => 'admin@example.com',
                'name'  => 'Site Administrator'
            ])
            ->getMock();
        $mailer = Mockery::mock(Mailer::class)
            ->shouldReceive('send')->andThrow(PHPMailerException::class)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Config::class, $config);
        $ci->set(Mailer::class, $mailer);

        /** @var TestMailCommand */
        $command = $ci->get(TestMailCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringNotContainsString('Test email sent to example@example.com !', $result->getDisplay());
    }
}
