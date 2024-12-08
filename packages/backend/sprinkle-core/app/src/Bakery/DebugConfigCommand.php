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
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Config\Config;

/**
 * debug:cache CLI tool.
 */
class DebugConfigCommand extends Command
{
    use WithSymfonyStyle;

    /**
     * Inject dependencies.
     *
     * @param Config $config
     */
    public function __construct(
        protected Config $config
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug:config')
             ->setDescription('Test the UserFrosting database config')
             ->setHelp('This command is used to display useful debugging information about the current configuration.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get connection
        $connection = $this->config->get('db.default');

        // Get password for later
        $password = $this->config->get('db.connections.' . $connection . '.password');

        // Display database info
        $this->io->title('Database config');
        $this->io->definitionList(
            ['CONNECTION'   => $connection],
            new TableSeparator(),
            ['DRIVER'       => $this->config->get('db.connections.' . $connection . '.driver')],
            ['HOST'         => $this->config->get('db.connections.' . $connection . '.host')],
            ['PORT'         => $this->config->get('db.connections.' . $connection . '.port')],
            ['DATABASE'     => $this->config->get('db.connections.' . $connection . '.database')],
            ['USERNAME'     => $this->config->get('db.connections.' . $connection . '.username')],
            ['PASSWORD'     => (is_string($password)) ? '*********' : '']
        );

        return self::SUCCESS;
    }
}
