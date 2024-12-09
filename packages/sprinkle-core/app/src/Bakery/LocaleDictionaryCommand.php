<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery;

use DI\Attribute\Inject;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\I18n\Dictionary;
use UserFrosting\Sprinkle\Core\Bakery\Helper\LocaleOption;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * locale:dictionary command.
 * Print computed dictionary for the selected locale.
 *
 * @author Louis Charette
 */
class LocaleDictionaryCommand extends Command
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
        $this->setName('locale:dictionary')
             ->setHelp('This command shows the compiled dictionary for the selected locale.')
             ->addOption('locale', 'l', InputOption::VALUE_REQUIRED, 'The selected locale.')
             ->addOption('width', 'w', InputOption::VALUE_REQUIRED, 'Set the length for preview column text.', 100)
             ->setDescription('Display locale dictionary');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locale = $this->getLocale($input->getOption('locale'));

        $this->io->title("Dictionary for {$locale->getName()} locale");

        // Get dictionary for both locales
        $dictionary = new Dictionary($locale, $this->locator);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);
        $table->setColumnMaxWidth(1, (int) $input->getOption('width'));

        foreach ($dictionary->getFlattenDictionary() as $key => $value) {
            $table->addRow([
                $key, $value,
            ]);
        }

        $table->render();

        // Everything went fine, return 0 exit code
        return self::SUCCESS;
    }
}
