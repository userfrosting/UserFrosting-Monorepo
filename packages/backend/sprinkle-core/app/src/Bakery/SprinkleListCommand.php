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
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Sprinkle\SprinkleRecipe;

/**
 * Sprinkle:list CLI tool.
 */
class SprinkleListCommand extends Command
{
    use WithSymfonyStyle;

    /**
     * @var string[] The table header
     */
    protected $headers = ['Sprinkle', 'Namespace', 'Path'];

    #[Inject]
    protected SprinkleManager $sprinkleManager;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('sprinkle:list')
             ->setDescription('List all available sprinkles and their params');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Loaded Sprinkles');

        // Get sprinkle list and Compile the routes into a displayable format.
        $sprinkles = $this->sprinkleManager->getSprinkles();
        $sprinklesTable = array_map([$this, 'mapSprinkle'], $sprinkles);

        // Display table
        $this->io->table($this->headers, $sprinklesTable);

        return self::SUCCESS;
    }

    /**
     * Map Sprinkle Class into table.
     *
     * @param SprinkleRecipe $sprinkle
     *
     * @return string[]
     */
    protected function mapSprinkle(SprinkleRecipe $sprinkle): array
    {
        return [
            'sprinkle'  => $sprinkle->getName(),
            'class'     => $sprinkle::class,
            'path'      => $sprinkle->getPath(),
        ];
    }
}
