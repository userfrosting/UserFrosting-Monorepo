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
use UserFrosting\Sprinkle\Core\Bakery\SeedCommand;
use UserFrosting\Sprinkle\Core\Seeder\SeedInterface;
use UserFrosting\Sprinkle\Core\Seeder\SeedRepositoryInterface;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * Test SeedListCommand
 */
class SeedCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCommand(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldReceive('run')->once()
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('list')->once()->andReturn([$seed::class])
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldReceive('get')->with($seed::class)->once()->andReturn($seed)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, userInput: ['0']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seeder', $result->getDisplay());
        $this->assertStringContainsString('Seed successful !', $result->getDisplay());
    }

    public function testCommandNoSeed(): void
    {
        // Setup Seeds mock
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('list')->once()->andReturn([])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('No available seeds founds', $result->getDisplay());
    }

    public function testCommandWithClassArgumentAndVerbose(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldReceive('run')->once()
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldNotReceive('list')
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldReceive('get')->with($seed::class)->once()->andReturn($seed)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['class' => [$seed::class]], verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seed(s) to apply', $result->getDisplay());
        $this->assertStringContainsString('* ' . $seed::class, $result->getDisplay());
        $this->assertStringContainsString('Seed successful !', $result->getDisplay());
    }

    public function testCommandWithClassArgumentAndSeedNotFound(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldNotReceive('run')
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldNotReceive('list')
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(false)
            ->shouldNotReceive('get')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['class' => [$seed::class]]);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Class is not a valid seed', $result->getDisplay());
    }

    public function testCommandWithClassArgumentAndRunException(): void
    {
        // Setup Seeds mock
        $message = 'An error has occurred';
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldReceive('run')->once()->andThrow(\Exception::class, $message)
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldReceive('get')->with($seed::class)->once()->andReturn($seed)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['class' => [$seed::class]], verbosity: OutputInterface::VERBOSITY_VERBOSE);

        // Assert some output
        $this->assertStringContainsString($message, $result->getDisplay());
        $this->assertSame(1, $result->getStatusCode());
    }

    public function testCommandWithClassArgumentAndConfirmation(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldReceive('run')->once()
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldReceive('get')->with($seed::class)->once()->andReturn($seed)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['class' => [$seed::class]], userInput: ['y']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seed(s) to apply', $result->getDisplay());
        $this->assertStringContainsString('Do you really wish to continue ?', $result->getDisplay());
        $this->assertStringContainsString('Seed successful !', $result->getDisplay());
    }

    public function testCommandWithClassArgumentAndConfirmationAndForce(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldReceive('run')->once()
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldReceive('get')->with($seed::class)->once()->andReturn($seed)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['class' => [$seed::class], '--force' => true]);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seed(s) to apply', $result->getDisplay());
        $this->assertStringNotContainsString('Do you really wish to continue ?', $result->getDisplay());
        $this->assertStringContainsString('Seed successful !', $result->getDisplay());
    }

    public function testCommandWithClassArgumentAndDeniedConfirmation(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldNotReceive('run')
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldNotReceive('get')
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(true)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['class' => [$seed::class]], userInput: ['n']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seed(s) to apply', $result->getDisplay());
        $this->assertStringContainsString('Do you really wish to continue ?', $result->getDisplay());
        $this->assertStringNotContainsString('Seed successful !', $result->getDisplay());
    }

    public function testCommandWithDatabase(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class)
            ->shouldReceive('run')->once()
            ->getMock();
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('list')->once()->andReturn([$seed::class])
            ->shouldReceive('has')->with($seed::class)->once()->andReturn(true)
            ->shouldReceive('get')->with($seed::class)->once()->andReturn($seed)
            ->getMock();

        // Setup config mock
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getBool')->with('bakery.confirm_sensitive_command', true)->times(2)->andReturn(false)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $ci->set(Config::class, $config);
        $command = $ci->get(SeedCommand::class);
        $result = BakeryTester::runCommand($command, input: ['--database' => 'foobar'], userInput: ['0']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seeder', $result->getDisplay());
        $this->assertStringContainsString('Running seed with `foobar` database connection', $result->getDisplay());
        $this->assertStringContainsString('Seed successful !', $result->getDisplay());
    }
}
