<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\I18n;

/**
 * Locale interface.
 */
interface LocaleInterface
{
    /**
     * Returns the list of authors of the locale.
     *
     * @return string[] The list of authors
     */
    public function getAuthors(): array;

    /**
     * Returns defined configuration file.
     *
     * @return string
     */
    public function getConfigFile(): string;

    /**
     * Returns the locale identifier.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Return the raw configuration data.
     *
     * @return mixed[]
     */
    public function getConfig(): array;

    /**
     * Return an array of parent locales.
     *
     * @return LocaleInterface[]
     */
    public function getDependentLocales(): array;

    /**
     * Return a list of parent locale identifier (eg. [fr_FR, en_US]).
     *
     * @return string[]
     */
    public function getDependentLocalesIdentifier(): array;

    /**
     * Return the name of the locale, in English form.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Return the number representing the plural rule to use for this locale.
     *
     * @return int
     */
    public function getPluralRule(): int;

    /**
     * Return the localized version of the locale name.
     *
     * @return string
     */
    public function getRegionalName(): string;
}
