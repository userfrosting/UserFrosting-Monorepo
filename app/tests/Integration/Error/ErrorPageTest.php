<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Error;

use UserFrosting\Sprinkle\Core\Tests\CoreTestCase as TestCase;

/**
 * Basic test for error pages. Make sure the basic functionality works.
 */
class ErrorPageTest extends TestCase
{
    public function testNotFound(): void
    {
        $request = $this->createRequest('GET', '/not-found-page');
        $response = $this->handleRequest($request);

        $this->assertResponseStatus(404, $response);
        $this->assertHtmlTagCount(1, $response, 'html');
    }

    public function testNotFoundJson(): void
    {
        $request = $this->createJsonRequest('GET', '/not-found-page');
        $response = $this->handleRequest($request);

        $this->assertResponseStatus(404, $response);
        $this->assertJsonStructure(['title', 'description', 'status'], $response);
        $this->assertJsonEquals(404, $response, 'status');
    }

    /**
     * This assume /alerts exist.
     */
    public function testBadMethod(): void
    {
        $request = $this->createJsonRequest('POST', '/alerts');
        $response = $this->handleRequest($request);

        $this->assertResponseStatus(405, $response);
        $this->assertJsonStructure(['title', 'description', 'status'], $response);
        $this->assertJsonEquals(405, $response, 'status');
    }
}
