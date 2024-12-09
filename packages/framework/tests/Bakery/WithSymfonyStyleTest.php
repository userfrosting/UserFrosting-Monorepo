<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Bakery;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use UserFrosting\Bakery\WithSymfonyStyle;
use UserFrosting\Testing\BakeryTester;

/**
 * Tests WithSymfonyStyle class and BakeryTester at the same time.
 */
class WithSymfonyStyleTest extends TestCase
{
    public function testWithSymfonyStyle(): void
    {
        $command = new WithSymfonyStyleStub();
        $result = BakeryTester::runCommand($command, userInput: ['FooBar']);

        // Assertions
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('FooBar', $result->getDisplay());
        $this->assertInstanceOf(SymfonyStyle::class, $command->getIO());
    }
}

class WithSymfonyStyleStub extends Command
{
    use WithSymfonyStyle;

    // @phpstan-ignore-next-line
    protected function configure()
    {
        $this->setName('WithSymfonyStyleStub');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ask = $this->io->ask('String');
        $this->io->write(strval($ask));

        return self::SUCCESS;
    }

    // @phpstan-ignore-next-line (Done on purpose)
    public function getIO()
    {
        return $this->io;
    }
}
