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

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use phpmock\mockery\PHPMockery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use UserFrosting\Sprinkle\Core\Bakery\Helper\ShellCommandHelper;
use UserFrosting\Sprinkle\Core\Bakery\ServeCommand;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

class ServeCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCommand(): void
    {
        // Mock passthru, from ShellCommandHelper
        $reflection_class = new ReflectionClass(ShellCommandHelper::class);
        $namespace = $reflection_class->getNamespaceName();
        PHPMockery::mock($namespace, 'passthru')->andReturn(null);

        $ci = ContainerStub::create();
        /** @var ServeCommand */
        $command = $ci->get(ServeCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('php -S localhost:8080 -t public', $result->getDisplay());
    }

    public function testCommandWithPort(): void
    {
        // Mock passthru, from ShellCommandHelper
        $reflection_class = new ReflectionClass(ShellCommandHelper::class);
        $namespace = $reflection_class->getNamespaceName();
        PHPMockery::mock($namespace, 'passthru')->andReturn(null);

        $ci = ContainerStub::create();
        /** @var ServeCommand */
        $command = $ci->get(ServeCommand::class);
        $result = BakeryTester::runCommand($command, ['--port' => '1234']);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('php -S localhost:1234 -t public', $result->getDisplay());
    }
}
