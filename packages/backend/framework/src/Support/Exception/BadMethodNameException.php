<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support\Exception;

use LogicException;

/**
 * Bad method name exception. Used when a method name is dynamically invoked,
 * but the method does not exist on the object.
 */
class BadMethodNameException extends LogicException
{
}
