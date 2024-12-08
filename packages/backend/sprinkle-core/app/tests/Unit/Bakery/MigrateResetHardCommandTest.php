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

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Schema\Builder;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Bakery\MigrateResetHardCommand;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * MigrateResetCommand tests
 */
class MigrateResetHardCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testResetWithNoTables(): void
    {
        $schema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn([])
            ->getMock();

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($schema)
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('No tables found', $result->getDisplay());
    }

    public function testReset(): void
    {
        $schema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('dropTable')->with('foo')->once()
            ->shouldReceive('dropTable')->with('bar')->once()
            ->getMock();

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($schema)
            ->shouldReceive('getName')->once()->andReturn('foobar')
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Dropping table `foo`...', $display);
        $this->assertStringContainsString('Dropping table `bar`...', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Hard reset successful', $display);
    }

    public function testResetWithForce(): void
    {
        $schema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('dropTable')->with('foo')->once()
            ->shouldReceive('dropTable')->with('bar')->once()
            ->getMock();

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($schema)
            ->shouldNotReceive('getName') // NOT
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--force' => 'true'], userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Dropping table `foo`...', $display);
        $this->assertStringContainsString('Dropping table `bar`...', $display);
        $this->assertStringNotContainsString('Do you really wish to continue ?', $display); // NOT
        $this->assertStringContainsString('Hard reset successful', $display);
    }

    public function testResetWithDeniedConfirmation(): void
    {
        $schema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn(['foo', 'bar'])
            ->getMock();

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($schema)
            ->shouldReceive('getName')->once()->andReturn('foobar')
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Tables to drop', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringNotContainsString('Reset successful !', $display);
    }

    public function testResetWithDatabase(): void
    {
        $schema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn(['foo', 'bar'])
            ->shouldReceive('dropTable')->with('foo')->once()
            ->shouldReceive('dropTable')->with('bar')->once()
            ->getMock();

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($schema)
            ->shouldReceive('getName')->once()->andReturn('foobar')
            ->getMock();

        $manager = Mockery::mock(DatabaseManager::class)
            ->shouldReceive('setDefaultConnection')->with('foobar')->once()
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->shouldReceive('getDatabaseManager')->once()->andReturn($manager)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar'], userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:reset:hard with `foobar` database connection', $display);
        $this->assertStringContainsString('Dropping table `foo`...', $display);
        $this->assertStringContainsString('Dropping table `bar`...', $display);
        $this->assertStringContainsString('Do you really wish to continue ?', $display);
        $this->assertStringContainsString('Hard reset successful', $display);
    }

    public function testPretendReset(): void
    {
        $queries1 = [['query' => 'drop table "forbar"']];
        $queries2 = [['query' => 'drop table "barfoo"']];

        $doctrineSchema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn(['foo/bar', 'bar/foo'])
            ->getMock();

        $schema = Mockery::mock(Builder::class);

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($doctrineSchema)
            ->shouldReceive('getSchemaBuilder')->once()->andReturn($schema)
            ->shouldReceive('pretend')->once()->andReturn($queries1)
            ->shouldReceive('pretend')->once()->andReturn($queries2)
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:reset:hard in pretend mode', $display);
        $this->assertStringContainsString('Dropping table `foo/bar`...', $display);
        $this->assertStringContainsString('drop table "forbar"', $display);
        $this->assertStringContainsString('Dropping table `bar/foo`...', $display);
        $this->assertStringContainsString('drop table "barfoo"', $display);
    }

    public function testPretendResetWithNoTables(): void
    {
        $doctrineSchema = Mockery::mock(AbstractSchemaManager::class)
            ->shouldReceive('listTableNames')->once()->andReturn([])
            ->getMock();

        $schema = Mockery::mock(Builder::class);

        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDoctrineSchemaManager')->once()->andReturn($doctrineSchema)
            ->shouldReceive('getSchemaBuilder')->once()->andReturn($schema)
            ->getMock();

        $db = Mockery::mock(Capsule::class)
            ->shouldReceive('getConnection')->once()->andReturn($connection)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(Capsule::class, $db);
        $command = $ci->get(MigrateResetHardCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--pretend' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $display = $result->getDisplay();
        $this->assertStringContainsString('Running migrate:reset:hard in pretend mode', $display);
        $this->assertStringContainsString('No tables found', $display);
    }
}
