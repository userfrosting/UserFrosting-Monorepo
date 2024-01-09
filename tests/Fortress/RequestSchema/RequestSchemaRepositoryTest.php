<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2021 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress\RequestSchema;

use PHPUnit\Framework\TestCase;
use UserFrosting\Fortress\RequestSchema\RequestSchemaRepository;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;

class RequestSchemaRepositoryTest extends TestCase
{
    protected string $schemaPath;

    /** @var mixed[] */
    protected array $contactSchema;

    public function setUp(): void
    {
        $this->schemaPath = __DIR__.'/../data';

        $this->contactSchema = [
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                ],
            ],
        ];
    }

    public function testReadJsonSchema(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.json');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $result = $schema->all();

        // Assert
        $this->assertSame($this->contactSchema['message'], $result['message']);
    }

    public function testReadYamlSchema(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $result = $schema->all();

        // Assert
        $this->assertSame($this->contactSchema['message'], $result['message']);
    }

    public function testSetDefault(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->setDefault('message', 'I require more voles.');
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                ],
                'default'    => 'I require more voles.',
            ],
        ];
        $this->assertSame($contactSchema['message'], $result['message']);
    }

    public function testSetDefaultWithMissingField(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->setDefault('foo', 'bar');
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'foo' => [
                'default' => 'bar',
            ],
        ];
        $this->assertSame($contactSchema['foo'], $result['foo']);
    }

    public function testAddValidator(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->addValidator('message', 'length', [
            'max'     => 10000,
            'message' => 'Your message is too long!',
        ]);
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                    'length' => [
                        'max'     => 10000,
                        'message' => 'Your message is too long!',
                    ],
                ],
            ],
        ];
        $this->assertSame($contactSchema['message'], $result['message']);
    }

    public function testAddValidatorWithMissingField(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->addValidator('foo', 'length', [
            'max'     => 10000,
            'message' => 'Your message is too long!',
        ]);
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'foo' => [
                'validators' => [
                    'length' => [
                        'max'     => 10000,
                        'message' => 'Your message is too long!',
                    ],
                ],
            ],
        ];
        $this->assertSame($contactSchema['foo'], $result['foo']);
    }

    public function testRemoveValidator(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                    'length' => [
                        'max'     => 10000,
                        'message' => 'Your message is too long!',
                    ],
                ],
            ],
        ]);

        // Act
        $schema->removeValidator('message', 'required');
        // Check that attempting to remove a rule that doesn't exist, will have no effect
        $schema->removeValidator('wings', 'required');
        $schema->removeValidator('message', 'telephone');

        $result = $schema->all();

        // Assert
        $contactSchema = [
            'message' => [
                'validators' => [
                    'length' => [
                        'max'     => 10000,
                        'message' => 'Your message is too long!',
                    ],
                ],
            ],
        ];

        $this->assertEquals($contactSchema, $result);
    }

    public function testSetTransformation(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->setTransformations('message', ['purge', 'owlify']);
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                ],
                'transformations' => [
                    'purge',
                    'owlify',
                ],
            ],
        ];
        $this->assertSame($contactSchema['message'], $result['message']);
    }

    public function testSetTransformationNotAnArray(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->setTransformations('message', 'purge');
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                ],
                'transformations' => [
                    'purge',
                ],
            ],
        ];
        $this->assertSame($contactSchema['message'], $result['message']);
    }

    public function testSetTransformationWithMissingField(): void
    {
        // Arrange
        $loader = new YamlFileLoader($this->schemaPath.'/contact.yaml');
        $schema = new RequestSchemaRepository($loader->load());

        // Act
        $schema->setTransformations('foo', ['purge', 'owlify']);
        $result = $schema->all();

        // Assert
        $contactSchema = [
            'foo' => [
                'transformations' => [
                    'purge',
                    'owlify',
                ],
            ],
        ];
        $this->assertSame($contactSchema['foo'], $result['foo']);
    }
}
