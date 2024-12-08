<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Util\Message;

/**
 * Named structs for two parts messages.
 *
 * Represent a message composed of a title and a description.
 * Used for error messages and whatnot
 * Use to replace Anonymous structs (Never* Use Arrays!)
 */
class Message
{
    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $description;

    /**
     * @param string $title
     * @param string $description
     */
    public function __construct(string $title, string $description = '')
    {
        $this->title = $title;
        $this->description = $description;
    }
}
