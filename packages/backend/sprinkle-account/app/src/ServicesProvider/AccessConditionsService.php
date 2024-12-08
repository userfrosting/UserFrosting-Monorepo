<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\ServicesProvider;

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Account\Authorize\AccessConditions;
use UserFrosting\Sprinkle\Account\Authorize\AccessConditionsInterface;

/**
 * AccessConditions related Service.
 * Decorate this service to add your own custom access conditions.
 */
final class AccessConditionsService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            AccessConditionsInterface::class => \DI\autowire(AccessConditions::class),
        ];
    }
}
