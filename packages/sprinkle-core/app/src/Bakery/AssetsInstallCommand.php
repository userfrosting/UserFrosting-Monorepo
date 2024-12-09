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
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Sprinkle\Core\Bakery\Helper\ShellCommandHelper;
use UserFrosting\Sprinkle\Core\Exceptions\VersionCompareException;
use UserFrosting\Sprinkle\Core\Validators\NodeVersionValidator;
use UserFrosting\Sprinkle\Core\Validators\NpmVersionValidator;

/**
 * Alias for `npm install` command.
 */
final class AssetsInstallCommand extends Command
{
    use WithSymfonyStyle;
    use ShellCommandHelper;

    #[Inject]
    protected NodeVersionValidator $nodeVersionValidator;

    #[Inject]
    protected NpmVersionValidator $npmVersionValidator;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $help = [
            'This command will <info>install</info> npm dependencies defined in <info>package.json</info>.',
            'It will automatically download and install the frontend dependencies in the <info>node_modules</info> directory.',
            'This command doesn\'t update any dependencies. It will install the version locked in the <info>package-lock.json</info> file.',
            'Everything will be executed in the same dir the bakery command is executed.',
            'For more info, see <comment>https://learn.userfrosting.com/asset-management</comment>',
        ];

        $this->setName('assets:install')
             ->setDescription('Alias for `npm install` command')
             ->setHelp(implode(' ', $help));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Installing npm Dependencies');

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

        // Install NPM
        $file = $path . '/package.json';
        if (!file_exists($file)) {
            $this->io->warning("$file not found. Skipping.");

            return self::SUCCESS;
        }

        // Check if package-lock.json exists
        $lockFile = $path . '/package-lock.json';
        if (!file_exists($lockFile)) {
            $this->io->note("Lock file `$lockFile` not found. Will install latest versions.");
        }

        // Execute command
        if ($this->executeCommand('npm install') !== 0) {
            $this->io->error('npm dependency installation has failed');

            return self::FAILURE;
        }

        // If all went well and there's no fatal errors, we are successful
        $this->io->success('Dependencies Installed');

        return self::SUCCESS;
    }
}
