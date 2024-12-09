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
use UserFrosting\Sprinkle\Core\Bakery\MigrateRefreshCommand;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;
use UserFrosting\Sprinkle\Core\Exceptions\MigrationDependencyNotMetException;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * MigrateRollbackCommand
 */
class MigrateRefreshCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRefreshWithNoPending(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn([])
            ->shouldNotReceive('rollback')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to refresh', $result->getDisplay());
    }

    public function testRefresh(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations rollbacked', $display);
        $this->assertStringContainsString('Migrations applied', $display);
        $this->assertStringContainsString('Refresh successful !', $display);
    }

    /**
     * @depends testRefresh
     */
    public function testRefreshWithConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations to refresh', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Migrations rollbacked', $display);
        $this->assertStringContainsString('Migrations applied', $display);
        $this->assertStringContainsString('Refresh successful !', $display);
    }

    /**
     * @depends testRefreshWithConfirmation
     */
    public function testRefreshWithDeniedConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldNotReceive('rollback')
            ->shouldNotReceive('getPending')
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations to refresh', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringNotContainsString('Rollback successful !', $display);
    }

    /**
     * @depends testRefresh
     */
    public function testRefreshWithVerbose(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command, verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Refreshing 1 step(s)', $display);
        $this->assertStringContainsString('Migrations to refresh', $display);
        $this->assertStringNotContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Migrations rollbacked', $display);
        $this->assertStringContainsString('Migrations applied', $display);
        $this->assertStringContainsString('Refresh successful !', $display);
    }

    public function testRefreshWithSteps(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(2)->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->once()->with(2)->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--steps' => 2], verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Refreshing 2 step(s)', $result->getDisplay());
        $this->assertStringContainsString('Refresh successful !', $result->getDisplay());
    }

    public function testRefreshWithDatabase(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Running migrate:refresh with `foobar` database connection', $result->getDisplay());
        $this->assertStringContainsString('Refresh successful !', $result->getDisplay());
    }

    public function testRefreshWithGetException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andThrow(MigrationDependencyNotMetException::class, 'foo')
            ->shouldNotReceive('rollback')
            ->shouldNotReceive('getPending')
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString("Database refresh can't be performed", $result->getDisplay());
    }

    public function testRefreshWithMigrateException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andThrow(\Exception::class, 'Foo exception')
            ->shouldNotReceive('getPending')
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Foo exception', $result->getDisplay());
    }

    public function testRefreshWithIssueInRollback(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn([])
            ->shouldNotReceive('getPending')
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Nothing rollbacked !', $result->getDisplay());
    }

    public function testRefreshWithIssueInPending(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andThrow(MigrationDependencyNotMetException::class, 'foo')
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString("Database migration can't be performed.", $result->getDisplay());
    }

    public function testRefreshWithIssueInMigrate(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with()->andThrow(\Exception::class, 'Foo exception')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Foo exception', $result->getDisplay());
    }

    public function testRefreshWithNoneMigrated(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldNotReceive('migrate')->once()->with()->andReturn([])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Nothing migrated !', $result->getDisplay());
    }

    public function testPretend(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class);

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateRefreshCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString("This command can't be pretended.", $result->getDisplay());
    }
}
