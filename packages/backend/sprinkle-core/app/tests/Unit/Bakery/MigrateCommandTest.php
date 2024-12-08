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
use UserFrosting\Sprinkle\Core\Bakery\MigrateCommand;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;
use UserFrosting\Sprinkle\Core\Exceptions\MigrationDependencyNotMetException;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * Test MigrateCommand
 */
class MigrateCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testMigrateWithNoPending(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn([])
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('getBool')
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to migrate', $result->getDisplay());
    }

    public function testMigrate(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(false)->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Migration successful !', $result->getDisplay());
    }

    /**
     * @depends testMigrate
     */
    public function testMigrateWithConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(false)->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Pending migrations', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Migration successful !', $display);
    }

    /**
     * @depends testMigrateWithConfirmation
     */
    public function testMigrateWithDeniedConfirmation(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
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
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringNotContainsString('Migration successful !', $display);
    }

    /**
     * @depends testMigrate
     */
    public function testMigrateWithVerbose(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(false)->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Pending migrations', $display);
        $this->assertStringContainsString('Using individual steps : No', $display);
        $this->assertStringContainsString('Migration successful !', $display);
    }

    public function testMigrateWithSteps(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(true)->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--step' => true], verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Using individual steps : Yes', $result->getDisplay());
        $this->assertStringContainsString('Migration successful !', $result->getDisplay());
    }

    public function testMigrateWithDatabase(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(false)->andReturn(['foo'])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Running migrate with `foobar` database connection', $result->getDisplay());
        $this->assertStringContainsString('Migration successful !', $result->getDisplay());
    }

    public function testMigrateWithPendingException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andThrow(MigrationDependencyNotMetException::class, 'foo')
            ->shouldNotReceive('migrate')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldNotReceive('getBool')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString("Database migration can't be performed", $result->getDisplay());
    }

    public function testMigrateWithMigrateException(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(false)->andThrow(\Exception::class, 'Migration exception')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Migration exception', $result->getDisplay());
    }

    public function testMigrateWithIssueInMigrate(): void
    {
        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getPending')->once()->andReturn(['foo'])
            ->shouldReceive('migrate')->once()->with(false)->andReturn([])
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Config::class, $config);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing migrated !', $result->getDisplay());
    }

    public function testPretendMigrate(): void
    {
        $queries = ['foo/bar' => [['query' => 'create table "foorbar"']]];
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToMigrate')->once()->andReturn($queries)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate in pretend mode', $display);
        $this->assertStringContainsString('foo/bar', $display);
        $this->assertStringContainsString('create table "foorbar"', $display);
    }

    public function testPretendMigrateWithNoPending(): void
    {
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToMigrate')->once()->andReturn([])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Nothing to migrate', $result->getDisplay());
    }

    public function testPretendMigrateWithIssue(): void
    {
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('pretendToMigrate')->once()->andThrow(\Exception::class, 'foobar')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $command = $ci->get(MigrateCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString("Database migration can't be performed. foobar", $display);
    }
}
