<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Controller;

use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;

/**
 * Tests RegisterAction
 */
class CaptchaActionTest extends AccountTestCase
{
    public function testCaptcha(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/captcha');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertNotSame('', (string) $response->getBody());
    }
}
