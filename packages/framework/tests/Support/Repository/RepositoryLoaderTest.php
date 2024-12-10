<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Support\Repository;

use PHPUnit\Framework\TestCase;
use UserFrosting\Support\Exception\FileNotFoundException;
use UserFrosting\Support\Exception\JsonException;
use UserFrosting\Support\Repository\Loader\ArrayFileLoader;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;
use UserFrosting\Support\Repository\PathBuilder\SimpleGlobBuilder;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceStream;

class RepositoryLoaderTest extends TestCase
{
    protected string $basePath;

    protected ResourceLocator $locator;

    /** @var mixed[] */
    protected array $targetData = [
        'voles' => [
            'caught'   => 8,
            'devoured' => 8,
        ],
        'plumage' => 'floofy',
        'chicks'  => 4,
    ];

    public function setUp(): void
    {
        $this->basePath = __DIR__ . '/data';
        $this->locator = new ResourceLocator($this->basePath);

        $this->locator->addStream(new ResourceStream('owls'));

        // Add them one at a time to simulate how they are added in SprinkleManager
        $this->locator->addLocation(new ResourceLocation('core'));
        $this->locator->addLocation(new ResourceLocation('account'));
        $this->locator->addLocation(new ResourceLocation('admin'));
    }

    public function testGlobLoadArrays(): void
    {
        // Arrange
        $builder = new SimpleGlobBuilder($this->locator, 'owls://');
        $loader = new ArrayFileLoader($builder->buildPaths());

        // Act
        $data = $loader->load();

        $this->assertEquals($this->targetData, $data);
    }

    public function testYamlFileLoader(): void
    {
        // Arrange
        $builder = new SimpleGlobBuilder($this->locator, 'owls://');
        $loader = new YamlFileLoader($builder->buildPaths('yaml'));

        // Act
        $data = $loader->load(false);

        $this->assertEquals($this->targetData, $data);
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testYamlFileLoaderWithGetPaths(): void
    {
        $data = [
            __DIR__ . 'data/core/owls/megascops.yaml',
            __DIR__ . 'data/core/owls/tyto.yaml',
        ];

        $loader = new YamlFileLoader($data);

        $this->assertSame($data, $loader->getPaths());
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testYamlFileLoaderWithStringPath(): void
    {
        $loaderA = new YamlFileLoader([__DIR__ . 'data/core/owls/tyto.yaml']);
        $loaderB = new YamlFileLoader(__DIR__ . 'data/core/owls/tyto.yaml');

        $this->assertSame($loaderA->load(), $loaderB->load());
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testYamlFileLoaderWithPrependPath(): void
    {
        $loaderA = new YamlFileLoader([
            __DIR__ . 'data/core/owls/megascops.yaml',
            __DIR__ . 'data/core/owls/tyto.yaml',
        ]);
        $loaderB = new YamlFileLoader(__DIR__ . 'data/core/owls/megascops.yaml');
        $loaderB->prependPath(__DIR__ . 'data/core/owls/tyto.yaml');

        $this->assertSame($loaderA->load(), $loaderB->load());
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testYamlFileLoaderWithFileNotFoundException(): void
    {
        // Arrange
        $loader = new YamlFileLoader([
            __DIR__ . 'data/core/owls/dontExist.yaml',
        ]);

        // Expectations
        $this->expectException(FileNotFoundException::class);

        // Act
        $loader->load(false);
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testYamlFileLoaderWithSkipMissing(): void
    {
        // Arrange
        $loader = new YamlFileLoader([
            __DIR__ . 'data/core/owls/dontExist.yaml',
        ]);

        // Act
        $data = $loader->load(true);

        $this->assertEmpty($data);
    }

    /**
     * @depends testYamlFileLoader
     * @depends testYamlFileLoaderWithStringPath
     */
    public function testYamlFileLoaderWithNotReadable(): void
    {
        // Need to mock `is_readable`. That's why it's wrapped in a method, so we can properly test the exception.
        // @see https://stackoverflow.com/a/20080850
        $path = __DIR__ . '/data/core/owls/tyto.yaml';
        $loader = $this->getMockBuilder(YamlFileLoader::class)
                       ->setConstructorArgs([$path])
                       ->onlyMethods(['isReadable'])
                       ->getMock();
        $loader->method('isReadable')->willReturn(false);

        // Set expectations
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage("The repository file '$path' exists, but it could not be read.");

        // Act
        $loader->load();
    }

    /**
     * @depends testYamlFileLoader
     * @depends testYamlFileLoaderWithStringPath
     */
    public function testYamlFileLoaderWithFalseFileContent(): void
    {
        // Need to mock `file_get_contents`. That's why it's wrapped in a method, so we can properly test the exception.
        // @see https://stackoverflow.com/a/53905681/445757
        $path = __DIR__ . '/data/core/owls/tyto.yaml';
        $loader = $this->getMockBuilder(YamlFileLoader::class)
                       ->setConstructorArgs([$path])
                       ->onlyMethods(['fileGetContents'])
                       ->getMock();
        $loader->method('fileGetContents')->willReturn(false);

        // Set expectations
        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage("The file '$path' could not be read.");

        // Act
        $loader->load();
    }

    /**
     * Make sure an empty file doesn't mess up by returning null.
     *
     * @depends testYamlFileLoader
     * @depends testYamlFileLoaderWithStringPath
     */
    public function testYamlFileLoaderWithNoFileContent(): void
    {
        $loader = new YamlFileLoader(__DIR__ . '/data/core/owls/empty.yaml');

        // Act
        $data = $loader->load();

        $this->assertEquals([], $data);
    }

    /**
     * Make sure an empty file doesn't mess up by returning null.
     *
     * @depends testYamlFileLoaderWithNoFileContent
     */
    public function testYamlFileLoaderWithNoFileContentOnFirstFile(): void
    {
        $loader = new YamlFileLoader([
            __DIR__ . '/data/core/owls/empty.yaml',
            __DIR__ . '/data/core/owls/tyto.yaml',
        ]);

        // Act
        $data = $loader->load();

        $this->assertEquals([
            'plumage' => 'floofy',
        ], $data);
    }

    /**
     * Make sure an empty file doesn't mess up by returning null.
     *
     * @depends testYamlFileLoaderWithNoFileContent
     */
    public function testYamlFileLoaderWithNoFileContentOnSecondFile(): void
    {
        $loader = new YamlFileLoader([
            __DIR__ . '/data/core/owls/tyto.yaml',
            __DIR__ . '/data/core/owls/empty.yaml',
        ]);

        // Act
        $data = $loader->load();

        $this->assertEquals([
            'plumage' => 'floofy',
        ], $data);
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testLoadYamlWithJsonData(): void
    {
        // Arrange
        $builder = new SimpleGlobBuilder($this->locator, 'owls://');
        $loader = new YamlFileLoader($builder->buildPaths('json'));

        // Act
        $data = $loader->load(false);

        $this->assertEquals([
            'plumage' => 'floofy',
        ], $data);
    }

    /**
     * @depends testYamlFileLoader
     */
    public function testLoadYamlWithPhpData(): void
    {
        // Arrange
        $builder = new SimpleGlobBuilder($this->locator, 'owls://');
        $loader = new YamlFileLoader($builder->buildPaths('php'));

        // This will throw a JsonException
        $this->expectException(JsonException::class);

        // Act
        $loader->load(false);
    }
}
