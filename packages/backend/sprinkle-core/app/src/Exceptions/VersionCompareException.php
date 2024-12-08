<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Exceptions;

use LogicException;

/**
 * Version Compare Exception. Used when a version constraint is not matched.
 */
class VersionCompareException extends LogicException
{
    /** @var string */
    protected $version;

    /** @var string */
    protected $constraint;

    /**
     * @return self
     */
    public function setConstraint(string $constraint)
    {
        $this->constraint = $constraint;

        return $this;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return self
     */
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    public function getConstraint(): string
    {
        return $this->constraint;
    }
}
