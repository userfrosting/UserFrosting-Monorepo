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
use UserFrosting\Alert\AlertStream;
use UserFrosting\Sprinkle\Core\Twig\Extensions\AlertsExtension;

/**
 * TwigAlertsExtensionTest class.
 * Tests Alerts twig extensions
 */
class AlertsExtensionTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test TwigAlertsExtension.
     */
    public function testGetAlerts(): void
    {
        $results = [
            ['message' => 'foo'],
            ['message' => 'bar'],
        ];

        // Define mock AlertStream
        /** @var AlertStream */
        $alertStream = Mockery::mock(AlertStream::class)
                    ->shouldReceive('getAndClearMessages')
                    ->once()
                    ->andReturn($results)
                    ->getMock();

        // Create and assert
        $extensions = new AlertsExtension($alertStream);
        $this->assertSame($results, $extensions->getAlerts());
    }

    /**
     * @depends testGetAlerts
     */
    public function testGetAlertsNoClear(): void
    {
        $results = [
            ['message' => 'foo'],
            ['message' => 'bar'],
        ];

        // Define mock AlertStream
        /** @var AlertStream */
        $alertStream = Mockery::mock(AlertStream::class)
                    ->shouldReceive('getAndClearMessages')
                    ->once()
                    ->andReturn($results)
                    ->getMock();

        // Create and assert
        $extensions = new AlertsExtension($alertStream);
        $this->assertSame($results, $extensions->getAlerts());
    }

    /**
     * @depends testGetAlerts
     */
    public function testGetAlertsIntegration(): void
    {
        $results = [
            ['message' => 'foo'],
            ['message' => 'bar'],
        ];

        // Define mock AlertStream and register with Container
        /** @var AlertStream */
        $alertStream = Mockery::mock(AlertStream::class)
                    ->shouldReceive('messages')
                    ->once()
                    ->andReturn($results)
                    ->getMock();

        // Create and add to extensions.
        $extensions = new AlertsExtension($alertStream);

        // Create dumb Twig and test adding extension
        $view = Twig::create('');
        $view->addExtension($extensions);

        $result = $view->fetchFromString('{% for alert in getAlerts(false) %}{{alert.message}}{% endfor %}');
        $this->assertSame('foobar', $result);
    }
}
