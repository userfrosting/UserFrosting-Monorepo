<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery;

use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;

/**
 * migrate:reset:hard Bakery Command
 * Reset the database to a clean state by dropping all table instead of
 * rollback migrations.
 */
class MigrateResetHardCommand extends Command
{
    use WithSymfonyStyle;

    /** @Inject */
    protected Capsule $db;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('migrate:reset:hard')
             ->setDescription('Force reset the whole database to an empty state, by dropping all tables.')
             ->addOption('pretend', 'p', InputOption::VALUE_NONE, 'Run in "dry run" mode.')
             ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force the operation to run without confirmation.')
             ->addOption('database', 'd', InputOption::VALUE_REQUIRED, 'The database connection to use.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Database Migration Hard Reset');

        // Get options
        $pretend = $input->getOption('pretend');
        $force = $input->getOption('force');
        $database = $input->getOption('database');

        // Set connection to the selected database
        if ($database != '') {
            $this->io->info("Running {$this->getName()} with `$database` database connection");
            $this->db->getDatabaseManager()->setDefaultConnection($database);
        }

        // Check if the hard option is used
        if ($pretend) {
            return $this->pretendHardReset();
        } else {
            return $this->performHardReset($force);
        }
    }

    /**
     * Hard reset the whole database to an empty state by dropping all tables.
     *
     * @param InputInterface $input
     */
    protected function performHardReset(bool $force): int
    {
        // Get doctrine schema Builder
        $connection = $this->db->getConnection();
        $schema = $connection->getDoctrineSchemaManager();

        // Get a list of all tables
        $tables = $schema->listTableNames();

        // Stop if nothing to drop
        if (empty($tables)) {
            $this->io->success('No tables found');

            return self::SUCCESS;
        }

        $this->io->section('Tables to drop');
        $this->io->listing($tables);

        // Confirm action
        if (!$force) {
            $this->io->warning("This will drop all existing tables from the `{$connection->getName()}` database, including some tables that might not be managed by this application. All database data will be lost! You have been warned!");
            if (!$this->io->confirm('Do you really wish to continue ?', false)) {
                return self::SUCCESS;
            }
        }

        // Drop all tables
        foreach ($tables as $table) {
            $this->io->writeln("Dropping table `$table`...");

            // Perform drop
            $schema->dropTable($table);
        }

        $this->io->success('Hard reset successful !');

        return self::SUCCESS;
    }

    /**
     * Hard reset the whole database to an empty state by dropping all tables.
     *
     * @param InputInterface $input
     */
    protected function pretendHardReset(): int
    {
        $this->io->note("Running {$this->getName()} in pretend mode");

        // Get doctrine schema Builder
        // Doctrine schema is required to bypass sqlite not supported by normal schema
        $connection = $this->db->getConnection();
        $doctrineSchema = $connection->getDoctrineSchemaManager();
        $schema = $connection->getSchemaBuilder();

        // Get a list of all tables
        $tables = $doctrineSchema->listTableNames();

        // Stop if nothing to drop
        if (empty($tables)) {
            $this->io->success('No tables found');

            return self::SUCCESS;
        }

        // List tables
        $this->io->section('Tables to drop');
        $this->io->listing($tables);

        // Pretend drop on normal schema. Doctrine schema doesn't like pretend
        foreach ($tables as $table) {
            $this->io->section("Dropping table `$table`...");

            // Perform drop
            $queries = $connection->pretend(function () use ($schema, $table) {
                $schema->drop($table);
            });

            // Display information
            $this->io->listing(array_column($queries, 'query'));
        }

        return self::SUCCESS;
    }
}
