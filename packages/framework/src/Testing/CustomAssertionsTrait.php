<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Testing;

use DOMDocument;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

/**
 * Case for test that requires the full App instance.
 * This can be used for HTTP testing against the real deal.
 */
trait CustomAssertionsTrait
{
    /**
     * Verify that the given string is an exact match for the body returned.
     *
     * @param string            $expected The expected string
     * @param ResponseInterface $response The response
     */
    protected function assertResponse(string $expected, ResponseInterface $response): void
    {
        $this->assertSame($expected, (string) $response->getBody());
    }

    /**
     * Verify that the given response has the expected status code.
     *
     * @param int               $expected The expected code
     * @param ResponseInterface $response The response
     */
    protected function assertResponseStatus(int $expected, ResponseInterface $response): void
    {
        $this->assertSame($expected, $response->getStatusCode());
    }

    /**
     * Verify that the given array is an exact match for the JSON returned.
     *
     * @param mixed[]|mixed     $expected The expected array. Can be mixed when $key is used.
     * @param ResponseInterface $response The response
     * @param string|null       $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonResponse(mixed $expected, ResponseInterface $response, ?string $key = null): void
    {
        $actual = (string) $response->getBody();
        $this->assertJsonEquals($expected, $actual, $key);
    }

    /**
     * Verify that the given array is an exact match for the JSON returned.
     *
     * @param mixed[]|mixed     $expected The expected array. Can be mixed when $key is used.
     * @param ResponseInterface $response The response
     * @param string|null       $key      Scope to the key if required. Support dot notation.
     */
    protected function assertNotJsonResponse(mixed $expected, ResponseInterface $response, ?string $key = null): void
    {
        $actual = (string) $response->getBody();
        $this->assertJsonNotEquals($expected, $actual, $key);
    }

    /**
     * Asserts json is equals to something.
     *
     * @param mixed                    $expected Expected structure
     * @param string|ResponseInterface $json     The json string
     * @param string|null              $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonEquals(mixed $expected, string|ResponseInterface $json, ?string $key = null): void
    {
        if ($json instanceof ResponseInterface) {
            $json = (string) $json->getBody();
        }

        $this->assertJson($json);
        $this->assertEquals($expected, $this->decodeJson($json, $key));
    }

    /**
     * Asserts json is the same as something expected.
     *
     * @param mixed                    $expected Expected structure
     * @param string|ResponseInterface $json     The json string
     * @param string|null              $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonSame(mixed $expected, string|ResponseInterface $json, ?string $key = null): void
    {
        if ($json instanceof ResponseInterface) {
            $json = (string) $json->getBody();
        }

        $this->assertJson($json);
        $this->assertSame($expected, $this->decodeJson($json, $key));
    }

    /**
     * Asserts json is not equals to something.
     *
     * @param mixed                    $expected Expected structure
     * @param string|ResponseInterface $json     The json string
     * @param string|null              $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonNotEquals(mixed $expected, string|ResponseInterface $json, ?string $key = null): void
    {
        if ($json instanceof ResponseInterface) {
            $json = (string) $json->getBody();
        }

        $this->assertJson($json);
        $this->assertNotEquals($expected, $this->decodeJson($json, $key));
    }

    /**
     * Asserts json is not the same as something else.
     *
     * @param mixed                    $expected Expected structure
     * @param string|ResponseInterface $json     The json string
     * @param string|null              $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonNotSame(mixed $expected, string|ResponseInterface $json, ?string $key = null): void
    {
        if ($json instanceof ResponseInterface) {
            $json = (string) $json->getBody();
        }

        $this->assertJson($json);
        $this->assertNotSame($expected, $this->decodeJson($json, $key));
    }

    /**
     * Asserts Json equals the passed structure.
     *
     * @param mixed[]                  $expected Expected structure
     * @param string|ResponseInterface $json     The json string
     * @param string|null              $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonStructure(array $expected, string|ResponseInterface $json, ?string $key = null): void
    {
        if ($json instanceof ResponseInterface) {
            $json = (string) $json->getBody();
        }

        $this->assertJson($json);
        $data = $this->decodeJson($json, $key);

        if (!is_array($data)) {
            throw new InvalidArgumentException("Json and key combo doesn't produce valid structure");
        }

        $this->assertSame($expected, array_keys($data));
    }

    /**
     * Asserts the json has the expected count of items at the given key.
     *
     * @param int                      $expected Expected count
     * @param string|ResponseInterface $json     The json string
     * @param string|null              $key      Scope to the key if required. Support dot notation.
     */
    protected function assertJsonCount(int $expected, string|ResponseInterface $json, ?string $key = null): void
    {
        if ($json instanceof ResponseInterface) {
            $json = (string) $json->getBody();
        }

        $this->assertJson($json);
        $data = $this->decodeJson($json, $key);

        if (!is_countable($data)) {
            throw new InvalidArgumentException("Json and key combo doesn't produce countable object");
        }

        $this->assertCount($expected, $data);
    }

    /**
     * Asserts the number of time the $tag is found in $html.
     *
     * @param int                      $expected Expected count
     * @param string|ResponseInterface $html     The HTML data string
     * @param string                   $tag      The tag to count
     */
    protected function assertHtmlTagCount(int $expected, string|ResponseInterface $html, string $tag): void
    {
        if ($html instanceof ResponseInterface) {
            $html = (string) $html->getBody();
        }

        $doc = new DOMDocument();
        $doc->loadHTML($html);
        $this->assertCount($expected, $doc->getElementsByTagName($tag));
    }

    /**
     * Decodes a json string into an array and returns it.
     *
     * @param string      $json
     * @param string|null $key  Scope to the key if required. Support dot notation.
     *
     * @return mixed
     */
    private function decodeJson(string $json, ?string $key = null): mixed
    {
        $array = json_decode($json, true, flags: JSON_THROW_ON_ERROR);
        $data = (is_null($key)) ? $array : Arr::get($array, $key);

        return $data;
    }
}
