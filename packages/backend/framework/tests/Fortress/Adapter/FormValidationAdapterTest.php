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
use UserFrosting\Fortress\Adapter\FormValidationAdapter;
use UserFrosting\Fortress\RequestSchema\RequestSchemaRepository;
use UserFrosting\I18n\Translator;
use UserFrosting\Tests\Fortress\DictionaryStub;

/**
 * @deprecated Since 5.1 - Test for legacy FormValidationAdapter
 *
 * This test only validate the adapter passes the correct data to the child
 * classes, not every rules. All previous tests were moved to
 * FormValidationArrayAdapterTest.
 */
class FormValidationAdapterTest extends TestCase
{
    protected Translator $translator;

    public function setUp(): void
    {
        $this->translator = new Translator(new DictionaryStub());
    }

    public function testValidateEmail(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'email' => [
                'validators' => [
                    'email' => [
                        'message' => 'Not a valid email address...we think.',
                    ],
                ],
            ],
        ]);

        $expectedResult = [
            'email' => [
                'validators' => [
                    'emailAddress' => [
                        'message' => 'Not a valid email address...we think.',
                    ],
                ],
            ],
        ];

        // Act
        $adapter = new FormValidationAdapter($schema, $this->translator);
        $result = $adapter->rules();

        // Assert
        $this->assertEquals(json_encode($expectedResult, JSON_PRETTY_PRINT), $result);

        // Test with stringEncode as true
        $result = $adapter->rules('json', false);
        $this->assertEquals($expectedResult, $result);

        // Test with html5 format
        $result = $adapter->rules('html5');
        $expectedResult = ['email' => 'data-fv-emailaddress=true data-fv-emailaddress-message="Not a valid email address...we think." '];
        $this->assertEquals($expectedResult, $result);
    }

    public function testSetters(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository();
        $expectedResult = [
            'email' => [
                'validators' => [],
            ],
        ];
        $adapter = new FormValidationAdapter($schema, $this->translator);

        // Act
        $schema = new RequestSchemaRepository([
            'email' => [],
        ]);
        $adapter->setSchema($schema);
        $newTranslator = new Translator(new DictionaryStub());
        $adapter->setTranslator($newTranslator);
        $result = $adapter->rules('json', false);

        // Assert
        $this->assertEquals($expectedResult, $result);
    }
}
