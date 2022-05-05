<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;

/**
 * TODO : Leave this here for now, to test it out. Move to Account later :)
 */
trait testUserTrait
{
    use MockeryPHPUnitIntegration;

    /**
     * Set user for tests.
     *
     * @param UserInterface|null  $user
     * @param bool                $isMaster
     * @param array<string, bool> $permissions
     */
    protected function actAsUser(
        ?UserInterface $user,
        bool $isMaster = false,
        array $permissions = []
    ): void {

        /** @var Config */
        $config = $this->ci->get(Config::class);
        $masterId = ($isMaster && !is_null($user)) ? $user->id : 0;
        $config->set('reserved_user_ids.master', $masterId);

        /** @var Authenticator */
        $authenticator = Mockery::mock(Authenticator::class)
            ->makePartial()
            ->shouldReceive('user')->andReturn($user)
            ->getMock();
        $this->ci->set(Authenticator::class, $authenticator);

        if (count($permissions) !== 0) {
            /** @var AuthorizationManager */
            $authorizer = Mockery::mock(AuthorizationManager::class);
            foreach ($permissions as $permission => $value) {
                $authorizer->shouldReceive('checkAccess')
                       ->with($user, $permission, Mockery::andAnyOtherArgs())
                       ->andReturn($value);
            }
            $this->ci->set(AuthorizationManager::class, $authorizer);
        }
    }
}
