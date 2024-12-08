<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Bakery;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\LocaleDictionaryCommand;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;
use UserFrosting\UniformResourceLocator\ResourceStream;

/**
 * Test for LocaleDictionaryCommand (locale:dictionary)
 */
class LocaleDictionaryCommandTest extends TestCase
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
        $stream = new ResourceStream('locale', shared: true);
        $locator = new ResourceLocator(__DIR__ . '/data');
        $locator->addStream($stream);
        $ci->set(ResourceLocatorInterface::class, $locator);

        // Force config to only three locales
        $config = $ci->get(Config::class);
        $config->set('site.locales.available', [
            'en_US' => true,
            'es_ES' => false,
            'fr_FR' => true,
        ]);

        // Command to test
        $this->command = $ci->get(LocaleDictionaryCommand::class);
    }

    public function testCommandWithArguments(): void
    {
        $result = BakeryTester::runCommand($this->command, [
            '--locale' => 'fr_FR',
        ]);

        // Assertions
        $this->assertSame(0, $result->getStatusCode());
        $output = $result->getDisplay();
        $this->assertStringNotContainsString('Dictionary for English locale', $output);
        $this->assertStringContainsString('Dictionary for French locale', $output);
    }

    public function testCommand(): void
    {
        $result = BakeryTester::runCommand(
            command: $this->command,
            userInput: ['fr_FR']
        );

        // Assertions
        $this->assertSame(0, $result->getStatusCode());
        $output = $result->getDisplay();
        $this->assertStringNotContainsString('Dictionary for English locale', $output);
        $this->assertStringContainsString('Dictionary for French locale', $output);
    }
}
