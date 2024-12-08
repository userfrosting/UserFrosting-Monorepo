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
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Support\Exception\FileNotFoundException;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;

class RequestSchemaTest extends TestCase
{
    protected string $schemaPath;

    /** @var mixed[] */
    protected array $contactSchema = [
        'message' => [
            'validators' => [
                'required' => [
                    'message' => 'Please enter a message',
                ],
            ],
        ],
    ];

    public function setUp(): void
    {
        $this->schemaPath = __DIR__.'/data';
    }

    public function testWithNoInput(): void
    {
        $requestSchema = new RequestSchema();
        $this->assertSame([], $requestSchema->all());
    }

    public function testWithPathJson(): void
    {
        $requestSchema = new RequestSchema($this->schemaPath.'/contact.json');
        $this->assertSame($this->contactSchema['message'], $requestSchema->all()['message']);
    }

    public function testWithPathYaml(): void
    {
        $requestSchema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $this->assertSame($this->contactSchema['message'], $requestSchema->all()['message']);
    }

    public function testWithBadPath(): void
    {
        $this->expectException(FileNotFoundException::class);
        new RequestSchema(__DIR__.'/data/bad.json');
    }

    public function testArrayData(): void
    {
        $loader = new YamlFileLoader($this->schemaPath.'/contact.json');
        $schema = new RequestSchema($loader->load());
        $this->assertSame($this->contactSchema['message'], $schema->all()['message']);
    }

    public function testSetDefault(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->setDefault('message', 'I require more voles.');

        // Add the default to the expected schema
        $contactSchema = $this->contactSchema;
        $contactSchema['message']['default'] = 'I require more voles.';
        $this->assertSame($contactSchema['message'], $schema->all()['message']);
    }

    public function testSetDefaultWithMissingField(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->setDefault('foo', 'bar');

        $contactSchema = [
            'foo' => [
                'default' => 'bar',
            ],
        ];
        $this->assertSame($contactSchema['foo'], $schema->all()['foo']);
    }

    public function testAddValidator(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->addValidator('message', 'length', [
            'max'     => 10000,
            'message' => 'Your message is too long!',
        ]);

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
        $this->assertSame($contactSchema['message'], $schema->all()['message']);
    }

    public function testAddValidatorWithMissingField(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->addValidator('foo', 'length', [
            'max'     => 10000,
            'message' => 'Your message is too long!',
        ]);

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
        $this->assertSame($contactSchema['foo'], $schema->all()['foo']);
    }

    public function testRemoveValidator(): void
    {
        $schema = new RequestSchema([
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

        $schema->removeValidator('message', 'required');
        // Check that attempting to remove a rule that doesn't exist, will have no effect
        $schema->removeValidator('wings', 'required');
        $schema->removeValidator('message', 'telephone');

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

        $this->assertEquals($contactSchema, $schema->all());
    }

    public function testSetTransformation(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->setTransformations('message', ['purge', 'owlify']);

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
        $this->assertSame($contactSchema['message'], $schema->all()['message']);
    }

    public function testSetTransformationNotAnArray(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->setTransformations('message', 'purge');

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
        $this->assertSame($contactSchema['message'], $schema->all()['message']);
    }

    public function testSetTransformationWithMissingField(): void
    {
        $schema = new RequestSchema($this->schemaPath.'/contact.yaml');
        $schema->setTransformations('foo', ['purge', 'owlify']);

        $contactSchema = [
            'foo' => [
                'transformations' => [
                    'purge',
                    'owlify',
                ],
            ],
        ];
        $this->assertSame($contactSchema['foo'], $schema->all()['foo']);
    }
}
