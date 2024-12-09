<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\ServicesProvider;

use Mockery;
use PHPUnit\Framework\TestCase;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\Event\AssetsBuildCommandEvent;
use UserFrosting\Sprinkle\Core\Listeners\AssetsBuildCommandListener;

class AssetsBuildCommandListenerTest extends TestCase
{
    /**
     * @dataProvider bundlerProvider
     *
     * @param string   $bundler
     * @param string[] $expected
     */
    public function testForWebpack(string $bundler, array $expected): void
    {
        /** @var Config */
        $config = Mockery::mock(Config::class)
            ->shouldReceive('getString')->with('assets.bundler', 'vite')->once()->andReturn($bundler)
            ->getMock();

        $event = new AssetsBuildCommandEvent();

        $listener = new AssetsBuildCommandListener($config);
        $listener($event);

        $this->assertSame($expected, $event->getCommands());
    }

    /**
     * @return array<string|string[]>[]
     */
    public static function bundlerProvider(): array
    {
        return [
            ['webpack', ['assets:install', 'assets:webpack']],
            ['foobar', ['assets:install', 'assets:vite']],
            ['vite', ['assets:install', 'assets:vite']],
        ];
    }
}
