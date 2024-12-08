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
 * Helper trait to check PHP deprecation.
 */
class PhpDeprecationValidator extends PhpVersionValidator
{
    protected string $message = 'UserFrosting recommend a PHP version that satisfies "%s". While your PHP version (%s) is still supported by UserFrosting, we recommend upgrading as your current version will soon be unsupported. See http://php.net/supported-versions.php for more info.';
}
