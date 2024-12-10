<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress;

use PHPUnit\Framework\TestCase;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema\RequestSchemaRepository;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;

/**
 * @deprecated 5.1
 */
class RequestDataTransformerTest extends TestCase
{
    protected string $basePath;

    protected RequestDataTransformer $transformer;

    public function setUp(): void
    {
        $this->basePath = __DIR__ . '/data';

        // Arrange
        $loader = new YamlFileLoader($this->basePath . '/register.yaml');
        $schema = new RequestSchemaRepository($loader->load());
        $this->transformer = new RequestDataTransformer($schema);
    }

    public function testTransformField(): void
    {
        $schema = new RequestSchemaRepository([
            'email'       => [],
        ]);
        $transformer = new RequestDataTransformer($schema);

        $result = $transformer->transformField('foo', 'bar');
        $this->assertSame('bar', $result);
    }

    /**
     * Basic whitelisting.
     */
    public function testBasic(): void
    {
        // Arrange
        $rawInput = [
            'email'       => 'david@owlfancy.com',
            'admin'       => 1,
            'description' => 'Some stuff to describe',
        ];

        // Arrange
        $schema = new RequestSchemaRepository([
            'email'       => [],
            'description' => null,  // Replicating an input that has no validation operations
        ]);
        $transformer = new RequestDataTransformer($schema);

        // Act
        $result = $transformer->transform($rawInput, 'skip');

        // Assert
        $transformedData = [
            'email'       => 'david@owlfancy.com',
            'description' => 'Some stuff to describe',
        ];

        $this->assertEquals($transformedData, $result);
    }

    public function testSetters(): void
    {
        $this->assertSame(['email' => 'david@owlfancy.com'], $this->transformer->transform([]));

        // New schema removes default
        $newSchema = new RequestSchemaRepository([
            'email' => [],
        ]);
        $this->transformer->setSchema($newSchema);
        $this->assertSame([], $this->transformer->transform([]));
    }
}
