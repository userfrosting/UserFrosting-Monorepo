<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery;

use DI\Attribute\Inject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\I18n\Compare;
use UserFrosting\I18n\Dictionary;
use UserFrosting\I18n\DictionaryInterface;
use UserFrosting\Sprinkle\Core\Bakery\Helper\LocaleOption;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * locale:missing-keys command.
 * Find missing keys in locale translation files.
 */
class LocaleCompareCommand extends Command
{
    use LocaleOption;
    use WithSymfonyStyle;

    #[Inject]
    protected ResourceLocatorInterface $locator;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('locale:compare')
             ->setHelp('This command compare two locales dictionaries. A list of all locale keys found in the left locale and not found in the right locale will be generated, as well as a list of all keys with empty values and/or duplicate values. This can be helpful to list all values in a specific languages that are present, but might need translation.')
             ->addOption('left', 'l', InputOption::VALUE_REQUIRED, 'The base locale to compare against.')
             ->addOption('right', 'r', InputOption::VALUE_REQUIRED, 'The second locale to compare.')
             ->addOption('length', null, InputOption::VALUE_REQUIRED, 'Set the length for preview column text.', 50)
             ->setDescription('This command compare two locales translation files.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Locale Comparison');

        // Get locale to compare
        $leftLocale = $this->getLocale((string) $input->getOption('left'));
        $rightLocale = $this->getLocale((string) $input->getOption('right'));

        $this->io->section("Comparing `{$leftLocale->getIdentifier()}` with `{$rightLocale->getIdentifier()}`");

        // Get dictionary for both locales
        $leftDictionary = new Dictionary($leftLocale, $this->locator);
        $rightDictionary = new Dictionary($rightLocale, $this->locator);

        // Display all relevant tables
        $this->compareDictionaries($leftDictionary, $rightDictionary);
        $this->dictionariesKeys($leftDictionary, $rightDictionary);
        $this->dictionariesValues($leftDictionary, $rightDictionary);
        $this->emptyValues($rightDictionary);

        // Done
        return self::SUCCESS;
    }

    /**
     * Display dictionary comparison table.
     *
     * @param DictionaryInterface $leftDictionary
     * @param DictionaryInterface $rightDictionary
     */
    protected function compareDictionaries(DictionaryInterface $leftDictionary, DictionaryInterface $rightDictionary): void
    {
        $this->io->section("Comparison between {$rightDictionary->getLocale()->getName()} and {$leftDictionary->getLocale()->getName()}");

        $diff = Compare::dictionaries($leftDictionary, $rightDictionary);

        $table = new Table($this->io);
        $table->setHeaders(['Key', $leftDictionary->getLocale()->getIdentifier(), $rightDictionary->getLocale()->getIdentifier()]);
        $table->setColumnMaxWidth(1, 50);
        $table->setColumnMaxWidth(2, 50);

        if (count($diff) === 0) {
            $table->addRow([new TableCell('No difference between the two locales.', ['colspan' => 3])]);
        } else {
            foreach ($diff as $key => $value) {
                $table->addRow([
                    $key,
                    $leftDictionary->get($key),
                    $rightDictionary->get($key),
                ]);
            }
        }

        $table->render();
    }

    /**
     * Display dictionary keys comparison table.
     *
     * @param DictionaryInterface $leftDictionary
     * @param DictionaryInterface $rightDictionary
     */
    protected function dictionariesKeys(DictionaryInterface $leftDictionary, DictionaryInterface $rightDictionary): void
    {
        $this->io->section("Missing keys from {$rightDictionary->getLocale()->getName()} found in {$leftDictionary->getLocale()->getName()}");

        $diff = Compare::dictionariesKeys($leftDictionary, $rightDictionary);

        $table = new Table($this->io);
        $table->setHeaders(['Key', $leftDictionary->getLocale()->getIdentifier(), $rightDictionary->getLocale()->getIdentifier()]);
        $table->setColumnMaxWidth(1, 50);

        if (count($diff) === 0) {
            $table->addRow([new TableCell('No missing keys.', ['colspan' => 3])]);
        } else {
            foreach ($diff as $key) {
                $table->addRow([
                    $key,
                    $leftDictionary->get($key),
                    $rightDictionary->get($key),
                ]);
            }
        }

        $table->render();
    }

    /**
     * Display dictionary values comparison table.
     *
     * @param DictionaryInterface $leftDictionary
     * @param DictionaryInterface $rightDictionary
     */
    protected function dictionariesValues(DictionaryInterface $leftDictionary, DictionaryInterface $rightDictionary): void
    {
        $this->io->section("Same values found in both {$leftDictionary->getLocale()->getName()} and {$rightDictionary->getLocale()->getName()} locale");
        //$this->io->writeln("Theses keys might required to be translated");

        $diff = Compare::dictionariesValues($leftDictionary, $rightDictionary);

        $table = new Table($this->io);
        $table->setHeaders(['Key', $leftDictionary->getLocale()->getIdentifier(), $rightDictionary->getLocale()->getIdentifier()]);
        $table->setColumnMaxWidth(1, 50);
        $table->setColumnMaxWidth(2, 50);

        foreach ($diff as $key => $value) {
            $table->addRow([
                $key,
                $leftDictionary->get($key),
                $rightDictionary->get($key),
            ]);
        }

        $table->render();
    }

    /**
     * Display locale empty values table.
     *
     * @param DictionaryInterface $dictionary
     */
    protected function emptyValues(DictionaryInterface $dictionary): void
    {
        $this->io->section("Empty values for {$dictionary->getLocale()->getName()} locale");

        $diff = Compare::dictionariesEmptyValues($dictionary);

        $table = new Table($this->io);
        $table->setHeaders(['Key']);

        if (count($diff) === 0) {
            $table->addRow(['No empty values.']);
        } else {
            foreach ($diff as $key => $value) {
                $table->addRow([$value]);
            }
        }

        $table->render();
    }
}
