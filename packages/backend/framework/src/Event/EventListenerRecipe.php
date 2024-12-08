<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Event;

/**
 * Sprinkle Event Listener definition Interface.
 */
interface EventListenerRecipe
{
    /**
     * Return a map of all registered event listener.
     *
     * @return array<class-string, array<class-string|array<string|class-string>>>
     */
    public function getEventListeners(): array;
}
