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
use UserFrosting\Sprinkle\Account\I18n\SiteLocale;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;

class I18nService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            SiteLocaleInterface::class => \DI\autowire(SiteLocale::class),
        ];
    }
}
