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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\Helper\ShellCommandHelper;
use UserFrosting\Sprinkle\Core\Exceptions\VersionCompareException;
use UserFrosting\Sprinkle\Core\Validators\NodeVersionValidator;
use UserFrosting\Sprinkle\Core\Validators\NpmVersionValidator;

/**
 * Alias for `npm run vite:dev` and `npm run vite:build` commands.
 */
final class AssetsViteCommand extends Command
{
    use WithSymfonyStyle;
    use ShellCommandHelper;

    #[Inject]
    protected NodeVersionValidator $nodeVersionValidator;

    #[Inject]
    protected NpmVersionValidator $npmVersionValidator;

    #[Inject]
    protected Config $config;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $help = [
            'This command run <info>Vite</info>, using the config defined in <info>vite.config.js</info>.',
            'It will automatically compile the frontend dependencies in the <info>public/assets/</info> directory, or use the Vite development server',
            'Everything will be executed in the same dir the bakery command is executed.',
            'For more info, see <comment>https://learn.userfrosting.com/asset-management</comment>',
        ];

        $this->setName('assets:vite')
             ->setDescription('Alias for `npm run vite:dev` or `npm run vite:build` commands.')
             ->addOption('production', 'p', InputOption::VALUE_NONE, 'Force the creation of a production build using `vite:build`')
             ->setHelp(implode(' ', $help));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Running Vite');

        // Get options
        $forceProduction = (bool) $input->getOption('production');
        $devEnabled = $this->config->getBool('assets.vite.dev', true);

        // Validate dependencies
        try {
            $this->nodeVersionValidator->validate();
            $this->npmVersionValidator->validate();
        } catch (VersionCompareException $e) {
            $this->io->error($e->getMessage());

            return self::FAILURE;
        }

        // Get path
        $path = getcwd();
        if ($path === false) {
            $this->io->error('Error getting working directory');

            return self::FAILURE;
        }

        // Execute Vite
        if (!file_exists($path . '/vite.config.js') && !file_exists($path . '/vite.config.ts')) {
            $this->io->warning('Vite config not found. Skipping.');

            return self::SUCCESS;
        }

        // Select command based on command arguments
        $command = match (true) {
            $forceProduction, !$devEnabled => 'npm run vite:build',
            default                        => 'npm run vite:dev',
        };

        $this->io->info("Running command: $command");
        if ($this->executeCommand($command) !== 0) {
            $this->io->error('Vite command has failed');

            return self::FAILURE;
        }

        // If all went well and there's no fatal errors, we are successful
        $this->io->success('Vite command completed');

        return self::SUCCESS;
    }
}
