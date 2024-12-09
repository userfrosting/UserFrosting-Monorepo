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
use UserFrosting\Fortress\RequestSchema\RequestSchemaRepository;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;

/**
 * @deprecated 5.1
 */
class ServerSideValidatorTest extends TestCase
{
    protected Translator $translator;

    public function setUp(): void
    {
        $this->translator = new Translator(new DictionaryStub());
    }

    public function testValidateNoValidators(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'email' => [],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'email' => 'david@owlfancy.com',
        ]);

        // Check passing validation
        $this->assertTrue($result);
    }

    public function testValidateNoMatch(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'email' => [
                'validators' => [
                    'foo' => [], // Doesn't exist
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'email' => 'david@owlfancy.com',
        ]);

        // Check passing validation
        $this->assertTrue($result);
    }

    public function testValidateEmail(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'email' => [
                'validators' => [
                    'email' => [
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'email' => 'david@owlfancy.com',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validation
        $this->assertFalse($validator->validate([
            'email' => 'screeeech',
        ]));
        $this->assertSame(['Email is not a valid email address'], $validator->errors('email'));
    }

    public function testValidateArray(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'screech' => [
                'validators' => [
                    'array' => [
                        'message' => 'Array must be an array.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'screech' => ['foo', 'bar'],
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validation
        $this->assertFalse($validator->validate([
            'screech' => 'screeeech',
        ]));
        $this->assertSame(['Array must be an array.'], $validator->errors('screech'));
    }

    public function testValidateEquals(): void
    {
        // Arrange
        // TODO: Add missing messages for custom rules.  Maybe upgrade the version of Valitron first.
        $schema = new RequestSchemaRepository([
            'voles' => [
                'validators' => [
                    'equals' => [
                        'value'         => 8,
                        'caseSensitive' => false,
                        'message'       => 'Voles must be equal to {{value}}.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'voles' => 8,
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validation
        $this->assertFalse($validator->validate([
            'voles' => 3,
        ]));
        $this->assertSame(['Voles must be equal to 8.'], $validator->errors('voles'));
    }

    public function testValidateInteger(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'voles' => [
                'validators' => [
                    'integer' => [
                        'message' => 'Voles must be numeric.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'voles' => 8,
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validations
        $this->assertFalse($validator->validate([
            'voles' => 'yes',
        ]));
        $this->assertSame(['Voles must be numeric.'], $validator->errors('voles'));

        $this->assertFalse($validator->validate([
            'voles' => 0.5,
        ]));
        $this->assertSame(['Voles must be numeric.'], $validator->errors('voles'));
    }

    public function testValidateLengthBetween(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'screech' => [
                'validators' => [
                    'length' => [
                        'min'     => 5,
                        'max'     => 10,
                        'message' => 'Your screech must be between {{min}} and {{max}} characters long.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'screech' => 'cawwwwww',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validations
        $this->assertFalse($validator->validate([
            'screech' => 'caw',
        ]));
        $this->assertSame(['Your screech must be between 5 and 10 characters long.'], $validator->errors('screech'));

        $this->assertFalse($validator->validate([
            'screech' => 'cawwwwwwwwwwwwwwwwwww',
        ]));
        $this->assertSame(['Your screech must be between 5 and 10 characters long.'], $validator->errors('screech'));
    }

    public function testValidateLengthMin(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'screech' => [
                'validators' => [
                    'length' => [
                        'min'     => 5,
                        'message' => 'Your screech must be at least {{min}} characters long.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'screech' => 'cawwwwww',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validations
        $this->assertFalse($validator->validate([
            'screech' => 'caw',
        ]));
        $this->assertSame(['Your screech must be at least 5 characters long.'], $validator->errors('screech'));
    }

    public function testValidateLengthMax(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'screech' => [
                'validators' => [
                    'length' => [
                        'max'     => 10,
                        'message' => 'Your screech must be no more than {{max}} characters long.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'screech' => 'cawwwwww',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'screech' => 'cawwwwwwwwwwwwwwwwwww',
        ]));
        $this->assertSame(['Your screech must be no more than 10 characters long.'], $validator->errors('screech'));
    }

    public function testValidateMatches(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'password' => [
                'validators' => [
                    'matches' => [
                        'field'   => 'passwordc',
                        'message' => "The value of this field does not match the value of the '{{field}}' field.",
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'password'  => 'secret',
            'passwordc' => 'secret',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'password'  => 'secret',
            'passwordc' => 'hoothoot',
        ]));
        $this->assertSame(["The value of this field does not match the value of the 'passwordc' field."], $validator->errors('password'));
    }

    public function testValidateMemberOf(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'genus' => [
                'validators' => [
                    'member_of' => [
                        'values'  => ['Megascops', 'Bubo', 'Glaucidium', 'Tyto', 'Athene'],
                        'message' => 'Sorry, that is not one of the permitted genuses.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'genus' => 'Megascops',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'genus' => 'Dolomedes',
        ]));
        $this->assertSame(['Sorry, that is not one of the permitted genuses.'], $validator->errors('genus'));
    }

    public function testValidateNoLeadingWhitespace(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'user_name' => [
                'validators' => [
                    'no_leading_whitespace' => [
                        'message' => '{{self}} cannot begin with whitespace characters',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'user_name' => 'alexw',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'user_name' => ' alexw',
        ]));
        $this->assertSame(['user_name cannot begin with whitespace characters'], $validator->errors('user_name'));
    }

    public function testValidateNoTrailingWhitespace(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'user_name' => [
                'validators' => [
                    'no_trailing_whitespace' => [
                        'message' => '{{self}} cannot end with whitespace characters',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'user_name' => 'alexw',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Should still allow starting with whitespace
        $this->assertTrue($validator->validate([
            'user_name' => ' alexw',
        ]));

        $this->assertFalse($validator->validate([
            'user_name' => 'alexw ',
        ]));
        $this->assertSame(['user_name cannot end with whitespace characters'], $validator->errors('user_name'));
    }

    public function testValidateNotEquals(): void
    {
        // Arrange
        // TODO: Add missing messages for custom rules.  Maybe upgrade the version of Valitron first.
        $schema = new RequestSchemaRepository([
            'voles' => [
                'validators' => [
                    'not_equals' => [
                        'value'         => 0,
                        'caseSensitive' => false,
                        'message'       => 'Voles must be not be equal to {{value}}.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'voles' => 8,
        ]);

        // Check passing validation
        $this->assertTrue($result);

        // Check failing validation
        $this->assertFalse($validator->validate([
            'voles' => 0,
        ]));
        $this->assertSame(['Voles must be not be equal to 0.'], $validator->errors('voles'));
    }

    public function testValidateNotMatches(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'password' => [
                'validators' => [
                    'not_matches' => [
                        'field'   => 'user_name',
                        'message' => 'Your password cannot be the same as your username.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'password'  => 'secret',
            'user_name' => 'alexw',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'password'  => 'secret',
            'user_name' => 'secret',
        ]));
        $this->assertSame(['Your password cannot be the same as your username.'], $validator->errors('password'));
    }

    public function testValidateNotMemberOf(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'genus' => [
                'validators' => [
                    'not_member_of' => [
                        'values'  => ['Myodes', 'Microtus', 'Neodon', 'Alticola'],
                        'message' => 'Sorry, it would appear that you are not an owl.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'genus' => 'Megascops',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'genus' => 'Myodes',
        ]));
        $this->assertSame(['Sorry, it would appear that you are not an owl.'], $validator->errors('genus'));
    }

    public function testValidateNumeric(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'accuracy' => [
                'validators' => [
                    'numeric' => [
                        'message' => 'Sorry, your strike accuracy must be a number.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'accuracy' => 0.99,
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertTrue($validator->validate([
            'accuracy' => '0.99',
        ]));

        $this->assertTrue($validator->validate([
            'accuracy' => '',
        ]));

        $this->assertFalse($validator->validate([
            'accuracy' => false,
        ]));
        $this->assertSame(['Sorry, your strike accuracy must be a number.'], $validator->errors('accuracy'));

        $this->assertFalse($validator->validate([
            'accuracy' => 'yes',
        ]));
        $this->assertSame(['Sorry, your strike accuracy must be a number.'], $validator->errors('accuracy'));
    }

    public function testValidateRange(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'voles' => [
                'validators' => [
                    'range' => [
                        'min'     => 5,
                        'max'     => 10,
                        'message' => 'You must catch {{min}} - {{max}} voles.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'voles' => 6,
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'voles' => 2,
        ]));
        $this->assertSame(['You must catch 5 - 10 voles.'], $validator->errors('voles'));

        $this->assertFalse($validator->validate([
            'voles' => 10000,
        ]));
        $this->assertSame(['You must catch 5 - 10 voles.'], $validator->errors('voles'));

        $this->assertFalse($validator->validate([
            'voles' => 'yes',
        ]));
        // N.B.: Valitron doesn't have a rule for 'between' or 'range'. There's
        // twice the same message, because it doesn't respect both "min" and "max".
        $this->assertSame([
            'You must catch 5 - 10 voles.',
            'You must catch 5 - 10 voles.',
        ], $validator->errors('voles'));
    }

    public function testValidateRegex(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'screech' => [
                'validators' => [
                    'regex' => [
                        'regex'   => '^who(o*)$',
                        'message' => 'You did not provide a valid screech.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'screech' => 'whooooooooo',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'screech' => 'whoot',
        ]));
        $this->assertSame(['You did not provide a valid screech.'], $validator->errors('screech'));

        $this->assertFalse($validator->validate([
            'screech' => 'ribbit',
        ]));
        $this->assertSame(['You did not provide a valid screech.'], $validator->errors('screech'));
    }

    public function testValidateRequired(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'species' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please tell us your species.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'species' => 'Athene noctua',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertFalse($validator->validate([
            'species' => '',
        ]));
        $this->assertSame(['Please tell us your species.'], $validator->errors('species'));

        $this->assertFalse($validator->validate([]));
        $this->assertSame(['Please tell us your species.'], $validator->errors('species'));
    }

    public function testValidateTelephone(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'phone' => [
                'validators' => [
                    'telephone' => [
                        'message' => 'Whoa there, check your phone number again.',
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'phone' => '1(212)-999-2345',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertTrue($validator->validate([
            'phone' => '212 999 2344',
        ]));

        $this->assertTrue($validator->validate([
            'phone' => '212-999-0983',
        ]));

        $this->assertFalse($validator->validate([
            'phone' => '111-123-5434',
        ]));
        $this->assertSame(['Whoa there, check your phone number again.'], $validator->errors('phone'));

        $this->assertFalse($validator->validate([
            'phone' => '212 123 4567',
        ]));
        $this->assertSame(['Whoa there, check your phone number again.'], $validator->errors('phone'));

        $this->assertTrue($validator->validate([
            'phone' => '',
        ]));
    }

    public function testValidateUri(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'website' => [
                'validators' => [
                    'uri' => [
                        'message' => "That's not even a valid URL...",
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'website' => 'http://www.owlfancy.com',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertTrue($validator->validate([
            'website' => 'http://owlfancy.com',
        ]));

        $this->assertTrue($validator->validate([
            'website' => 'https://learn.userfrosting.com',
        ]));

        // Note that we require URLs to begin with http(s)://
        $this->assertFalse($validator->validate([
            'website' => 'www.owlfancy.com',
        ]));
        $this->assertSame(["That's not even a valid URL..."], $validator->errors('website'));

        $this->assertFalse($validator->validate([
            'website' => 'owlfancy.com',
        ]));
        $this->assertSame(["That's not even a valid URL..."], $validator->errors('website'));

        $this->assertFalse($validator->validate([
            'website' => 'owls',
        ]));
        $this->assertSame(["That's not even a valid URL..."], $validator->errors('website'));

        $this->assertTrue($validator->validate([
            'website' => '',
        ]));
    }

    public function testValidateUsername(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'user_name' => [
                'validators' => [
                    'username' => [
                        'message' => "Sorry buddy, that's not a valid username.",
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'user_name' => 'alex.weissman',
        ]);

        // Check passing validation
        $this->assertTrue($result);

        $this->assertTrue($validator->validate([
            'user_name' => 'alexweissman',
        ]));

        $this->assertTrue($validator->validate([
            'user_name' => 'alex-weissman-the-wise',
        ]));

        // Note that we require URLs to begin with http(s)://
        $this->assertFalse($validator->validate([
            'user_name' => "<script>alert('I got you');</script>",
        ]));
        $this->assertSame(["Sorry buddy, that's not a valid username."], $validator->errors('user_name'));

        $this->assertFalse($validator->validate([
            'user_name' => '#owlfacts',
        ]));
        $this->assertSame(["Sorry buddy, that's not a valid username."], $validator->errors('user_name'));

        $this->assertFalse($validator->validate([
            'user_name' => 'Did you ever hear the tragedy of Darth Plagueis the Wise?',
        ]));
        $this->assertSame(["Sorry buddy, that's not a valid username."], $validator->errors('user_name'));

        $this->assertTrue($validator->validate([
            'user_name' => '',
        ]));
    }

    public function testDomainRulesClientOnly(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'plumage' => [
                'validators' => [
                    'required' => [
                        'domain'  => 'client',
                        'message' => "Are you sure you don't want to show us your plumage?",
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([]);

        // Check passing validation
        $this->assertTrue($result);
    }

    public function testDomainRulesServerOnly(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'plumage' => [
                'validators' => [
                    'required' => [
                        'domain'  => 'server',
                        'message' => "Are you sure you don't want to show us your plumage?",
                    ],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([]);

        // Check passing validation
        $this->assertFalse($result);
        $this->assertSame(["Are you sure you don't want to show us your plumage?"], $validator->errors('plumage'));
    }

    /**
     * @depends testValidateUsername
     */
    public function testValidateWithNoValidatorMessage(): void
    {
        // Arrange
        $schema = new RequestSchemaRepository([
            'user_name' => [
                'validators' => [
                    'username' => [],
                ],
            ],
        ]);

        // Act
        $validator = new ServerSideValidator($schema, $this->translator);
        $result = $validator->validate([
            'user_name' => 'alex.weissman',
        ]);

        // Check passing validation
        $this->assertTrue($result);
    }

    public function testSetters(): void
    {
        $schema = new RequestSchemaRepository();
        $validator = new ServerSideValidator($schema, $this->translator);

        $data = [
            'email' => 'screeeech',
        ];
        $this->assertTrue($validator->validate($data));

        $schema = new RequestSchemaRepository([
            'email' => [
                'validators' => [
                    'email' => [
                    ],
                ],
            ],
        ]);
        $validator->setSchema($schema);
        $validator->setTranslator($this->translator);

        $this->assertFalse($validator->validate([
            'email' => 'screeeech',
        ]));
        $this->assertSame(['Email is not a valid email address'], $validator->errors()['email']); // @phpstan-ignore-line

        // Assert data
        $this->assertSame($data, $validator->data());
    }
}
