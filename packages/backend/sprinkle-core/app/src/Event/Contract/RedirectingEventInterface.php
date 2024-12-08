<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Event\Contract;

/**
 * Event that can redirect the user to another page.
 */
interface RedirectingEventInterface
{
    /**
     * Get the value of redirect.
     *
     * @return string
     */
    public function getRedirect(): ?string;

    /**
     * Set the value of redirect.
     *
     * @param string $redirect
     */
    public function setRedirect(?string $redirect): void;
}
