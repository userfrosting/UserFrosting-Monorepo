<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress\Transformer;

use Exception;
use PHPUnit\Framework\TestCase;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\Transformer\RequestDataTransformer;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;

class RequestDataTransformerTest extends TestCase
{
    protected string $basePath;
    protected RequestSchemaInterface $schema;
    protected RequestDataTransformer $transformer;

    public function setUp(): void
    {
        $this->basePath = __DIR__.'/../data';

        // Arrange
        $loader = new YamlFileLoader($this->basePath.'/register.yaml');
        $this->schema = new RequestSchema($loader->load());
        $this->transformer = new RequestDataTransformer();
    }

    public function testTransformField(): void
    {
        $schema = new RequestSchema([
            'email' => [
                'transformations' => ['purge', 'trim'],
            ],
        ]);

        $result = $this->transformer->transformField($schema, 'email', '   <b>foo@bar.com</b>   ');
        $this->assertSame('foo@bar.com', $result);
    }

    public function testTransformFieldButNoRules(): void
    {
        $schema = new RequestSchema([
            'email' => [],
        ]);

        $result = $this->transformer->transformField($schema, 'email', '   <b>foo@bar.com</b>   ');
        $this->assertSame('   <b>foo@bar.com</b>   ', $result);
    }

    public function testTransformFieldForNotInSchema(): void
    {
        $schema = new RequestSchema([]);

        $result = $this->transformer->transformField($schema, 'foo', 'bar');
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
        $schema = new RequestSchema([
            'email'       => [],
            'description' => null,  // Replicating an input that has no validation operations
        ]);

        // Act
        $result = $this->transformer->transform($schema, $rawInput, 'skip');

        // Assert
        // N.B.: 'admin' is not in the schema, so it should have be removed
        $transformedData = [
            'email'       => 'david@owlfancy.com',
            'description' => 'Some stuff to describe',
        ];

        $this->assertSame($transformedData, $result);
    }

    public function testBasicWithOnUnexpectedVarAllow(): void
    {
        // Arrange
        $rawInput = [
            'email'       => 'david@owlfancy.com',
            'admin'       => 1,
            'description' => 'Some stuff to describe',
        ];

        // Arrange
        $schema = new RequestSchema([
            'email'       => [],
            'description' => null,  // Replicating an input that has no validation operations
        ]);

        // Act
        $result = $this->transformer->transform($schema, $rawInput, 'allow');

        // Assert
        $transformedData = [
            'email'       => 'david@owlfancy.com',
            'admin'       => 1,
            'description' => 'Some stuff to describe',
        ];

        $this->assertSame($transformedData, $result);
    }

    public function testBasicWithOnUnexpectedVarError(): void
    {
        // Arrange
        $rawInput = [
            'email'       => 'david@owlfancy.com',
            'admin'       => 1,
            'description' => 'Some stuff to describe',
        ];

        // Arrange
        $schema = new RequestSchema([
            'email'       => [],
            'description' => null,  // Replicating an input that has no validation operations
        ]);

        // Set expectations
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("The fields 'admin' are not a valid input field.");

        // Act
        $this->transformer->transform($schema, $rawInput, 'error');
    }

