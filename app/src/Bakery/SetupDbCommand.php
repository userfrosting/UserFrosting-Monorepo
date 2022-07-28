<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Collection;
use PDOException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\Helper\DbParamTester;
use UserFrosting\Support\DotenvEditor\DotenvEditor;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * DB Setup Wizard CLI Tools. Helper command to setup database config in .env file.
 */
class SetupDbCommand extends Command
{
    use WithSymfonyStyle;

    /**
     * @var string Path to the .env file
     */
    protected string $envPath = 'sprinkles://.env';

    /**
     * Inject services.
     */
    public function __construct(
        protected ResourceLocatorInterface $locator,
        protected Config $config,
        protected DotenvEditor $dotenvEditor,
        protected DbParamTester $dbTester,
        protected Capsule $capsule,
        protected ContainerInterface $ci,
    ) {
        $this->dotenvEditor->autoBackup(false);

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        // Get available db drivers
        $drivers = implode(', ', $this->getDatabaseDriversList());

        // Wrap method in a try catch to suppress any errors.
        // Exception will be properly formatted when the command is run.
        try {
            $path = $this->getEnvPath();
        } catch (Exception $e) {
            $path = '';
        }

        $this->setName('setup:db')
             ->setDescription('UserFrosting Database Configuration Wizard')
             ->setHelp("Helper command to setup the database configuration. This can also be done manually by editing the <comment>$path</comment> file or using global server environment variables.")
             ->addOption('force', null, InputOption::VALUE_NONE, 'Force setup if db is already configured')
             ->addOption('db_driver', null, InputOption::VALUE_OPTIONAL, "The database driver $drivers")
             ->addOption('db_name', null, InputOption::VALUE_OPTIONAL, 'The database name')
             ->addOption('db_host', null, InputOption::VALUE_OPTIONAL, 'The database hostname')
             ->addOption('db_port', null, InputOption::VALUE_OPTIONAL, 'The database port')
             ->addOption('db_user', null, InputOption::VALUE_OPTIONAL, 'The database user')
             ->addOption('db_password', null, InputOption::VALUE_OPTIONAL, 'The database password');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Display header,
        $this->io->title("UserFrosting's Database Setup Wizard");

        // Get env file path
        try {
            $envPath = $this->getEnvPath();
        } catch (Exception $e) {
            $this->io->error($e->getMessage());

            return self::FAILURE;
        }

        // Display debug data in verbose mode.
        if ($this->io->isVerbose()) {
            $this->io->note("Save path for database credentials : $envPath");
        }

        // Get command options
        $force = (bool) $input->getOption('force');

        // Get default db connection from the config.
        $defaultConnection = $this->getDefaultConnection();

        // Check if db is already setup
        if ($force === false) {
            try {
                $this->dbTester->test($defaultConnection);
                $this->io->note('Database already setup. Use the `php bakery setup:db --force` command to run db setup again.');

                return self::SUCCESS;
            } catch (PDOException $e) {
                // Do nothing, we're here to fix this.
            }
        }

        // Get an instance of the DotenvEditor, then save to make sure empty
        // file is created if none exist before reading it.
        $this->dotenvEditor->load($envPath);
        $this->dotenvEditor->save();

        // Ask for database info
        try {
            $dbParams = $this->askForDatabase($input);
        } catch (Exception $e) {
            $this->io->error($e->getMessage());

            return self::FAILURE;
        }

        // Test database
        try {
            $this->dbTester->test($dbParams);
            $this->io->success('Database connection successful');
        } catch (PDOException $e) {
            $message = "Could not connect to the database '{$dbParams['username']}@{$dbParams['host']}/{$dbParams['database']}':" . PHP_EOL;
            $message .= 'Exception: ' . $e->getMessage() . PHP_EOL . PHP_EOL;
            $message .= 'Please check your database configuration and/or google the exception shown above and run the command again.';
            $this->io->error($message);

            return self::FAILURE;
        }

        // Time to save
        $this->io->section('Saving data');

        // Prepare file content
        // N.B.: Can't use the `$dbParams` keys directly since they differ from
        // the config one later used to update the config
        $fileContent = [
            'DB_CONNECTION' => $dbParams['driver'],
            'DB_HOST'       => $dbParams['host'],
            'DB_PORT'       => $dbParams['port'],
            'DB_NAME'       => $dbParams['database'],
            'DB_USER'       => $dbParams['username'],
            'DB_PASSWORD'   => $dbParams['password'],
        ];
        foreach ($fileContent as $key => $value) {
            $this->dotenvEditor->setKey($key, $value);
        }
        $this->dotenvEditor->save();

        // Update current services
        $this->updateServices($dbParams);

        // Success
        $this->io->success("Database config successfully saved in `{$envPath}`");

        return self::SUCCESS;
    }

