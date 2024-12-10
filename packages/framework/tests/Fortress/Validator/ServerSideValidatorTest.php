<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress\Validator;

use PHPUnit\Framework\TestCase;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\Validator\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Tests\Fortress\DictionaryStub;

class ServerSideValidatorTest extends TestCase
{
    protected string $basePath;
    protected Translator $translator;
    protected ServerSideValidator $validator;

    public function setUp(): void
    {
        $this->basePath = __DIR__ . '/../data';
        $this->translator = new Translator(new DictionaryStub());
        $this->validator = new ServerSideValidator($this->translator);
    }

    public function testValidateNoValidators(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'email' => [],
        ]);

        // Check passing validation
        // Valid, as no validators are defined
        $this->assertEmpty($this->validator->validate($schema, [
            'email' => 'david',
        ]));
    }

    public function testValidateNoMatch(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'email' => [
                'validators' => [
                    'foo' => [], // Doesn't exist
                ],
            ],
        ]);

        // Check passing validation
        // Valid, as foo is not a validator
        $this->assertEmpty($this->validator->validate($schema, [
            'email' => 'david@owlfancy.com',
        ]));
    }

    public function testValidateEmail(): void
    {
        $schema = new RequestSchema([
            'email' => [
                'validators' => [
                    'email' => [
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'email' => 'david@owlfancy.com',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'email' => 'screeeech',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Email is not a valid email address'], $errors['email']);
    }

    public function testValidateArray(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'screech' => [
                'validators' => [
                    'array' => [
                        'message' => 'Array must be an array.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'screech' => ['foo', 'bar'],
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'screech' => 'screeeech',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Array must be an array.'], $errors['screech']);
    }

    public function testValidateEquals(): void
    {
        // Arrange
        // TODO: Add missing messages for custom rules.
        $schema = new RequestSchema([
            'voles' => [
                'validators' => [
                    'equals' => [
                        'value'         => 8,
                        'caseSensitive' => true,
                        'message'       => 'Voles must be equal to {{value}}.',
                    ],
                ],
            ],
            'screech' => [
                'validators' => [
                    'equals' => [
                        'value'         => 'Whoooo',
                        'caseSensitive' => true,
                        'message'       => 'Screech must be equal to {{value}}.',
                    ],
                ],
            ],
            'genus' => [
                'validators' => [
                    'equals' => [
                        'value'         => 'Myodes',
                        'caseSensitive' => false,
                        'message'       => 'Genus must be equal to {{value}}.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'voles'   => 8,
            'screech' => 'Whoooo',
            'genus'   => 'Myodes',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'voles'   => 3,
            'screech' => 'whooOO', // Case sensitive
            'genus'   => 'myodes', // Will validate, as not case sensitive
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Voles must be equal to 8.'], $errors['voles']);
        $this->assertSame(['Screech must be equal to Whoooo.'], $errors['screech']);
        $this->assertArrayNotHasKey('genus', $errors);
    }

    public function testValidateInteger(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'voles' => [
                'validators' => [
                    'integer' => [
                        'message' => 'Voles must be integer.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'voles' => 8,
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'voles' => 'yes',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Voles must be integer.'], $errors['voles']);

        // Failing too, as decimal is not integer
        $errors = $this->validator->validate($schema, [
            'voles' => 0.5,
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Voles must be integer.'], $errors['voles']);
    }

    public function testValidateLengthBetween(): void
    {
        // Arrange
        $schema = new RequestSchema([
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

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'screech' => 'cawwwwww',
        ]));

        // Check failing validations - Too short
        $errors = $this->validator->validate($schema, [
            'screech' => 'caw',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Your screech must be between 5 and 10 characters long.'], $errors['screech']);

        // Check failing validations - Too long
        $errors = $this->validator->validate($schema, [
            'screech' => 'cawwwwwwwwwwwwwwwwwww',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Your screech must be between 5 and 10 characters long.'], $errors['screech']);
    }

    public function testValidateLengthMin(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'screech' => [
                'validators' => [
                    'length' => [
                        'min'     => 5,
                        'message' => 'Your screech must be at least {{min}} characters long.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'screech' => 'cawwwwww',
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'screech' => 'caw',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Your screech must be at least 5 characters long.'], $errors['screech']);
    }

    public function testValidateLengthMax(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'screech' => [
                'validators' => [
                    'length' => [
                        'max'     => 10,
                        'message' => 'Your screech must be no more than {{max}} characters long.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'screech' => 'cawwwwww',
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'screech' => 'cawwwwwwwwwwwwwwwwwww',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Your screech must be no more than 10 characters long.'], $errors['screech']);
    }

    public function testValidateMatches(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'password' => [
                'validators' => [
                    'matches' => [
                        'field'   => 'passwordc',
                        'message' => "The value of this field does not match the value of the '{{field}}' field.",
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'password'  => 'secret',
            'passwordc' => 'secret',
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'password'  => 'secret',
            'passwordc' => 'hoothoot',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["The value of this field does not match the value of the 'passwordc' field."], $errors['password']);
    }

    public function testValidateMemberOf(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'genus' => [
                'validators' => [
                    'member_of' => [
                        'values'  => ['Megascops', 'Bubo', 'Glaucidium', 'Tyto', 'Athene'],
                        'message' => 'Sorry, that is not one of the permitted genuses.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'genus' => 'Megascops',
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'genus' => 'Dolomedes',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Sorry, that is not one of the permitted genuses.'], $errors['genus']);
    }

    public function testValidateNoLeadingWhitespace(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'user_name' => [
                'validators' => [
                    'no_leading_whitespace' => [
                        'message' => '{{self}} cannot begin with whitespace characters',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alexw',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'user_name' => ' alexw',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['user_name cannot begin with whitespace characters'], $errors['user_name']);
    }

    public function testValidateNoTrailingWhitespace(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'user_name' => [
                'validators' => [
                    'no_trailing_whitespace' => [
                        'message' => '{{self}} cannot end with whitespace characters',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alexw',
        ]));

        // Should still allow starting with whitespace
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => ' alexw',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'user_name' => 'alexw ',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['user_name cannot end with whitespace characters'], $errors['user_name']);
    }

    // Also serve as multiple validators test
    public function testValidateNoTrailingAndNoLeadingWhitespace(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'user_name' => [
                'validators' => [
                    'no_trailing_whitespace' => [
                        'message' => '{{self}} cannot end with whitespace characters',
                    ],
                    'no_leading_whitespace' => [
                        'message' => '{{self}} cannot begin with whitespace characters',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alexw',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'user_name' => '  alexw ',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame([
            'user_name cannot end with whitespace characters',
            'user_name cannot begin with whitespace characters',
        ], $errors['user_name']);
    }

    public function testValidateNotEquals(): void
    {
        // Arrange
        // TODO: Add missing messages for custom rules.
        $schema = new RequestSchema([
            'voles' => [
                'validators' => [
                    'not_equals' => [
                        'value'         => 0,
                        'caseSensitive' => false,
                        'message'       => 'Voles must be not be equal to {{value}}.',
                    ],
                ],
            ],
            'screech' => [
                'validators' => [
                    'equals' => [
                        'value'         => 'Whoooo',
                        'caseSensitive' => true,
                        'message'       => 'Screech must be equal to {{value}}.',
                    ],
                ],
            ],
            'genus' => [
                'validators' => [
                    'equals' => [
                        'value'         => 'Myodes',
                        'caseSensitive' => false,
                        'message'       => 'Genus must be equal to {{value}}.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'voles'   => 8,
            'screech' => 'Whoooo',
            'genus'   => 'Myodes',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'voles'   => 0,
            'screech' => 'whooOO', // Is case sensitive
            'genus'   => 'myodes', // Is not case sensitive, so will validate
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Voles must be not be equal to 0.'], $errors['voles']);
        $this->assertSame(['Screech must be equal to Whoooo.'], $errors['screech']);
        $this->assertArrayNotHasKey('genus', $errors);
    }

    public function testValidateNotMatches(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'password' => [
                'validators' => [
                    'not_matches' => [
                        'field'   => 'user_name',
                        'message' => 'Your password cannot be the same as your username.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'password'  => 'secret',
            'user_name' => 'alexw',
        ]));

        // Check failing validation
        $errors = $this->validator->validate($schema, [
            'password'  => 'secret',
            'user_name' => 'secret',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Your password cannot be the same as your username.'], $errors['password']);
    }

    public function testValidateNotMemberOf(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'genus' => [
                'validators' => [
                    'not_member_of' => [
                        'values'  => ['Myodes', 'Microtus', 'Neodon', 'Alticola'],
                        'message' => 'Sorry, it would appear that you are not an owl.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'genus' => 'Megascops',
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'genus' => 'Myodes',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Sorry, it would appear that you are not an owl.'], $errors['genus']);
    }

    public function testValidateNumeric(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'accuracy' => [
                'validators' => [
                    'numeric' => [
                        'message' => 'Sorry, your strike accuracy must be a number.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'accuracy' => 0.99,
        ]));

        // Check passing even if it's a string
        $this->assertEmpty($this->validator->validate($schema, [
            'accuracy' => '0.99',
        ]));

        // Check passing if empty, as it's not required
        $this->assertEmpty($this->validator->validate($schema, [
            'accuracy' => '',
        ]));

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'accuracy' => false,
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Sorry, your strike accuracy must be a number.'], $errors['accuracy']);

        // Check failing validations - String
        $errors = $this->validator->validate($schema, [
            'accuracy' => 'good',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Sorry, your strike accuracy must be a number.'], $errors['accuracy']);
    }

    public function testValidateRange(): void
    {
        // Arrange
        $schema = new RequestSchema([
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

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'voles' => 6,
        ]));

        // Check failing validations - Too low
        $errors = $this->validator->validate($schema, [
            'voles' => 2,
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['You must catch 5 - 10 voles.'], $errors['voles']);

        // Check failing validations - Too high
        $errors = $this->validator->validate($schema, [
            'voles' => 10000,
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['You must catch 5 - 10 voles.'], $errors['voles']);

        // Check failing validations - Not numeric
        // N.B.: Valitron doesn't have a rule for 'between' or 'range'. There's
        // twice the same message, because it doesn't respect both "min" and "max".
        $errors = $this->validator->validate($schema, [
            'voles' => 'yes',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame([
            'You must catch 5 - 10 voles.',
            'You must catch 5 - 10 voles.',
        ], $errors['voles']);
    }

    public function testValidateRegex(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'screech' => [
                'validators' => [
                    'regex' => [
                        'regex'   => '^who(o*)$',
                        'message' => 'You did not provide a valid screech.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'screech' => 'whooooooooo',
        ]));

        // Check failing validations - Can't have a 't' at the end
        $errors = $this->validator->validate($schema, [
            'screech' => 'whoot',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['You did not provide a valid screech.'], $errors['screech']);

        // Check failing validations - No match
        $errors = $this->validator->validate($schema, [
            'screech' => 'ribbit',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['You did not provide a valid screech.'], $errors['screech']);
    }

    public function testValidateRequired(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'species' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please tell us your species.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'species' => 'Athene noctua',
        ]));

        // Check failing validations - Empty string
        $errors = $this->validator->validate($schema, [
            'species' => '',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Please tell us your species.'], $errors['species']);

        // Check failing validations - Null
        $errors = $this->validator->validate($schema, []);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Please tell us your species.'], $errors['species']);
    }

    public function testValidateTelephone(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'phone' => [
                'validators' => [
                    'telephone' => [
                        'message' => 'Whoa there, check your phone number again.',
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'phone' => '1(212)-999-2345',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'phone' => '212 999 2344',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'phone' => '212-999-0983',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'phone' => '',
        ]));

        // Check failing validations - Area code may not start with 1
        $errors = $this->validator->validate($schema, [
            'phone' => '111-123-5434',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Whoa there, check your phone number again.'], $errors['phone']);

        // Check failing validations - Prefix may not start with 1
        $errors = $this->validator->validate($schema, [
            'phone' => '212 123 4567',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Whoa there, check your phone number again.'], $errors['phone']);
    }

    public function testValidateUri(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'website' => [
                'validators' => [
                    'uri' => [
                        'message' => "That's not even a valid URL...",
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'website' => 'http://www.owlfancy.com',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'website' => 'http://owlfancy.com',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'website' => 'https://learn.userfrosting.com',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'website' => '',
        ]));

        // Check failing validations - we require URLs to begin with http(s)://
        $errors = $this->validator->validate($schema, [
            'website' => 'www.owlfancy.com',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["That's not even a valid URL..."], $errors['website']);

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'website' => 'owlfancy.com',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["That's not even a valid URL..."], $errors['website']);

        // Check failing validations
        $errors = $this->validator->validate($schema, [
            'website' => 'owls',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["That's not even a valid URL..."], $errors['website']);
    }

    public function testValidateUsername(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'user_name' => [
                'validators' => [
                    'username' => [
                        'message' => "Sorry buddy, that's not a valid username.",
                    ],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alex.weissman',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alexweissman',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alex-weissman-the-wise',
        ]));
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => '',
        ]));

        // Check with missing data
        $this->assertEmpty($this->validator->validate($schema, []));

        // Check failing validations - Code not allowed
        $errors = $this->validator->validate($schema, [
            'user_name' => "<script>alert('I got you');</script>",
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["Sorry buddy, that's not a valid username."], $errors['user_name']);

        // Check failing validations - # not allowed
        $errors = $this->validator->validate($schema, [
            'user_name' => '#owlfacts',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["Sorry buddy, that's not a valid username."], $errors['user_name']);

        // Check failing validations - ? and space not allowed
        $errors = $this->validator->validate($schema, [
            'user_name' => 'Did you ever hear the tragedy of Darth Plagueis the Wise?',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(["Sorry buddy, that's not a valid username."], $errors['user_name']);
    }

    /**
     * Test specific bug: When required validator rule is defined, username
     * validator is still called, even if there's no data. This is not the case
     * without "required". In this case, `validateUsername` should be ignored,
     * or accept a null value.
     */
    public function testValidateUsernameForMissingData(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'user_name' => [
                'validators' => [
                    'required' => [
                        'message' => 'Username required',
                    ],
                    'username' => [
                        'message' => "Sorry buddy, that's not a valid username.",
                    ],
                ],
            ],
        ]);

        $errors = $this->validator->validate($schema, []);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Username required', "Sorry buddy, that's not a valid username."], $errors['user_name']);
    }

    public function testDomainRulesClientOnly(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'plumage' => [
                'validators' => [
                    'required' => [
                        'domain'  => 'client',
                        'message' => "Are you sure you don't want to show us your plumage?",
                    ],
                ],
            ],
        ]);

        // Check passing validation - Client are skipped even if plumage is empty
        $this->assertEmpty($this->validator->validate($schema, []));
    }

    public function testDomainRulesServerOnly(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'plumage' => [
                'validators' => [
                    'required' => [
                        'domain'  => 'server',
                        'message' => "Are you sure you don't want to show us your plumage?",
                    ],
                ],
            ],
        ]);

        // Check failing validation - Server are not skipped, so empty plumage return array
        $errors = $this->validator->validate($schema, []);
        $this->assertNotEmpty($errors);
        $this->assertSame(["Are you sure you don't want to show us your plumage?"], $errors['plumage']);
    }

    public function testValidateWithNoValidatorMessage(): void
    {
        // Arrange
        $schema = new RequestSchema([
            'user_name' => [
                'validators' => [
                    'username' => [],
                ],
            ],
        ]);

        // Check passing validation
        $this->assertEmpty($this->validator->validate($schema, [
            'user_name' => 'alex.weissman',
        ]));

        // Check failing validation message - Should fallback to default message
        $errors = $this->validator->validate($schema, [
            'user_name' => '#owlfacts',
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['User Name Invalid'], $errors['user_name']);
    }

    public function testInputArray(): void
    {
        // Get schema
        $schema = new RequestSchema($this->basePath . '/InputArray.yaml');

        // Test no errors
        $errors = $this->validator->validate($schema, [
            'InputArray' => [20, 73]
        ]);
        $this->assertEmpty($errors);

        // Test each element must be integer
        $errors = $this->validator->validate($schema, [
            'InputArray' => [20, 'string']
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Input elements must be integers.'], $errors['InputArray.*']);

        // Test the input itself is required
        $errors = $this->validator->validate($schema, []);
        $this->assertNotEmpty($errors);
        $this->assertSame(['InputArray is required', 'InputArray must be an array'], $errors['InputArray']);

        // Test the input itself must be an array
        $errors = $this->validator->validate($schema, [
            'InputArray' => 20
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['InputArray must be an array'], $errors['InputArray']);
    }

    public function testMultidimensional(): void
    {
        // Get schema
        $schema = new RequestSchema($this->basePath . '/Multidimensional.yaml');

        // String threshold
        $errors = $this->validator->validate($schema, [
            'Settings' => [
                [
                    'name'      => 'Foo',
                    'threshold' => 'eleven', // Bad
                ],
                [
                    'name'      => 'Bar',
                    'threshold' => 73,
                ],
            ]
        ]);
        $this->assertCount(1, $errors);
        $this->assertSame(['Value must be max 100', 'Input elements must be integers'], $errors['Settings.*.threshold']);

        // Max threshold
        $errors = $this->validator->validate($schema, [
            'Settings' => [
                [
                    'name'      => 'Foo',
                    'threshold' => 11,
                ],
                [
                    'name'      => 'Bar',
                    'threshold' => 730, // Bad, to high
                ],
            ]
        ]);
        $this->assertCount(1, $errors);
        $this->assertSame(['Value must be max 100'], $errors['Settings.*.threshold']);

        // String int are accepted
        $errors = $this->validator->validate($schema, [
            'Settings' => [
                [
                    'name'      => 'Foo',
                    'threshold' => '11', // Actually good
                ],
                [
                    'name'      => 'Bar',
                    'threshold' => '73', // Actually good
                ],
            ]
        ]);
        $this->assertCount(0, $errors);

        // Required name, but Threshold is optional
        $errors = $this->validator->validate($schema, [
            'Settings' => [
                [
                    'name'      => 'Foo',
                    'threshold' => 11,
                ],
                [
                    'threshold' => 73, // Bad, missing name
                ],
                [
                    'name'      => 'Foo Bar',
                ],
            ]
        ]);
        $this->assertCount(1, $errors);
        $this->assertSame(['Each settings must have a name'], $errors['Settings.*.name']);

        // Test the Settings input itself is required
        $errors = $this->validator->validate($schema, []);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Settings array is required', 'Settings must be an input array'], $errors['Settings']);

        // Test the input itself must be an array
        $errors = $this->validator->validate($schema, [
            'Settings' => 20
        ]);
        $this->assertNotEmpty($errors);
        $this->assertSame(['Settings must be an input array'], $errors['Settings']);
    }
}
