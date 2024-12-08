<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use UserFrosting\I18n\Dictionary;
use UserFrosting\I18n\DictionaryInterface;
use UserFrosting\I18n\Locale;
use UserFrosting\I18n\LocaleInterface;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\I18n\SiteLocale;
use UserFrosting\Sprinkle\Core\I18n\SiteLocaleInterface;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Translator services provider.
 *
 * Register via Autowire :
 *  - Translator::class
 */
class I18nService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            DictionaryInterface::class => function (LocaleInterface $locale, ResourceLocatorInterface $locator) {
                return new Dictionary($locale, $locator);
            },

            LocaleInterface::class     => function (SiteLocaleInterface $siteLocale) {
                return new Locale($siteLocale->getLocaleIdentifier());
            },

            SiteLocaleInterface::class => \DI\autowire(SiteLocale::class),
        ];
    }
}
