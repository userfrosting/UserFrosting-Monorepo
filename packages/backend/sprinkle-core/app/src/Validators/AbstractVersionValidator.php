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
use UserFrosting\Sprinkle\Core\Exceptions\VersionCompareException;

/**
 * Helper trait to check version dependencies.
 */
class AbstractVersionValidator
{
    protected string $message = '';

    public function __construct(
        protected string $installed,
        protected string $required,
    ) {
    }

    /**
     * Check the minimum version requirement of X installed.
     *
     * @throws VersionCompareException If constraint version is not matched.
     *
     * @return true Version is valid
     */
    public function validate(): bool
    {
        $version = $this->getInstalled();
        $constraint = $this->getConstraint();

        if (!Semver::satisfies($version, $constraint)) {
            $message = sprintf($this->message, $constraint, $version);
            $exception = new VersionCompareException($message);
            $exception->setConstraint($constraint)->setVersion($version);

            throw $exception;
        }

        return true;
    }

    /**
     * Returns system Node version.
     *
     * @return string
     */
    public function getInstalled(): string
    {
        return trim($this->installed);
    }

    /**
     * Returns the required Node semver range.
     *
     * @return string
     */
    public function getConstraint(): string
    {
        return $this->required;
    }
}