    /**
     * Ask for database credentials.
     *
     * @param InputInterface $args Command arguments
     *
     * @return array<string, string> The database credentials
     */
    protected function askForDatabase(InputInterface $args): array
    {
        // Get the db driver choices
        $drivers = $this->databaseDrivers();
        $driversList = $drivers->pluck('name')->toArray();

        // Ask for database type if not defined in command arguments
        if ($args->getOption('db_driver') == true) {
            $selectedDriver = $args->getOption('db_driver');
            $driver = $drivers->where('driver', $selectedDriver)->first();
        } else {
            $selectedDriver = $this->io->choice('Database type', $driversList);
            $driver = $drivers->where('name', $selectedDriver)->first();
        }

        // Get the selected driver. Make sure driver was found
        if (!is_array($driver)) {
            throw new Exception('Invalid database driver: ' . strval($selectedDriver));
        }

        // Ask further questions based on driver
        if ($driver['driver'] == 'sqlite') {
            $path = $args->getOption('db_name');
            $path = ($path == true) ? $path : $this->io->ask('Database path', $driver['defaultDBName']);

            // Check if file exists, attempt to create it otherwise
            if (!file_exists($path)) {
                $this->io->warning("Database file `$path` does not exist. Attempting to create it.");
                if (!touch($path)) {
                    throw new Exception("Unable to create database file `$path`");
                }
            }

            return [
                'driver'   => 'sqlite',
                'host'     => '127.0.0.1',
                'port'     => '',
                'database' => strval($path),
                'username' => '',
                'password' => '',
            ];
        } else {
            $host = $args->getOption('db_host');
            $host = ($host == true) ? $host : $this->io->ask('Hostname', 'localhost');

            $port = $args->getOption('db_port');
            $port = ($port == true) ? $port : $this->io->ask('Port', $driver['defaultPort']);

            $path = $args->getOption('db_name');
            $path = ($path == true) ? $path : $this->io->ask('Database name', $driver['defaultDBName']);

            $user = $args->getOption('db_user');
            $user = ($user == true) ? $user : $this->io->ask('Username', 'userfrosting');

            // Use custom validator to accept empty password
            $password = $args->getOption('db_password');
            $password = ($password == true) ? $password : $this->io->askHidden('Password', function ($password) {
                return $password;
            });

            return [
                'driver'   => strval($driver['driver']),
                'host'     => strval($host),
                'port'     => strval($port),
                'database' => strval($path),
                'username' => strval($user),
                'password' => strval($password),
            ];
        }
    }

    /**
     * Get the default database connection based on the config.
     *
     * @return string[]
     */
    protected function getDefaultConnection(): array
    {
        // Get current database config
        $defaultConnectionName = $this->config->getString('db.default');

        /** @var string[] */
        $defaultConnection = $this->config->getArray('db.connections.' . $defaultConnectionName);

        return $defaultConnection;
    }

    /**
     * Return the database choices for the env setup.
     *
     * @return Collection<string, string|int>
     */
    protected function databaseDrivers(): Collection
    {
        return collect([
            [
                'driver'        => 'mysql',
                'name'          => 'MySQL / MariaDB',
                'defaultDBName' => 'userfrosting',
                'defaultPort'   => 3306,
            ],
            [
                'driver'        => 'pgsql',
                'name'          => 'ProgreSQL',
                'defaultDBName' => 'userfrosting',
                'defaultPort'   => 5432,
            ],
            [
                'driver'        => 'sqlsrv',
                'name'          => 'SQL Server',
                'defaultDBName' => 'userfrosting',
                'defaultPort'   => 1433,
            ],
            [
                'driver'        => 'sqlite',
                'name'          => 'SQLite',
                'defaultDBName' => $this->locator->getResource('database://userfrosting.db', true),
                'defaultPort'   => null,
            ],
        ]);
    }

    /**
     * Returns a list of available drivers.
     *
     * @return string[]
     */
    protected function getDatabaseDriversList(): array
    {
        $dbDriverList = $this->databaseDrivers();
        $dbDriverList = $dbDriverList->pluck('driver');

        return $dbDriverList->toArray();
    }

    /**
     * Returns the path to the .env file.
     *
     * @return string
     */
    protected function getEnvPath(): string
    {
        $path = $this->locator->findResource($this->envPath, all: true);

        if ($path === null) {
            throw new Exception('Could not find .env file');
        }

        return $path;
    }

    /**
     * Update running services with the new database config.
     *
     * At this point, config is still using the "old env values".
     * We need to refresh them manually for any remaining task in this
     * execution, especially when this command is run inside `bake` command.
     * It's a bit hacky, as config might not be using the env
     * values att all, but it's the easiest way other than
     * re-initializing the config class (and actually ArrayFileLoader).
     *
     * @param array<string, string> $dbParams The database credentials
     */
    protected function updateServices(array $dbParams): void
    {
        // Update config first
        $this->config->set('db.default', $dbParams['driver']);
        $driverConfig = $this->config->getArray('db.connections.' . $dbParams['driver']);
        $driverConfig = array_merge($driverConfig, $dbParams);
        $this->config->set('db.connections.' . $dbParams['driver'], $driverConfig);

        // Also set the default connection to the new value in the db.
        $this->capsule->addConnection($dbParams, $dbParams['driver']);
        $this->capsule->getDatabaseManager()->setDefaultConnection($dbParams['driver']);

        // Update Capsule and Builder services
        $connection = $this->capsule->getConnection($dbParams['driver']);
        $this->ci->set(Connection::class, $connection);
        $this->ci->set(Builder::class, $connection->getSchemaBuilder());
    }
}
