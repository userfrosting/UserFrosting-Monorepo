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

use UserFrosting\Sprinkle\Core\Validators\NodeVersionValidator;

/**
 * Unit tests for NodeVersionValidator trait.
 */
class NodeVersionValidatorTest extends AbstractVersionValidatorTester
{
    protected string $required = '^12.17.0 || >=14.0.0';

    protected string $validator = NodeVersionValidator::class;

    /**
     * Node version provider.
     *
     * @return array<string|bool>[] [version, sanitized, valid]
     */
    public static function versionProvider(): array
    {
        return [
            ['v12.18.1', 'v12.18.1', true],
            ['v13.12.3', 'v13.12.3', false],
            ['v14.0.0 ', 'v14.0.0', true], // Test trim here
        ];
    }
}
