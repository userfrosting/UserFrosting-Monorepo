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

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Sprinkle\Core\Bakery\Event\DebugCommandEvent;
use UserFrosting\Sprinkle\Core\Bakery\Event\DebugVerboseCommandEvent;

/**
 * Debug CLI tool.
 */
class DebugCommand extends Command
{
    use WithSymfonyStyle;

    /**
     * @var string[] Commands to run
     */
    protected array $commands = [
        'debug:version',
        'sprinkle:list',
        'debug:config',
        'debug:db',
    ];

    /**
     * @var string[] Commands to run when in verbose mode
     */
    protected array $verboseCommands = [
        'debug:mail',
        'debug:locator',
        'debug:events',
        'debug:twig',
    ];

    /**
     * Inject dependencies.
     *
     * @param \UserFrosting\Event\EventDispatcher $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug')
             ->setDescription('Test the UserFrosting installation and database setup')
             ->setHelp("This command is used to check if the various dependencies of UserFrosting are met and display useful debugging information. \nIf any error occurs, check out the online documentation for more info about that error. \nThis command also provide the necessary tools to test the setup of the database credentials");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Symfony\Component\Console\Application */
        $application = $this->getApplication();

        // Run the associated commands
        // If they fail, we fail too
        foreach ($this->aggregateCommands() as $commandName) {
            $command = $application->find($commandName);
            $result = $command->run($input, $output);

            if ($result !== self::SUCCESS) {
                return $result;
            }
        }

        // Show child debug commands on verbose mode
        // Failed verbose command won't fail the main command
        if ($this->io->isVerbose()) {
            // Run the associated commands
            foreach ($this->aggregateVerboseCommands() as $commandName) {
                $command = $application->find($commandName);
                $result = $command->run($input, $output);
            }
        }

        // Command return success
        return self::SUCCESS;
    }

    /**
     * Aggregate commands to run using DebugCommandEvent.
     *
     * @return string[]
     */
    protected function aggregateCommands(): array
    {
        $event = new DebugCommandEvent($this->commands);
        $event = $this->eventDispatcher->dispatch($event);

        return $event->getCommands();
    }

    /**
     * Aggregate commands to run using DebugVerboseCommandEvent.
     *
     * @return string[]
     */
    protected function aggregateVerboseCommands(): array
    {
        $event = new DebugVerboseCommandEvent($this->verboseCommands);
        $event = $this->eventDispatcher->dispatch($event);

        return $event->getCommands();
    }
}
