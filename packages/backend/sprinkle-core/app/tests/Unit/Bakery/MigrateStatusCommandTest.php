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

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\DatabaseManager;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Bakery\MigrateStatusCommand;
use UserFrosting\Sprinkle\Core\Database\Migrator\DatabaseMigrationRepository;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * MigrateStatusCommand
 */
class MigrateStatusCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Warning: Test doesn't assert output. Only served for coverage check (line is executed)
     */
    public function testBasicMigrationsCallMigratorWithProperArguments(): void
    {
        // Define dummy data
        $available = ['foo', 'bar', 'oof', 'rab'];
        $pending = ['oof', 'rab'];

        // Setup repository mock
        $repository = Mockery::mock(DatabaseMigrationRepository::class)
            ->shouldReceive('all')->once()->andReturn($this->getInstalledMigrationStub())
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('getAvailable')->once()->andReturn($available)
            ->shouldReceive('getPending')->once()->andReturn($pending)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(DatabaseMigrationRepository::class, $repository);
        $command = $ci->get(MigrateStatusCommand::class);
        BakeryTester::runCommand($command);
    }

    public function testDatabaseMayBeSet(): void
    {
        // Define dummy data
        $available = ['foo', 'bar', 'oof', 'rab'];
        $pending = ['oof', 'rab'];

        // Setup repository mock
        $repository = Mockery::mock(DatabaseMigrationRepository::class)
            ->shouldReceive('all')->once()->andReturn($this->getInstalledMigrationStub())
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('getAvailable')->once()->andReturn($available)
            ->shouldReceive('getPending')->once()->andReturn($pending)
            ->getMock();

        // Set Capsule Mock, and expectations
        $databaseManager = Mockery::mock(DatabaseManager::class)
            ->shouldReceive('setDefaultConnection')->with('test')->once()
            ->getMock();
        $capsule = Mockery::mock(Capsule::class)
            ->shouldReceive('getDatabaseManager')->once()->andReturn($databaseManager)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(Capsule::class, $capsule);
        $ci->set(DatabaseManager::class, $databaseManager);
        $command = $ci->get(MigrateStatusCommand::class);
        $result = BakeryTester::runCommand($command, ['--database' => 'test']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Running migrate:status with `test` database connection', $result->getDisplay());
    }

    /**
     * @depends testBasicMigrationsCallMigratorWithProperArguments
     */
    public function testNoMigrations(): void
    {
        // Define dummy data
        $available = [];
        $pending = [];

        // Setup repository mock
        $repository = Mockery::mock(DatabaseMigrationRepository::class)
            ->shouldReceive('all')->once()->andReturn([])
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('getAvailable')->once()->andReturn($available)
            ->shouldReceive('getPending')->once()->andReturn($pending)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(DatabaseMigrationRepository::class, $repository);
        $command = $ci->get(MigrateStatusCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('No installed migrations', $result->getDisplay());
        $this->assertStringContainsString('No pending migrations', $result->getDisplay());
    }

    /**
     * @depends testBasicMigrationsCallMigratorWithProperArguments
     * Warning: Test doesn't assert output. Only served for coverage check (line is executed)
     */
    public function testUnavailableMigrations(): void
    {
        // Define dummy data
        $available = [];
        $pending = [];

        // Setup repository mock
        $repository = Mockery::mock(DatabaseMigrationRepository::class)
            ->shouldReceive('all')->once()->andReturn($this->getInstalledMigrationStub())
            ->getMock();

        // Setup migrator mock
        $migrator = Mockery::mock(Migrator::class)
            ->shouldReceive('getRepository')->once()->andReturn($repository)
            ->shouldReceive('getAvailable')->once()->andReturn($available)
            ->shouldReceive('getPending')->once()->andReturn($pending)
            ->getMock();

        // Run command
        $ci = ContainerStub::create();
        $ci->set(Migrator::class, $migrator);
        $ci->set(DatabaseMigrationRepository::class, $repository);
        $command = $ci->get(MigrateStatusCommand::class);
        BakeryTester::runCommand($command);
    }

    /** @return array<array{migration: string, batch: int}> */
    protected function getInstalledMigrationStub(): array
    {
        return [
            ['migration' => 'foo', 'batch' => 1],
            ['migration' => 'bar', 'batch' => 2],
        ];
    }
}
