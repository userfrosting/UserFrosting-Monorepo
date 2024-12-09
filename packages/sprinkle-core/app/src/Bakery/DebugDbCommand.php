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

use PDOException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Sprinkle\Core\Bakery\Helper\DatabaseTest;

/**
 * debug:db CLI tool.
 */
class DebugDbCommand extends Command
{
    use DatabaseTest;
    use WithSymfonyStyle;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug:db')
             ->setDescription('Test the UserFrosting database connection')
             ->setHelp('This command provide the necessary tools to test the setup of the database credentials');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Testing database connection...');

        try {
            $this->testDB();
            $this->io->success('Database connection successful');
        } catch (PDOException $e) {
            $error = $e->getMessage();
            $this->io->error($error);

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
