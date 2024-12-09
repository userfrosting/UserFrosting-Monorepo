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
use UserFrosting\Event\SprinkleListenerProvider;

/**
 * debug:events CLI tool.
 *
 * Command that list all registered event listener for each events.
 */
final class DebugEventsCommand extends Command
{
    use WithSymfonyStyle;

    #[Inject]
    protected SprinkleListenerProvider $provider;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug:events')
             ->setDescription('List all currently registered events listener for each events.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Registered Event Listeners');

        $allListeners = $this->provider->getRegisteredListeners();
        foreach ($allListeners as $event => $listeners) {
            $this->io->writeln("<info>> $event</info>");
            $this->io->listing($listeners);
        }

        return self::SUCCESS;
    }
}
