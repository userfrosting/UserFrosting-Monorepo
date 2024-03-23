<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests\Integration\Listeners;

use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLoginEvent;
use UserFrosting\Sprinkle\Account\Testing\WithTestUser;
use UserFrosting\Sprinkle\Admin\Listener\UserRedirectedToSettings;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Theme\AdminLTE\Listener\UserRedirectedToIndex;

class UserRedirectedToSettingsTest extends AdminTestCase
{
    use RefreshDatabase;
    use WithTestUser;

    /**
     * Setup test database for controller tests
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testEventForNoPermission(): void
    {
        $event = new UserRedirectedAfterLoginEvent();
        $this->assertNull($event->getRedirect());

        /** @var UserRedirectedToIndex */
        $listener = $this->ci->get(UserRedirectedToSettings::class);
        $listener($event);

        $this->assertNull($event->getRedirect());
    }

    public function testEvent(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['uri_account_settings']);

        $event = new UserRedirectedAfterLoginEvent();
        $this->assertNull($event->getRedirect());

        /** @var UserRedirectedToIndex */
        $listener = $this->ci->get(UserRedirectedToSettings::class);
        $listener($event);

        $this->assertSame('/account/settings', $event->getRedirect());
    }
}
