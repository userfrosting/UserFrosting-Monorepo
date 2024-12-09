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
use Slim\Views\Twig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Loader\FilesystemLoader;
use UserFrosting\Bakery\WithSymfonyStyle;

/**
 * debug:twig CLI tool.
 *
 * Command that list all twig namespaces and their paths, including main paths
 */
class DebugTwigCommand extends Command
{
    use WithSymfonyStyle;

    #[Inject]
    protected FilesystemLoader $loader;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug:twig')
             ->setDescription('List all twig namespaces to help debugging.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Twig Namespaces');

        foreach ($this->loader->getNamespaces() as $namespace) {
            $slug = ($namespace === '__main__') ? '<comment>Main paths</comment>' : "<info>@$namespace</info>";
            $this->io->writeln($slug);
            $this->io->listing($this->loader->getPaths($namespace));
        }

        return self::SUCCESS;
    }
}
