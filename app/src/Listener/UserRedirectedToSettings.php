<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Listener;

use Psr\EventDispatcher\StoppableEventInterface;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Core\Event\Contract\RedirectingEventInterface;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

/**
 * Set redirect to dashboard.
 */
class UserRedirectedToSettings
{
    public function __construct(
        protected RouteParserInterface $routeParser,
        protected Authenticator $authenticator,
    ) {
    }

    /**
     * @param RedirectingEventInterface&StoppableEventInterface $event
     */
    public function __invoke($event): void
    {
        if ($this->authenticator->checkAccess('uri_account_settings')) {
            $path = $this->routeParser->urlFor('settings');
            $event->setRedirect($path);
        }
    }
}
