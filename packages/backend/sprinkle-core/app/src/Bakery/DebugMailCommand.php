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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Config\Config;

/**
 * debug:mail CLI tool.
 */
class DebugMailCommand extends Command
{
    use WithSymfonyStyle;

    /**
     * Inject services.
     */
    public function __construct(
        protected Config $config,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug:mail')
             ->setAliases(['debug:smtp'])
             ->setDescription('Display Mail Configuration');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Mail Configuration');

        // Display database info
        $this->io->definitionList(
            ['From Email'   => $this->config->get('address_book.admin.email')],
            ['From Name'    => $this->config->get('address_book.admin.name')],
            new TableSeparator(),
            ['MAILER'       => $this->config->get('mail.mailer')],
            ['HOST'         => $this->config->get('mail.host')],
            ['USERNAME'     => $this->config->get('mail.username')],
            ['PASSWORD'     => (is_string($this->config->get('mail.password')) && $this->config->get('mail.password') !== '' ? '*********' : '')],
            ['PORT'         => $this->config->get('mail.port')],
            ['AUTH'         => $this->config->get('mail.auth')],
            ['SECURE'       => $this->config->get('mail.secure')],
        );

        $this->io->info('This command does not test the mail connection. It only display the current configuration. Use the `mail:test` command to test the connection.');

        return self::SUCCESS;
    }
}
