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
use UserFrosting\Sprinkle\Core\Bakery\Event\SetupCommandEvent;

/**
 * Setup wizard CLI Tools.
 * Umbrella command used to run multiple setup sub-commands at once.
 */
final class SetupCommand extends Command
{
    use WithSymfonyStyle;

    /**
     * @param \UserFrosting\Event\EventDispatcher $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $list = implode(', ', $this->aggregateCommands());

        $this->setName('setup')
             ->setDescription('UserFrosting Configuration Wizard')
             ->setHelp('This command combine the following commands : ' . $list);
    }

    /**
     * @var string[] Commands to run
     */
    protected array $commands = [
        'setup:db',
        'setup:mail',
        'setup:env',
    ];

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Symfony\Component\Console\Application */
        $application = $this->getApplication();

        foreach ($this->aggregateCommands() as $commandName) {
            $command = $application->find($commandName);
            $command->run($input, $output);
        }

        return self::SUCCESS;
    }

    /**
     * Aggregate commands to run using SetupCommandEvent.
     *
     * @return string[]
     */
    protected function aggregateCommands(): array
    {
        $event = new SetupCommandEvent($this->commands);
        $event = $this->eventDispatcher->dispatch($event);

        return $event->getCommands();
    }
}
