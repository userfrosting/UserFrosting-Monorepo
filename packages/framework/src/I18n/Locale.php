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

use UserFrosting\Support\Repository\Loader\YamlFileLoader;

/**
 * Act as a container for a Locale data loaded from filesystem data.
 */
class Locale implements LocaleInterface
{
    /**
     * @var string The locale config file path.
     */
    protected string $configFile = '';

    /**
     * @var mixed[] Locale config data, loaded from the locale YAML file.
     */
    protected array $config;

    /**
     * Create locale class.
     *
     * @param string      $identifier The locale identifier (ie. "en_US")
     * @param string|null $configFile The path to the locale config file
     */
    public function __construct(protected string $identifier, ?string $configFile = null)
    {
        $this->configFile = $configFile ?? "locale://$identifier/locale.yaml";
        $this->loadConfig();
    }

    /**
     * Loads the config into the class property.
     *
     * @throws \UserFrosting\Support\Exception\FileNotFoundException if config file not found
     */
    protected function loadConfig(): void
    {
        $loader = new YamlFileLoader($this->configFile);
        $this->config = $loader->load(false);

        // Load nested locales config
        foreach ($this->getDependentLocales() as $locale) {
            $this->config = array_merge($locale->getConfig(), $this->config);
        }
    }

    /**
     * Returns the list of authors of the locale.
     *
     * @return string[] The list of authors
     */
    public function getAuthors(): array
    {
        if (!isset($this->config['authors'])) {
            return [];
        } else {
            return (array) $this->config['authors'];
        }
    }

    /**
     * Returns defined configuration file.
     *
     * @return string
     */
    public function getConfigFile(): string
    {
        return $this->configFile;
    }

    /**
     * Returns the locale identifier.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Return the raw configuration data.
     *
     * @return mixed[]
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Return an array of parent locales.
     *
     * @return Locale[]
     */
    public function getDependentLocales(): array
    {
        $parents = $this->getDependentLocalesIdentifier();

        // Transform locale identifier to locale instance
        $locales = array_map(function ($value) {
            return new self($value);
        }, $parents);

        return $locales;
    }

    /**
     * Return a list of parent locale identifier (eg. [fr_FR, en_US]).
     *
     * @return string[]
     */
    public function getDependentLocalesIdentifier(): array
    {
        if (isset($this->config['parents']) && is_array($this->config['parents'])) {
            return $this->config['parents'];
        } else {
            return [];
        }
    }

    /**
     * Return the name of the locale, in English form.
     *
     * @return string
     */
    public function getName(): string
    {
        if (isset($this->config['name']) && is_string($this->config['name'])) {
            return $this->config['name'];
        } else {
            return '';
        }
    }

    /**
     * Return the number representing the plural rule to use for this locale.
     *
     * @return int
     */
    public function getPluralRule(): int
    {
        if (isset($this->config['plural_rule'])) {
            return (int) $this->config['plural_rule'];
        } else {
            return 1;
        }
    }

    /**
     * Return the localized version of the locale name.
     *
     * @return string
     */
    public function getRegionalName(): string
    {
        if (isset($this->config['regional']) && is_string($this->config['regional'])) {
            return $this->config['regional'];
        } elseif (isset($this->config['name']) && is_string($this->config['name'])) {
            return $this->config['name'];
        } else {
            return $this->identifier;
        }
    }
}
