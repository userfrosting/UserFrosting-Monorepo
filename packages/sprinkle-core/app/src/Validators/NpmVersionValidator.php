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

/**
 * Helper trait to check NPM version dependencies.
 */
class NpmVersionValidator extends AbstractVersionValidator
{
    protected string $message = 'UserFrosting requires NPM with a version that satisfies "%s", but found %s. Check the documentation for more details.';
}
