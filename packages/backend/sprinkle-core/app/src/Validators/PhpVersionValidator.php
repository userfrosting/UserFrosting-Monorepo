<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Validators;

use Composer\Semver\Semver;

/**
 * Helper trait to check PHP version dependencies.
 */
class PhpVersionValidator extends AbstractVersionValidator
{
    protected string $message = 'UserFrosting requires PHP with a version that satisfies "%s", but found %s. Check the documentation for more details.';

    /**
     * Returns system php version.
     * Handle non semver compliant version of PHP returned by some OS.
     *
     * @see https://github.com/composer/semver/issues/125
     *
     * @return string
     */
    public function getInstalled(): string
    {
        $version = preg_replace('#^([^~+-]+).*$#', '$1', $this->installed);

        return (string) $version;
    }
}
