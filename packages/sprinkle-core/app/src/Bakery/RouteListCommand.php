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
use UserFrosting\Sprinkle\Core\Util\RouteList;

/**
 * route:list Bakery Command
 * Generate a list all registered routes.
 */
class RouteListCommand extends Command
{
    use WithSymfonyStyle;

    #[Inject]
    protected RouteList $routeList;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('route:list')
             ->setDescription('Generate a list all registered routes')
             ->addOption('method', null, InputOption::VALUE_REQUIRED, 'Filter the routes by method.')
             ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Filter the routes by name.')
             ->addOption('uri', null, InputOption::VALUE_REQUIRED, 'Filter the routes by uri.')
             ->addOption('action', null, InputOption::VALUE_REQUIRED, 'Filter the routes by action.')
             ->addOption('reverse', 'r', InputOption::VALUE_NONE, 'Reverse the ordering of the routes.')
             ->addOption('sort', null, InputOption::VALUE_REQUIRED, 'The column (method, uri, name, action) to sort by.', 'uri');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Registered Routes');

        try {
            $routes = $this->routeList->get(
                $input->getOption('method'),
                $input->getOption('name'),
                $input->getOption('uri'),
                $input->getOption('action'),
                $input->getOption('reverse'),
                $input->getOption('sort'),
            );
        } catch (\Exception $e) {
            $this->io->error($e->getMessage());

            return self::FAILURE;
        }

        // Display error if no routes
        if (count($routes) === 0) {
            $this->io->warning('No routes found.');

            return self::FAILURE;
        }

        // Display routes
        $this->io->table(['Method', 'URI', 'Name', 'Action'], $routes);

        return self::SUCCESS;
    }
}
