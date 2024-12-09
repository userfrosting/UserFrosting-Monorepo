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
use UserFrosting\Sprinkle\Core\Bakery\Helper\ShellCommandHelper;
use UserFrosting\Sprinkle\Core\Exceptions\VersionCompareException;
use UserFrosting\Sprinkle\Core\Validators\NodeVersionValidator;
use UserFrosting\Sprinkle\Core\Validators\NpmVersionValidator;

/**
 * Alias for `npm run webpack:dev`, `npm run webpack:build`,
 * `npm run webpack:server` and `npm run webpack:watch` commands.
 */
final class AssetsWebpackCommand extends Command
{
    use WithSymfonyStyle;
    use ShellCommandHelper;

    #[Inject]
    protected NodeVersionValidator $nodeVersionValidator;

    #[Inject]
    protected NpmVersionValidator $npmVersionValidator;

    #[Inject('UF_MODE')]
    protected string $envMode;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $help = [
            'This command run <info>Webpack Encore</info>, using the config defined in <info>webpack.config.js</info>.',
            'It will automatically compile the frontend dependencies in the <info>public/assets/</info> directory.',
            'Everything will be executed in the same dir the bakery command is executed.',
            'For more info, see <comment>https://learn.userfrosting.com/asset-management</comment>',
        ];

        $this->setName('assets:webpack')
             ->setDescription('Alias for `npm run dev`, `npm run build` or `npm run dev` command')
             ->addOption('production', 'p', InputOption::VALUE_NONE, 'Create a production build')
             ->addOption('watch', 'w', InputOption::VALUE_NONE, 'Watch for changes and recompile automatically')
             ->addOption('server', 's', InputOption::VALUE_NONE, 'Run the development server with Hot Module Replacement (HMR)')
             ->setHelp(implode(' ', $help));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Running Webpack Encore');

        // Get options
        $production = (bool) $input->getOption('production');
        $watch = (bool) $input->getOption('watch');
        $server = (bool) $input->getOption('server');

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

        // Execute Webpack
        $file = $path . '/webpack.config.js';
        if (!file_exists($file)) {
            $this->io->warning("$file not found. Skipping.");

            return self::SUCCESS;
        }

        // Select command based on command arguments
        $command = match (true) {
            ($production || $this->envMode === 'production') => 'npm run webpack:build',
            $server                                          => 'npm run webpack:server',
            $watch                                           => 'npm run webpack:watch',
            default                                          => 'npm run webpack:dev',
        };

        $this->io->info("Running command: $command");
        if ($this->executeCommand($command) !== 0) {
            $this->io->error('Webpack Encore run has failed');

            return self::FAILURE;
        }

        // If all went well and there's no fatal errors, we are successful
        $this->io->success('Webpack Encore run completed');

        return self::SUCCESS;
    }
}
