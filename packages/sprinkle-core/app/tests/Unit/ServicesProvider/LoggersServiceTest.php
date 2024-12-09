<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\ServicesProvider;

use DI\Container;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TestHandler;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Log\DebugLogger;
use UserFrosting\Sprinkle\Core\Log\DebugLoggerInterface;
use UserFrosting\Sprinkle\Core\Log\ErrorLogger;
use UserFrosting\Sprinkle\Core\Log\ErrorLoggerInterface;
use UserFrosting\Sprinkle\Core\Log\MailLogger;
use UserFrosting\Sprinkle\Core\Log\MailLoggerInterface;
use UserFrosting\Sprinkle\Core\Log\QueryLogger;
use UserFrosting\Sprinkle\Core\Log\QueryLoggerInterface;
use UserFrosting\Sprinkle\Core\ServicesProvider\LoggersService;
use UserFrosting\Testing\ContainerStub;

/**
 * Mock tests for Loggers service.
 * Check to see if service returns what it's supposed to return
 */
class LoggersServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected Container $ci;

    public function setUp(): void
    {
        parent::setUp();

        // Create container with provider to test
        $provider = new LoggersService();
        $this->ci = ContainerStub::create($provider->register());
    }

    /**
     * N.B.: This test make sure the service is created, but it doesn't check
     * it's created correctly and monolog can be called.
     *
     * @param class-string $interface
     * @param class-string $class
     *
     * @dataProvider loggerProvider
     */
    public function testLoggerCreation(string $interface, string $class): void
    {
        // Set mock Config
        $locator = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('logs.path', 'logs://userfrosting.log')->once()->andReturn('logs://database.log')
            ->getMock();
        $this->ci->set(Config::class, $locator);

        $object = $this->ci->get($interface);
        $this->assertInstanceOf($class, $object);
        $this->assertInstanceOf(LoggerInterface::class, $object);
        $this->assertInstanceOf($interface, $object);
    }

    /**
     * N.B.: This test make sure Monolog StreamHandler is called, but doesn't
     * necessary check it's called correctly.
     *
     * @param class-string $interface
     * @param class-string $class
     *
     * @dataProvider loggerProvider
     */
    public function testLogger(string $interface, string $class): void
    {
        // Use test handler instead of StreamHandler
        $handler = new TestHandler();

        /** @var LoggerInterface */
        $object = new $class($handler);

        // Add two test records
        $object->log(0, 'Test log', ['bar' => 'foo']);
        $object->debug('Test debug log', ['foo' => 'bar']);

        // Get records
        $records = $handler->getRecords();
        $this->assertCount(2, $records);
        $this->assertSame('Test log', $records[0]['message']);
        $this->assertSame(600, $records[0]['level']);
        $this->assertSame('Test debug log', $records[1]['message']);
        $this->assertSame(100, $records[1]['level']);
    }

    /**
     * @return array<class-string>[]
     */
    public static function loggerProvider(): array
    {
        return [
            [DebugLoggerInterface::class, DebugLogger::class],
            [ErrorLoggerInterface::class, ErrorLogger::class],
            [MailLoggerInterface::class, MailLogger::class],
            [QueryLoggerInterface::class, QueryLogger::class],
        ];
    }
}
