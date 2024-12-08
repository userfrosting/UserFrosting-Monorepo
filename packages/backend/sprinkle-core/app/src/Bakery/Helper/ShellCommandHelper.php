<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery\Helper;

use Symfony\Component\Console\Command\Command;

trait ShellCommandHelper
{
    /**
     * Execute shell command and return exit code.
     *
     * @param string $command Shell command to execute
     *
     * @return int Return code from passthru
     */
    protected function executeCommand(string $command): int
    {
        $this->io->writeln("> <comment>$command</comment>");
        $exitCode = 0;
        passthru($command, $exitCode);

        return $exitCode;
    }
}
