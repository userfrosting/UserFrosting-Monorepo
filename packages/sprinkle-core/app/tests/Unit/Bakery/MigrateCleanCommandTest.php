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
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\MigrateCleanCommand;
use UserFrosting\Sprinkle\Core\Database\Migrator\MigrationRepositoryInterface;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * MigrateResetCommand tests
 */
class MigrateCleanCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCleanWithNoStale(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getStale')->once()->andReturn([])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);

        /** @var MigrateCleanCommand */
        $command = $ci->get(MigrateCleanCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('No stale migrations found', $result->getDisplay());
    }

    public function testClean(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('remove')->once()->with('foo')
            ->shouldReceive('remove')->once()->with('bar')
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getStale')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCleanCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Stale migrations removed from repository', $result->getDisplay());
    }

    public function testCleanWithConfirmation(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('remove')->once()->with('foo')
            ->shouldReceive('remove')->once()->with('bar')
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getStale')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCleanCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Stale migrations', $display);
        $this->assertStringContainsString('Continue and remove stale migrations ?', $display);
        $this->assertStringContainsString('Stale migrations removed from repository', $display);
    }

    public function testCleanWithDeniedConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getStale')->once()->andReturn(['foo', 'bar'])
            ->shouldNotReceive('getRepository')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCleanCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Continue and remove stale migrations ?', $display);
        $this->assertStringNotContainsString('Stale migrations removed from repository', $display);
    }

    public function testCleanWithVerbose(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('remove')->once()->with('foo')
            ->shouldReceive('remove')->once()->with('bar')
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getStale')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCleanCommand::class);
        $result = BakeryTester::runCommand($command, verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Stale migrations', $display);
        $this->assertStringNotContainsString('Continue and remove stale migrations ?', $display);
        $this->assertStringContainsString('Stale migrations removed from repository', $display);
    }

    public function testCleanWithDatabase(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('remove')->once()->with('foo')
            ->shouldReceive('remove')->once()->with('bar')
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getStale')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCleanCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:clean with `foobar` database connection', $display);
        $this->assertStringContainsString('Stale migrations removed from repository', $display);
    }
}
