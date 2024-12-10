<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\I18n;

use PHPUnit\Framework\TestCase;
use UserFrosting\I18n\Locale;
use UserFrosting\Support\Exception\FileNotFoundException;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceStream;

class LocaleTest extends TestCase
{
    /**
     * @var string
     **/
    protected string $basePath;

    /**
     * @var ResourceLocator
     **/
    protected ResourceLocator $locator;

    public function setUp(): void
    {
        $this->basePath = __DIR__ . '/data/sprinkles';
        $this->locator = new ResourceLocator($this->basePath);
        $this->locator->addStream(new ResourceStream('locale'));

        // Add locations one at a time to simulate how they are added in SprinkleManager
        $this->locator->addLocation(new ResourceLocation('core'))
                      ->addLocation(new ResourceLocation('account'))
                      ->addLocation(new ResourceLocation('fr_CA'));
    }

    public function testConstructorWithNotFoundPath(): void
    {
        $this->expectException(FileNotFoundException::class);
        new Locale('fr_FR', 'locale://fr_FR/doNotExist.yaml');
    }

    public function testGetConfigFile(): void
    {
        $locale = new Locale('fr_FR');
        $this->assertSame('locale://fr_FR/locale.yaml', $locale->getConfigFile());
    }

    public function testGetIdentifier(): void
    {
        $locale = new Locale('fr_FR');
        $this->assertSame('fr_FR', $locale->getIdentifier());
    }

    public function testGetConfig(): void
    {
        $locale = new Locale('fr_FR');
        $this->assertSame([
            'name'           => 'French',
            'regional'       => 'Français',
            'authors'        => [
                'Foo Bar',
                'Bar Foo', // Not available in `core` version
            ],
            'plural_rule' => 2,
            'parents'     => [
                'en_US',
            ],
        ], $locale->getConfig());
    }

    public function testGetAuthors(): void
    {
        $locale = new Locale('fr_FR');
        $data = $locale->getAuthors();
        $this->assertSame([
            'Foo Bar',
            'Bar Foo', // Not available in `core` version
        ], $data);
        $this->assertSame($locale->getConfig()['authors'], $data);
    }

    public function testGetDetails(): void
    {
        $locale = new Locale('fr_FR');
        $this->assertSame('French', $locale->getName());
        $this->assertSame('Français', $locale->getRegionalName());
        $this->assertSame(['en_US'], $locale->getDependentLocalesIdentifier());
    }

    public function testGetLocalizedNameWithNoLocalizedConfig(): void
    {
        $locale = new Locale('es_ES');
        $this->assertSame('Spanish', $locale->getRegionalName());
    }

    public function testGetPluralRule(): void
    {
        $locale = new Locale('fr_FR');
        $this->assertSame(2, $locale->getPluralRule());
    }

    public function testGetPluralRuleWithNoRule(): void
    {
        $locale = new Locale('es_ES');
        $this->assertSame(1, $locale->getPluralRule());
    }

    public function testGetDetailsWithInheritance(): void
    {
        $locale = new Locale('fr_CA');
        $this->assertSame('French Canadian', $locale->getName());
        $this->assertSame('Français Canadien', $locale->getRegionalName());
        $this->assertSame(['fr_FR'], $locale->getDependentLocalesIdentifier());
        $this->assertSame(['Foo Bar', 'Bar Foo'], $locale->getAuthors());
    }

    public function testGetPluralRuleWithInheritance(): void
    {
        $locale = new Locale('fr_CA');
        $this->assertSame(2, $locale->getPluralRule());
    }

    public function testGetDependentLocales(): void
    {
        $locale = new Locale('fr_FR');
        $this->assertSame('en_US', $locale->getDependentLocales()[0]->getIdentifier());
    }

    public function testGetDependentLocalesWithNullParent(): void
    {
        $locale = new Locale('es_ES');
        $this->assertEmpty($locale->getDependentLocales());
    }

    public function testConstructorWithCustomFile(): void
    {
        $locale = new Locale('de_DE', 'locale://de_DE/foo.yaml');
        $this->assertSame([], $locale->getAuthors());
        $this->assertSame('locale://de_DE/foo.yaml', $locale->getConfigFile());
        $this->assertSame('de_DE', $locale->getIdentifier());
        $this->assertSame([], $locale->getConfig());
        $this->assertSame([], $locale->getDependentLocales());
        $this->assertSame([], $locale->getDependentLocalesIdentifier());
        $this->assertSame('', $locale->getName());
        $this->assertSame(1, $locale->getPluralRule());
        $this->assertSame('de_DE', $locale->getRegionalName());
    }

    /**
     * @see https://github.com/userfrosting/UserFrosting/issues/1133
     *
     * @dataProvider locationProvider
     */
    public function testWithSharedLocation(string $path): void
    {
        $locator = new ResourceLocator(__DIR__);
        $locator->addStream(new ResourceStream('locale', $path, shared: true));

        $locale = new Locale('fr_FR');
        $this->assertSame('Tomato', $locale->getName());

        $locale = new Locale('en_US');
        $this->assertSame('English', $locale->getName());
    }

    /**
     * @return string[][]
     */
    public static function locationProvider(): array
    {
        return [
            [__DIR__ . '/data/shared'],
            ['data/shared'],
        ];
    }
}
