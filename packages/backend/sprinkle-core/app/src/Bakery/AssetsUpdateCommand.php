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
final class AssetsUpdateCommand extends Command
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
            'This command will <info>update</info> npm dependencies defined in <info>package.json</info>.',
            'It will automatically download and install the latest version of frontend dependencies in the <info>node_modules</info> directory.',
            'It will install the latest possible version, ignoring <info>package-lock.json</info> file.',
            'Everything will be executed in the same dir the bakery command is executed.',
            'For more info, see <comment>https://learn.userfrosting.com/asset-management</comment>',
        ];

        $this->setName('assets:update')
             ->setDescription('Alias for `npm update` command')
             ->setHelp(implode(' ', $help));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Updating npm Dependencies');

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

        // Execute command
        $file = $path . '/package.json';
        if (!file_exists($file)) {
            $this->io->warning("$file not found. Skipping.");

            return self::SUCCESS;
        }

        if ($this->executeCommand('npm update') !== 0) {
            $this->io->error('npm dependency update has failed');

            return self::FAILURE;
        }

        // If all went well and there's no fatal errors, we are successful
        $this->io->success('Dependencies Updated');

        return self::SUCCESS;
    }
}
