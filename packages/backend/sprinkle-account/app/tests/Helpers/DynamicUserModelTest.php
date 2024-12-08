<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Helpers;

use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;

class DynamicUserModelTest extends TestCase
{
    public function testSetGetUserModel(): void
    {
        $user = new User();
        $class = new StubClass();
        $class->setUserModel($user);
        $this->assertSame($user, $class->getUserModel());
    }
}

class StubClass
{
    use DynamicUserModel;

    protected UserInterface $userModel;
}
