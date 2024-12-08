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
use UserFrosting\Sprinkle\Core\Bakery\SeedListCommand;
use UserFrosting\Sprinkle\Core\Seeder\SeedInterface;
use UserFrosting\Sprinkle\Core\Seeder\SeedRepositoryInterface;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * Test seed:list command.
 */
class SeedListCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCommand(): void
    {
        // Setup Seeds mock
        $seed = Mockery::mock(SeedInterface::class);
        $seeds = Mockery::mock(SeedRepositoryInterface::class)
            ->shouldReceive('list')->once()->andReturn([$seed::class])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SeedRepositoryInterface::class, $seeds);
        $command = $ci->get(SeedListCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seeds List', $result->getDisplay());
        $this->assertStringContainsString($seed::class, $result->getDisplay());
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
        $command = $ci->get(SeedListCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Seeds List', $result->getDisplay());
        $this->assertStringContainsString('No seeds founds', $result->getDisplay());
    }
}
