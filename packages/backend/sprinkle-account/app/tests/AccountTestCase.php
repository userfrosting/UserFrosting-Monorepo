<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests;

use UserFrosting\Sprinkle\Account\Account;
use UserFrosting\Testing\TestCase;

/**
 * Test case with Core as main sprinkle
 */
class AccountTestCase extends TestCase
{
    protected string $mainSprinkle = Account::class;
}
