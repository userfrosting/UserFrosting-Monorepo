<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Twig;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Slim\Views\Twig;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Twig\Extensions\ConfigExtension;

/**
 * ConfigExtensionTest class.
 * Tests config twig function
 */
class ConfigExtensionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test ConfigExtension.
     */
    public function testGetConfig(): void
    {
        /** @var Config */
        $config = Mockery::mock(Config::class)
                ->shouldReceive('get')->with('foo')->once()->andReturn('bar')
                ->shouldReceive('get')->with('bar')->once()->andReturn(123)
                ->getMock();

        // Create extensions.
        $extensions = new ConfigExtension($config);

        // Create dumb Twig and test adding extension
        $view = Twig::create('');
        $view->addExtension($extensions);

        $this->assertSame('bar', $view->fetchFromString('{{ config("foo") }}'));
        $this->assertSame('123', $view->fetchFromString("{{ config('bar') }}"));
    }
}
