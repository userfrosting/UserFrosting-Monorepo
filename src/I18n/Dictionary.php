<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2021 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\I18n;

use Illuminate\Support\Arr;
use LogicException;
use UserFrosting\Support\Repository\Loader\ArrayFileLoader;
use UserFrosting\Support\Repository\Loader\FileRepositoryLoader;
use UserFrosting\Support\Repository\Repository;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Load all locale all "Key => translation" data matrix.
 */
class Dictionary extends Repository implements DictionaryInterface
{
    /**
     * @var string Base URI for locator
     */
    protected string $uri = 'locale://';

    /**
     * @var LocaleInterface
     */
    protected LocaleInterface $locale;

    /**
     * @var ResourceLocatorInterface
     */
    protected ResourceLocatorInterface $locator;

    /**
     * @var FileRepositoryLoader
     */
    protected FileRepositoryLoader $fileLoader;

    /**
     * @var string[]|string[][] Locale "Key => translation" data matrix cache
     */
    protected $items = []; // @phpstan-ignore-line Overwrite Laravel phpdoc

    /**
     * @param LocaleInterface           $locale
     * @param ResourceLocatorInterface  $locator
     * @param FileRepositoryLoader|null $fileLoader File loader used to load each dictionary files (default to Array Loader)
     */
    public function __construct(
        LocaleInterface $locale,
        ResourceLocatorInterface $locator,
        ?FileRepositoryLoader $fileLoader = null
    ) {
        $this->locale = $locale;
        $this->locator = $locator;
        $this->fileLoader = is_null($fileLoader) ? new ArrayFileLoader([]) : $fileLoader;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function getDictionary(): array
    {
        if (count($this->items) === 0) {
            $this->items = $this->loadDictionary();
        }

        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlattenDictionary(): array
    {
        return Arr::dot($this->getDictionary());
    }

    /**
     * Set the locator base URI (default 'locale://').
     *
     * @param string $uri
     */
    public function setUri(string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): LocaleInterface
    {
        return $this->locale;
    }

    /**
     * Return the file repository loader used to load.
     *
     * @return FileRepositoryLoader
     */
    public function getFileLoader(): FileRepositoryLoader
    {
        return $this->fileLoader;
    }

    /**
     * Load the dictionary from file.
     *
     * @return string[]|string[][] The locale dictionary
     */
    protected function loadDictionary(): array
    {
        $dictionary = [];

        // List of loaded locales
        $loadedLocale = [$this->locale->getIdentifier()];

        // Get list of files to load
        $files = $this->getFiles();
        $files = $this->filterDictionaryFiles($files);
        $files = array_map('strval', $files);

        // Load all files content if files are present
        if (count($files) !== 0) {
            $loader = $this->getFileLoader();
            $loader->setPaths($files);

            $dictionary = $loader->load();
        }

        // Now load dependent dictionaries
        foreach ($this->locale->getDependentLocales() as $locale) {
            // Stop if locale already loaded to prevent recursion
            $localesToLoad = array_merge([$locale->getIdentifier()], $locale->getDependentLocalesIdentifier());
            $intersection = array_intersect($localesToLoad, $loadedLocale);
            if (count($intersection) !== 0) {
                throw new LogicException("Can't load dictionary. Dependencies recursion detected : " . implode(', ', $intersection));
            }

            $dependentDictionary = new self($locale, $this->locator, $this->fileLoader);
            $dictionary = array_replace_recursive($dependentDictionary->getDictionary(), $dictionary);

            $loadedLocale[] = $locale->getIdentifier();
        }

        return $dictionary;
    }

    /**
     * Remove config files from locator results and convert ResourceInterface to path/string.
     *
     * @param \UserFrosting\UniformResourceLocator\ResourceInterface[] $files
     *
     * @return string[]
     */
    protected function filterDictionaryFiles(array $files): array
    {
        // @phpstan-ignore-next-line False positive. ResourceInterface is Stringable.
        return array_filter($files, function ($file) {
            if ($file->getExtension() == 'php') {
                return (string) $file;
            }
        });
    }

    /**
     * List all files for a given locale using the locator.
     *
     * @return \UserFrosting\UniformResourceLocator\ResourceInterface[]
     */
    protected function getFiles(): array
    {
        $resources = $this->locator->listResources($this->uri . $this->locale->getIdentifier(), true, false);
        $resources = array_reverse($resources);

        return $resources;
    }
}
