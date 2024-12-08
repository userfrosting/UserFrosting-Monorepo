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
 * Common implementation for RedirectingEventInterface.
 */
trait RedirectTrait
{
    protected ?string $redirect = null;

    /**
     * Get the value of redirect.
     *
     * @return string
     */
    public function getRedirect(): ?string
    {
        return $this->redirect;
    }

    /**
     * Set the value of redirect.
     *
     * @param string $redirect
     */
    public function setRedirect(?string $redirect): void
    {
        $this->redirect = $redirect;
    }
}
