<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\ServicesProvider;

use DI\Container;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Log\AuthLoggerInterface;
use UserFrosting\Sprinkle\Account\ServicesProvider\LoggersService;
use UserFrosting\Sprinkle\Core\ServicesProvider\LoggersService as CoreLoggersService;
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
        $accountProvider = new LoggersService();
        $coreProvider = new CoreLoggersService();
        $definitions = array_merge($coreProvider->register(), $accountProvider->register());
        $this->ci = ContainerStub::create($definitions);

        // Set mock Config
        $locator = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('logs.path', 'logs://userfrosting.log')->once()->andReturn('logs://database.log')
            ->getMock();
        $this->ci->set(Config::class, $locator);
    }

    public function testAuthLoggerInterface(): void
    {
        $this->assertInstanceOf(LoggerInterface::class, $this->ci->get(AuthLoggerInterface::class)); // @phpstan-ignore-line
    }
}
