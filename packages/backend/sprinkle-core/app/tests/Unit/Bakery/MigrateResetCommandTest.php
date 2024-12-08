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
use UserFrosting\Sprinkle\Core\Bakery\MigrateResetCommand;
use UserFrosting\Sprinkle\Core\Database\Migrator\MigrationRepositoryInterface;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;
use UserFrosting\Sprinkle\Core\Exceptions\MigrationDependencyNotMetException;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * MigrateResetCommand tests
 */
class MigrateResetCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testResetWithNoPending(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn([])
            ->shouldNotReceive('reset')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to reset', $result->getDisplay());
    }

    public function testReset(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('delete')->once()
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldReceive('repositoryExists')->once()->andReturn(true)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('reset')->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Reset successful !', $result->getDisplay());
    }

    /**
     * @depends testReset
     */
    public function testResetWithConfirmation(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('delete')->once()
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldReceive('repositoryExists')->once()->andReturn(true)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('reset')->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations to reset', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Reset successful !', $display);
    }

    /**
     * @depends testResetWithConfirmation
     */
    public function testResetWithDeniedConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldNotReceive('reset')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringNotContainsString('Reset successful !', $display);
    }

    /**
     * @depends testReset
     */
    public function testResetWithVerbose(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('delete')->once()
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldReceive('repositoryExists')->once()->andReturn(true)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('reset')->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations to reset', $display);
        $this->assertStringContainsString('Deleting migration repository', $display);
        $this->assertStringContainsString('Migrations reset :', $display);
        $this->assertStringContainsString('Reset successful !', $display);
    }

    public function testResetWithDatabase(): void
    {
        $repository = Mockery::mock(MigrationRepositoryInterface::class)
            ->shouldReceive('delete')->once()
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldReceive('repositoryExists')->once()->andReturn(true)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('reset')->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:reset with `foobar` database connection', $display);
        $this->assertStringContainsString('Reset successful !', $display);
    }

    public function testResetWithPendingException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andThrow(MigrationDependencyNotMetException::class, 'foo')
            ->shouldNotReceive('reset')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString("Database reset can't be performed", $result->getDisplay());
    }

    public function testResetWithMigrateException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldReceive('reset')->once()->andThrow(\Exception::class, 'Migration exception')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Migration exception', $result->getDisplay());
    }

    public function testResetWithIssueInMigrate(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForReset')->once()->andReturn(['foo'])
            ->shouldReceive('reset')->once()->andReturn([])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing was reset !', $result->getDisplay());
    }

    public function testPretendReset(): void
    {
        $queries = ['foo/bar' => [['query' => 'drop table "foorbar"']]];
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToReset')->once()->andReturn($queries)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:reset in pretend mode', $display);
        $this->assertStringContainsString('foo/bar', $display);
        $this->assertStringContainsString('drop table "foorbar"', $display);
    }

    public function testPretendResetWithNoPending(): void
    {
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToReset')->once()->andReturn([])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to reset', $result->getDisplay());
    }

    public function testPretendResetWithIssue(): void
    {
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToReset')->once()->andThrow(\Exception::class, 'foobar')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateResetCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString("Database reset can't be performed. foobar", $display);
    }
}
