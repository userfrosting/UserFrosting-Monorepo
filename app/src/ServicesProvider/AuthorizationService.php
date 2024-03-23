<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\ServicesProvider;

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManagerInterface;

/**
 * Authorization related Service.
 */
final class AuthorizationService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            AuthorizationManagerInterface::class => \DI\autowire(AuthorizationManager::class),
        ];
    }
}
