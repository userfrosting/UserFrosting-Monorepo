<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery\Event;

/**
 * Base event used to aggregate sub-command in an umbrella command.
 *
 * The list of subcommands that will be run can be manipulated using this event
 * to insert custom subcommands into the callstack.
 */
abstract class AbstractAggregateCommandEvent
{
    /**
     * @param string[] $commands
     */
    public function __construct(protected array $commands = [])
    {
    }

    /**
     * @return string[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @param string[] $commands
     *
     * @return self
     */
    public function setCommands(array $commands): self
    {
        $this->commands = $commands;

        return $this;
    }

    /**
     * @param string $command
     *
     * @return self
     */
    public function addCommand(string $command): self
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * @param string[] $commands
     *
     * @return self
     */
    public function addCommands(array $commands): self
    {
        $this->commands = array_merge($this->commands, $commands);

        return $this;
    }

    /**
     * @param string $command
     *
     * @return self
     */
    public function prependCommand(string $command): self
    {
        array_unshift($this->commands, $command);

        return $this;
    }

    /**
     * @param string[] $commands
     *
     * @return self
     */
    public function prependCommands(array $commands): self
    {
        $this->commands = array_merge($commands, $this->commands);

        return $this;
    }
}
