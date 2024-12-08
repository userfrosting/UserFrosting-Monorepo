<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Bakery;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use UserFrosting\Bakery\Bakery;
use UserFrosting\Support\Exception\BadInstanceOfException;
use UserFrosting\Tests\TestSprinkle\TestSprinkle;

/**
 * Tests Bakery class.
 */
class BakeryTest extends TestCase
{
    public function testGetters(): void
    {
        $bakery = new Bakery(TestSprinkle::class);
        $this->assertInstanceOf(Application::class, $bakery->getApp()); // @phpstan-ignore-line
        $this->assertSame(TestSprinkle::class, $bakery->getMainSprinkle());
        $this->assertInstanceOf(ContainerInterface::class, $bakery->getContainer()); // @phpstan-ignore-line
    }

    public function testCommandRegistration(): void
    {
        $bakery = new Bakery(SprinkleStub::class);
        $command = $bakery->getApp()->get('stub');
        $this->assertInstanceOf(CommandStub::class, $command);
    }

    public function testBadCommandException(): void
    {
        $this->expectException(BadInstanceOfException::class);
        new Bakery(BadCommandSprinkleStub::class);
    }
}

class SprinkleStub extends TestSprinkle
{
    public function getBakeryCommands(): array
    {
        return [
            CommandStub::class,
        ];
    }
}

class BadCommandSprinkleStub extends TestSprinkle
{
    public function getBakeryCommands(): array
    {
        // @phpstan-ignore-next-line
        return [
            \stdClass::class,
        ];
    }
}

class CommandStub extends Command
{
    // @phpstan-ignore-next-line
    protected function configure()
    {
        $this->setName('stub');
    }
}
