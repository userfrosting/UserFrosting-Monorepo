<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Twig;

use Twig\Extension\ExtensionInterface;
use UserFrosting\Support\ClassRepositoryInterface;

/**
 * Find and returns all registered ExtensionInterface.
 *
 * @extends ClassRepositoryInterface<ExtensionInterface>
 */
interface TwigRepositoryInterface extends ClassRepositoryInterface
{
}
