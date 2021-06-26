<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Bakery;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use UserFrosting\Sprinkle\Core\Bakery\LocaleInfoCommand;
use UserFrosting\Support\Repository\Repository as Config;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Test for LocaleInfoCommand (locale:info)
 */
class LocaleInfoCommandTest extends TestCase
{
    protected Command $command;

    /**
     * {@inheritdoc}
     */
    // TODO : Could be moved to Unit with improvement in Locale class.
    public function setUp(): void
    {
        parent::setUp();

        $ci = ContainerStub::create();

        // Use test locale data
        $locator = new ResourceLocator(__DIR__ . '/data');
        $locator->registerStream('locale', '', null, true);
        $ci->set(ResourceLocatorInterface::class, $locator);

        // Force config to only three locales
        $config = $ci->get(Config::class);
        $config->set('site.locales.available', [
            'en_US' => true,
            'es_ES' => false,
            'fr_FR' => true,
        ]);

        // Command to test
        $this->command = $ci->get(LocaleInfoCommand::class);
    }

    /**
     * Test base command without any arguments
     */
    public function testCommand(): void
    {
        $result = BakeryTester::runCommand($this->command);
        
        // Assertions
        $this->assertSame(0, $result->getStatusCode());
        $output = $result->getDisplay();
        $this->assertStringNotContainsString('Spanish', $output);
        $this->assertStringContainsString('English', $output);
    }
}
