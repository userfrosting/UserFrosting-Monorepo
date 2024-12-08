<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress\Adapter;

use PHPUnit\Framework\TestCase;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\I18n\Translator;
use UserFrosting\Tests\Fortress\DictionaryStub;

/**
 * @deprecated Since 5.1 - Test for legacy JqueryValidationAdapter
 *
 * This test only validate the adapter passes the correct data to the child
 * classes, not every rules. All previous tests were moved to
 * JqueryValidationArrayAdapterTest.
 */
class JqueryValidationAdapterTest extends TestCase
{
    protected Translator $translator;

    public function setUp(): void
    {
        // Create a message translator
        $this->translator = new Translator(new DictionaryStub());
    }

    public function testValidate(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'email' => [
                'validators' => [
                    'email' => [
                        'message' => 'Not a valid email address...we think.',
                    ],
                ],
            ],
        ]);

        $expectedResult = [
            'rules' => [
                'email' => [
                    'email' => true,
                ],
            ],
            'messages' => [
                'email' => [
                    'email' => 'Not a valid email address...we think.',
                ],
            ],
        ];

        // Act
        $adapter = new JqueryValidationAdapter($schema, $this->translator);
        $result = $adapter->rules();
        $this->assertEquals($expectedResult, $result);

        // Test with stringEncode as true
        $result = $adapter->rules('json', true);
        $this->assertEquals(json_encode($expectedResult, JSON_PRETTY_PRINT), $result);
    }

    public function testSetters(): void
    {
        // Arrange
        $schema = new RequestSchema();
        $expectedResult = [
            'rules' => [
                'email' => [],
            ],
            'messages' => [],
        ];
        $adapter = new JqueryValidationAdapter($schema, $this->translator);

        // Act
        $schema = new RequestSchema([
            'email' => [],
        ]);
        $adapter->setSchema($schema);
        $newTranslator = new Translator(new DictionaryStub());
        $adapter->setTranslator($newTranslator);
        $result = $adapter->rules('json', true);

        // Assert
        $this->assertEquals(json_encode($expectedResult, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT), $result);
    }
}
