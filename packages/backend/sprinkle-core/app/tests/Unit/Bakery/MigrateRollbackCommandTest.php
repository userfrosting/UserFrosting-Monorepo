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
use UserFrosting\Sprinkle\Core\Bakery\MigrateRollbackCommand;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;
use UserFrosting\Sprinkle\Core\Exceptions\MigrationDependencyNotMetException;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * MigrateRollbackCommand
 */
class MigrateRollbackCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRollbackWithNoPending(): void
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
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to rollback', $result->getDisplay());
    }

    public function testRollback(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Rollback successful !', $result->getDisplay());
    }

    /**
     * @depends testRollback
     */
    public function testRollbackWithConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(1)->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations to rollback', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Rollback successful !', $display);
    }

    /**
     * @depends testRollbackWithConfirmation
     */
    public function testRollbackWithDeniedConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldNotReceive('rollback')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringNotContainsString('Rollback successful !', $display);
    }

    /**
     * @depends testRollback
     */
    public function testRollbackWithVerbose(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Migrations to rollback', $display);
        $this->assertStringContainsString('Rolling back 1 step(s)', $display);
        $this->assertStringContainsString('Rollback successful !', $display);
    }

    public function testRollbackWithSteps(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(2)->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->once()->with(2)->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--steps' => 2], verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Rolling back 2 step(s)', $result->getDisplay());
        $this->assertStringContainsString('Rollback successful !', $result->getDisplay());
    }

    /**
     * N.B.: "two" will be cast to 0.
     */
    public function testRollbackWithStepString(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->with(0)->once()->andReturn([])
            ->shouldNotReceive('rollback')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--steps' => 'two'], verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Rolling back 0 step(s)', $result->getDisplay());
        $this->assertStringContainsString('Nothing to rollback', $result->getDisplay());
    }

    public function testRollbackWithDatabase(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Running migrate:rollback with `foobar` database connection', $result->getDisplay());
        $this->assertStringContainsString('Rollback successful !', $result->getDisplay());
    }

    public function testRollbackWithGetException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andThrow(MigrationDependencyNotMetException::class, 'foo')
            ->shouldNotReceive('rollback')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('get')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString("Database rollback can't be performed", $result->getDisplay());
    }

    public function testRollbackWithMigrateException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andThrow(\Exception::class, 'Rollback exception')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Rollback exception', $result->getDisplay());
    }

    public function testRollbackWithIssueInRollback(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getMigrationsForRollback')->once()->andReturn(['foo'])
            ->shouldReceive('rollback')->with(1)->once()->andReturn([])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing rollbacked !', $result->getDisplay());
    }

    public function testPretendRollback(): void
    {
        $queries = ['foo/bar' => [['query' => 'drop table "foorbar"']]];
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToRollback')->once()->andReturn($queries)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:rollback in pretend mode', $display);
        $this->assertStringContainsString('foo/bar', $display);
        $this->assertStringContainsString('drop table "foorbar"', $display);
    }

    public function testPretendRollbackWithNoPending(): void
    {
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToRollback')->once()->andReturn([])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to rollback', $result->getDisplay());
    }

    public function testPretendRollbackWithIssue(): void
    {
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToRollback')->once()->andThrow(\Exception::class, 'foobar')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateRollbackCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString("Database rollback can't be performed. foobar", $display);
    }
}
