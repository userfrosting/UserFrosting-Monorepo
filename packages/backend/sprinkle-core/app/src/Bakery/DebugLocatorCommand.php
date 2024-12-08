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
use UserFrosting\UniformResourceLocator\ResourceLocationInterface;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;
use UserFrosting\UniformResourceLocator\ResourceStreamInterface;

/**
 * debug:locator CLI tool.
 *
 * Command that list all locations and streams, with their respective path, to
 * help debugging.
 */
class DebugLocatorCommand extends Command
{
    use WithSymfonyStyle;

    #[Inject]
    protected ResourceLocatorInterface $locator;

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('debug:locator')
             ->setDescription('List all locations and streams, with their respective path, to help debugging.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Resources Locator');

        // Display base path
        $this->io->section('Root path');
        $this->io->writeln($this->locator->getBasePath());

        // Display locations
        $this->io->section('Registered Locations');
        $locations = $this->locator->getLocations();
        $locationsTable = array_map([$this, 'mapLocation'], $locations);
        $this->io->table(['Name', 'Path'], $locationsTable);

        // Display Streams
        $this->io->section('Registered Streams');
        $streamsTable = $this->mapStreams($this->locator->getStreams());
        $this->io->table(['Scheme', 'Path', 'Shared'], $streamsTable);

        // Display all possibilities for each streams
        $this->io->section('Schemes Paths');
        $schemes = $this->locator->listSchemes();
        foreach ($schemes as $scheme) {
            $this->io->writeln("<info>> $scheme://</info>");
            $this->io->listing($this->getSchemePaths($scheme));
        }

        return self::SUCCESS;
    }

    /**
     * Map ResourceLocationInterface into table for display.
     *
     * @param ResourceLocationInterface $location
     *
     * @return string[]
     */
    protected function mapLocation(ResourceLocationInterface $location): array
    {
        return [
            'name' => $location->getName(),
            'path' => $location->getPath(),
        ];
    }

    /**
     * Map of ResourceStreamInterface, arranged by schemes, into table for display.
     *
     * @param ResourceStreamInterface[][] $schemes
     *
     * @return string[][]
     */
    protected function mapStreams(array $schemes): array
    {
        $rows = [];

        foreach ($schemes as $streams) {
            $newRows = array_map([$this, 'mapStream'], $streams);
            $rows = array_merge($rows, $newRows);
        }

        return $rows;
    }

    /**
     * Map ResourceStreamInterface into table for display.
     *
     * @param ResourceStreamInterface $stream
     *
     * @return string[]
     */
    protected function mapStream(ResourceStreamInterface $stream): array
    {
        return [
            'scheme' => $stream->getScheme(),
            'path'   => $stream->getPath(),
            'shared' => ($stream->isShared()) ? 'YES' : 'NO',
        ];
    }

    /**
     * Returns the available paths for the specified scheme.
     *
     * @param string $scheme The scheme to get paths for.
     *
     * @return string[] The paths for the scheme (or empty message)
     */
    protected function getSchemePaths(string $scheme): array
    {
        $resources = $this->locator->findResources($scheme . '://');

        if (count($resources) === 0) {
            return ['<comment>No resources found</comment>'];
        }

        return $resources;
    }
}
