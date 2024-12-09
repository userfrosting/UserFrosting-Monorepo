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
use UserFrosting\Fortress\Adapter\JqueryValidationJsonAdapter;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\I18n\Translator;
use UserFrosting\Tests\Fortress\DictionaryStub;

/**
 * This test is only required to test the correct parameter are passed to the
 * parent JqueryValidationArrayAdapter class.
 */
class JqueryValidationJsonAdapterTest extends TestCase
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
        $adapter = new JqueryValidationJsonAdapter($this->translator);
        $result = $adapter->rules($schema);

        // Assert
        $this->assertEquals(json_encode($expectedResult, JSON_PRETTY_PRINT), $result);
    }

    public function testValidateWithPrefix(): void
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
                'foo[email]' => [
                    'email' => true,
                ],
            ],
            'messages' => [
                'foo[email]' => [
                    'email' => 'Not a valid email address...we think.',
                ],
            ],
        ];

        // Act
        $adapter = new JqueryValidationJsonAdapter($this->translator);
        $result = $adapter->rules($schema, 'foo');

        // Assert
        $this->assertEquals(json_encode($expectedResult, JSON_PRETTY_PRINT), $result);
    }
}
