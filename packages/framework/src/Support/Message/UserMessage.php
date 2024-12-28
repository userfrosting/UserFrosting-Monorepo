<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support\Message;

/**
 * A user-viewable message, consisting of a message string or message token, and zero or more parameters for the message.
 * Parameters can be used, for example, to fill in placeholders in dynamically generated messages.
 */
class UserMessage
{
    /**
     * @var string The user-viewable error message.
     */
    public string $message;

    /**
     * @var mixed[]|int The parameters to be filled in for any placeholders in the message.
     */
    public array|int $parameters = [];

    /**
     * Public constructor.
     *
     * @param string      $message
     * @param mixed[]|int $parameters The parameters to be filled in for any placeholders in the message.
     */
    public function __construct(string $message = '', array|int $parameters = [])
    {
        $this->message = $message;
        $this->parameters = $parameters;
    }
}
