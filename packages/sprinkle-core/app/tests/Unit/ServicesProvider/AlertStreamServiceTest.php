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
use Illuminate\Cache\Repository as Cache;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Alert\CacheAlertStream;
use UserFrosting\Alert\SessionAlertStream;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Session\Session;
use UserFrosting\Sprinkle\Core\Exceptions\BadConfigException;
use UserFrosting\Sprinkle\Core\ServicesProvider\AlertStreamService;
use UserFrosting\Testing\ContainerStub;

/**
 * Integration tests for `alerts` service.
 * Check to see if service returns what it's supposed to return
 */
class AlertStreamServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected Container $ci;

    public function setUp(): void
    {
        parent::setUp();

        // Create container with provider to test
        $provider = new AlertStreamService();
        $this->ci = ContainerStub::create($provider->register());
    }

    public function testCacheConfig(): void
    {
        // Create mocks
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('alert.storage')->andReturn('cache')
            ->shouldReceive('getString')->with('alert.key', 'site.alerts')->andReturn('foo')
            ->getMock();

        $session = Mockery::mock(Session::class)
            ->shouldReceive('getId')->andReturn('foobar')
            ->getMock();

        // Set mocks in CI
        $this->ci->set(Config::class, $config);
        $this->ci->set(Session::class, $session);
        $this->ci->set(Cache::class, Mockery::mock(Cache::class));
        $this->ci->set(Translator::class, Mockery::mock(Translator::class));

        // Get stream and assert the right one is returned based on config
        $this->assertInstanceOf(CacheAlertStream::class, $this->ci->get(AlertStream::class));
    }

    public function testSessionConfig(): void
    {
        // Create mocks
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('alert.storage')->andReturn('session')
            ->shouldReceive('getString')->with('alert.key', 'site.alerts')->andReturn('foo')
            ->getMock();

        // Set mocks in CI
        $this->ci->set(Config::class, $config);
        $this->ci->set(Cache::class, Mockery::mock(Cache::class));
        $this->ci->set(Translator::class, Mockery::mock(Translator::class));
        $this->ci->set(Session::class, Mockery::mock(Session::class));

        // Get stream and assert the right one is returned based on config
        $this->assertInstanceOf(SessionAlertStream::class, $this->ci->get(AlertStream::class));
    }

    public function testBadConfig(): void
    {
        // Create mocks
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('alert.storage')->once()->andReturn('foo')
            ->getMock();

        // Set mocks in CI
        $this->ci->set(Config::class, $config);
        $this->ci->set(Cache::class, Mockery::mock(Cache::class));
        $this->ci->set(Translator::class, Mockery::mock(Translator::class));
        $this->ci->set(Session::class, Mockery::mock(Session::class));

        // Get stream and assert the exception is thrown.
        $this->expectException(BadConfigException::class);
        $this->ci->get(AlertStream::class);
    }
}
