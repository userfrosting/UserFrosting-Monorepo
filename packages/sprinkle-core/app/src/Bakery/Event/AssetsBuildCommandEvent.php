<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery\Event;

/**
 * AssetsBuildCommand Event. Dispatched when the `assets:build` command is about to be run.
 *
 * The list of subcommands that will be run can be manipulated using this event
 * to insert custom subcommands into the callstack.
 */
final class AssetsBuildCommandEvent extends AbstractAggregateCommandEvent
{
}