    /**
     * "Trim" transformer.
     */
    public function testTrim(): void
    {
        // Act
        $rawInput = [
            'display_name' => 'THE GREATEST  ',
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'display_name' => 'THE GREATEST',
            'email'        => 'david@owlfancy.com', // Default value
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * "Escape" transformer.
     */
    public function testEscape(): void
    {
        // Act
        $rawInput = [
            'display_name' => '<b>My Super-Important Name</b>',
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'display_name' => '&#60;b&#62;My Super-Important Name&#60;/b&#62;',
            'email'        => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * @depends testEscape
     */
    public function testEscapeWithArrayValue(): void
    {
        // Act
        $rawInput = [
            'display_name' => ['<b>My Super-Important Name</b>'],
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'display_name' => ['&#60;b&#62;My Super-Important Name&#60;/b&#62;'],
            'email'        => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * "Purge" transformer.
     */
    public function testPurge(): void
    {
        // Act
        $rawInput = [
            'user_name' => '<b>My Super-Important Name</b>',
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'user_name' => 'My Super-Important Name',
            'email'     => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * @depends testPurge
     */
    public function testPurgeWithArrayValue(): void
    {
        // Act
        $rawInput = [
            'user_name' => [
                '<b>My Super-Important Name</b>',
                '<i>My Less-Important Name</i>',
            ],
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'user_name' => ['My Super-Important Name', 'My Less-Important Name'],
            'email'     => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * "Purify" transformer.
     */
    public function testPurify(): void
    {
        // Act
        $rawInput = [
            'puppies' => "<script>I'm definitely really a puppy  </script><b>0</b>",
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'puppies' => '<b>0</b>',
            'email'   => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    public function testPurifyWithArrayValue(): void
    {
        // Act
        $rawInput = [
            'puppies' => [
                "<script>I'm definitely really a puppy  </script><b>0</b>",
                "<script>   Trust_me('please');  </script>",
            ],
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'puppies' => ['<b>0</b>', ''],
            'email'   => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    public function testPurifyForNonString(): void
    {
        // Act
        $rawInput = [
            'puppies' => true,
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'puppies' => true,
            'email'   => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * default transformer.
     */
    public function testUnsupportedTransformation(): void
    {
        // Act
        $rawInput = [
            'kitties' => '<b>My Super-Important Test</b>',
        ];

        $result = $this->transformer->transform($this->schema, $rawInput, 'skip');

        // Assert
        $transformedData = [
            'kitties' => '<b>My Super-Important Test</b>',
            'email'   => 'david@owlfancy.com',
        ];

        $this->assertSame($transformedData, $result);
    }

    public function testInputArray(): void
    {
        // Data
        $rawInput = [
            'InputArray' => [
                20,
                '>10< <br />',
                '     whitespace     ',
            ]
        ];

        // Schema
        $schema = new RequestSchema($this->basePath . '/InputArray.yaml');

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations
        $transformedData = [
            'InputArray' => [
                20,
                '>10<',
                'whitespace',
            ]
        ];

        $this->assertSame($transformedData, $result);
    }

    public function testMultidimensional(): void
    {
        // Data
        $rawInput = [
            'Settings' => [
                [
                    'name'      => '   Foo   ',
                    'threshold' => '   20    ',
                ],
                [
                    'name'      => 'Bar <br />',
                    'threshold' => '73<br />',
                ],
            ]
        ];

        // Schema
        $schema = new RequestSchema($this->basePath . '/Multidimensional.yaml');

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations
        // - threshold has Trim
        // - name has purge
        $transformedData = [
            'Settings' => [
                [
                    'name'      => '   Foo   ',
                    'threshold' => '20', // Only threshold is trimmed
                ],
                [
                    'name'      => 'Bar ', // Only name is purged, but since we don't trim, the space will stay !
                    'threshold' => '73<br />',
                ],
            ]
        ];
        $this->assertSame($transformedData, $result);
    }

    /**
     * Same as previous test, but the transformation are at the root "Settings".
     * Per element rules will be overwritten by the root version. Everything
     * will be purged & trimmed.
     */
    public function testMultidimensionalRootLevel(): void
    {
        // Data
        $rawInput = [
            'Settings' => [
                [
                    'name'      => '   Foo   ',
                    'threshold' => '   20    ',
                ],
                [
                    'name'      => 'Bar <br />',
                    'threshold' => '73<br />',
                ],
            ]
        ];

        // Schema
        $schema = new RequestSchema([
            'Settings' => [
                'transformations' => ['purge', 'trim'],
            ],
            'Settings.*.threshold' => [
                'transformations' => ['trim'],
            ],
            'Settings.*.name' => [
                'transformations' => ['purge'],
            ],
        ]);

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations
        $transformedData = [
            'Settings' => [
                [
                    'name'      => 'Foo',
                    'threshold' => '20',
                ],
                [
                    'name'      => 'Bar',
                    'threshold' => '73',
                ],
            ]
        ];
        $this->assertSame($transformedData, $result);
    }

    public function testMultidimensionalPurge(): void
    {
        // Schema - Use two multidimensional field : Named has a name only, 
        // Colored has color only.
        $schema = new RequestSchema([
            'Named'            => [],
            'Named.*.name'     => [],
            'Colored.*.color'  => [],
        ]);

        // Data
        $rawInput = [
            'Named' => [
                [
                    'name'  => 'Joe',
                    'color' => 'blue',
                ],
                [
                    'name'        => 'Kathy',
                    'color'       => 'pink',
                    'description' => 'Something',
                ],
            ],
            'Colored' => [
                [
                    'name'  => 'John',
                    'color' => 'red',
                ]
                ],
        ];

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations - Again, Named has a name only, Colored has color only
        $transformedData = [
            'Named' => [
                ['name' => 'Joe'],
                ['name' => 'Kathy'],
            ],
            'Colored' => [
                ['color' => 'red']
            ],
        ];
        $this->assertSame($transformedData, $result);
    }

    /**
     * Same as the previous test, but 'Named' doesn't have a root field in the 
     * schema, to prove both situation are the same
     */
    public function testMultidimensionalPurgeNoRoot(): void
    {
        $schema = new RequestSchema([
            'Named.*.name'     => [],
            'Colored.*.color'  => [],
        ]);

        // Data
        $rawInput = [
            'Named' => [
                [
                    'name'  => 'Joe',
                    'color' => 'blue',
                ],
                [
                    'name'        => 'Kathy',
                    'color'       => 'pink',
                    'description' => 'Something',
                ],
            ],
            'Colored' => [
                [
                    'name'  => 'John',
                    'color' => 'red',
                ]
                ],
        ];

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations - Again, Named has a name only, Colored has color only
        $transformedData = [
            'Named' => [
                ['name' => 'Joe'],
                ['name' => 'Kathy'],
            ],
            'Colored' => [
                ['color' => 'red']
            ],
        ];
        $this->assertSame($transformedData, $result);
    }

    public function testPurgeNotInSchema(): void
    {
        // Use empty schema - All input will be purged
        $schema = new RequestSchema([]);

        // Data
        $rawInput = [
            'Named' => [
                [
                    'name'  => 'Joe',
                    'color' => 'blue',
                ],
                [
                    'name'        => 'Kathy',
                    'color'       => 'pink',
                    'description' => 'Something',
                ],
            ],
            'Colored' => [
                [
                    'name'  => 'John',
                    'color' => 'red',
                ]
            ],
            'FooBar'      => true, // Will be purged
            'FooBarArray' => [true, false], // Will be purged
        ];

        // Act and assert
        $result = $this->transformer->transform($schema, $rawInput);
        $this->assertSame([], $result);
    }

    public function testInputArrayPurge(): void
    {
        // Schema
        $schema = new RequestSchema([
            'InputArray.*' => [],
        ]);

        // Data
        $rawInput = [
            'InputArray' => [
                '10',
                20,
                true,
            ],
            'Foo' => true // Will be purged
        ];

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations
        $transformedData = [
            'InputArray' => [
                '10',
                20,
                true,
            ]
        ];

        $this->assertSame($transformedData, $result);
    }

    /**
     * Same as previous, but without the '*' wildcard
     */
    public function testInputArrayRootPurge(): void
    {
        // Schema
        $schema = new RequestSchema([
            'InputArray' => [],
        ]);

        // Data
        $rawInput = [
            'InputArray' => [
                '10',
                20,
                true,
            ],
            'Foo' => true // Will be purged
        ];

        // Act
        $result = $this->transformer->transform($schema, $rawInput);

        // Set expectations
        $transformedData = [
            'InputArray' => [
                '10',
                20,
                true,
            ]
        ];

        $this->assertSame($transformedData, $result);
    }
}
