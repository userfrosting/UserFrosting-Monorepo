<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Event\Helper;

/**
 * Common implementation for StoppableEventInterface.
 */
trait StoppableTrait
{
    protected bool $stopped = false;

    /**
     * {@inheritDoc}
     */
    public function isPropagationStopped(): bool
    {
        return $this->stopped;
    }

    /**
     * Stop event propagation.
     */
    public function stop(): void
    {
        $this->stopped = true;
    }
}
