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
use UserFrosting\Sprinkle\Core\Bakery\SprinkleListCommand;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Sprinkle\SprinkleRecipe;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * Test sprinkle:list
 *
 * Warning : This test doesn't fully test the output format.
 */
class SprinkleListCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCommand(): void
    {
        $sprinkle = Mockery::mock(SprinkleRecipe::class)
            ->shouldReceive('getName')->once()->andReturn('fooBar')
            ->shouldReceive('getPath')->once()->andReturn('sprinkle-foo/src/.../')
            ->getMock();

        // Setup Seeds mock
        $manager = Mockery::mock(SprinkleManager::class)
            ->shouldReceive('getSprinkles')->once()->andReturn([$sprinkle])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(SprinkleManager::class, $manager);
        $command = $ci->get(SprinkleListCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Loaded Sprinkles', $result->getDisplay());
        $this->assertStringContainsString('fooBar', $result->getDisplay());
        $this->assertStringContainsString('sprinkle-foo/src/.../', $result->getDisplay());
        $this->assertStringContainsString($sprinkle::class, $result->getDisplay());
    }
}
