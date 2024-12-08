<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Validators;

use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Exceptions\VersionCompareException;

/**
 * Unit tests for *VersionValidator trait.
 */
abstract class AbstractVersionValidatorTester extends TestCase
{
    protected string $required;

    /** @var class-string<\UserFrosting\Sprinkle\Core\Validators\AbstractVersionValidator> */
    protected string $validator;

    /**
     * @dataProvider versionProvider
     *
     * @param string $version
     * @param string $sanitized
     * @param bool   $valid
     */
    public function testValidator(string $version, string $sanitized, bool $valid): void
    {
        $validator = new $this->validator($version, $this->required);

        // Assert installed version is sanitized
        $this->assertSame($sanitized, $validator->getInstalled());

        // Assert validate function
        if ($valid) {
            $this->assertTrue($validator->validate()); // @phpstan-ignore-line
        } else {
            try {
                $validator->validate();
            } catch (VersionCompareException $e) {
                $this->assertSame($validator->getConstraint(), $e->getConstraint());
                $this->assertSame($sanitized, $e->getVersion());

                return;
            }

            $this->fail();
        }
    }

    /**
     * Version provider.
     *
     * @return array<string|bool>[] [version, sanitized, valid]
     */
    abstract public static function versionProvider(): array;
}
