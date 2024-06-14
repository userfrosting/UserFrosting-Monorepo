<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Unit\Testing;

use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use UserFrosting\Testing\CustomAssertionsTrait;

/**
 * Tests for CustomAssertionsTrait.
 *
 * Run each assertions with code we know is equals to make sure assertions are
 * rights.
 */
class CustomAssertionsTraitTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    use CustomAssertionsTrait;

    protected string $json = '{"result": {"foo":true,"bar":false,"list":["foo","bar"]}}';

    public function testAssertResponse(): void
    {
        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn('foo bar')
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->once()->andReturn($stream)
            ->getMock();

        $this->assertResponse('foo bar', $response);
    }

    public function testAssertResponseStatus(): void
    {
        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getStatusCode')->once()->andReturn(123)
            ->getMock();

        $this->assertResponseStatus(123, $response);
    }

    /** @depends testAssertJsonEquals */
    public function testAssertJsonResponse(): void
    {
        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn($this->json)
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->times(2)->andReturn($stream)
            ->getMock();

        $array = ['result' => ['foo' => true, 'bar' => false, 'list' => ['foo', 'bar']]];
        $this->assertJsonResponse($array, $response);
        $this->assertJsonResponse(['foo', 'bar'], $response, 'result.list');
    }

    /** @depends testAssertJsonNotEquals */
    public function testAssertNotJsonResponse(): void
    {
        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn($this->json)
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->times(3)->andReturn($stream)
            ->getMock();

        $this->assertNotJsonResponse(['foo'], $response);
        $this->assertNotJsonResponse(['foo'], $response, 'result.list');
        $this->assertJsonNotEquals(['foo'], $response);
    }

    public function testAssertJsonEquals(): void
    {
        $array = ['result' => ['foo' => true, 'bar' => false, 'list' => ['foo', 'bar']]];

        $this->assertJsonEquals($array, $this->json);
        $this->assertJsonEquals(['foo', 'bar'], $this->json, 'result.list');
        $this->assertJsonEquals(true, $this->json, 'result.foo');
    }

    public function testAssertJsonNotEquals(): void
    {
        $this->assertJsonNotEquals(['foo'], $this->json);
        $this->assertJsonNotEquals(['foo'], $this->json, 'result.list');
        $this->assertJsonNotEquals(false, $this->json, 'result.foo');
    }

    public function testAssertJsonEqualsWithResponse(): void
    {
        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn($this->json)
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->times(3)->andReturn($stream)
            ->getMock();

        $array = ['result' => ['foo' => true, 'bar' => false, 'list' => ['foo', 'bar']]];

        $this->assertJsonEquals($array, $response);
        $this->assertJsonEquals(['foo', 'bar'], $response, 'result.list');
        $this->assertJsonEquals(true, $response, 'result.foo');
    }

    public function testAssertJsonStructure(): void
    {
        $this->assertJsonStructure(['result'], $this->json);
        $this->assertJsonStructure(['foo', 'bar', 'list'], $this->json, 'result');
    }

    public function testAssertJsonStructureWithResponse(): void
    {
        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn($this->json)
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->times(2)->andReturn($stream)
            ->getMock();

        $this->assertJsonStructure(['result'], $response);
        $this->assertJsonStructure(['foo', 'bar', 'list'], $response, 'result');
    }

    public function testAssertJsonStructureWithError(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertJsonStructure([true], $this->json, 'result.foo');
    }

    public function testAssertJsonCount(): void
    {
        $this->assertJsonCount(1, $this->json);
        $this->assertJsonCount(3, $this->json, 'result');
        $this->assertJsonCount(2, $this->json, 'result.list');
    }

    public function testAssertJsonCountWithResponse(): void
    {
        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn($this->json)
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->times(3)->andReturn($stream)
            ->getMock();

        $this->assertJsonCount(1, $response);
        $this->assertJsonCount(3, $response, 'result');
        $this->assertJsonCount(2, $response, 'result.list');
    }

    public function testAssertJsonCountWithError(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->assertJsonCount(10, $this->json, 'result.foo');
    }

    public function testAssertHtmlTagCount(): void
    {
        $html = '<html><div>One</div><div>Two</div><span>Not You</span><div>Three</div></html>';
        $this->assertHtmlTagCount(3, $html, 'div');
        $this->assertHtmlTagCount(1, $html, 'html');
        $this->assertHtmlTagCount(1, $html, 'span');
        $this->assertHtmlTagCount(0, $html, 'p');
    }

    public function testAssertHtmlTagCountWithResponse(): void
    {
        $html = '<html><div>One</div><div>Two</div><span>Not You</span><div>Three</div></html>';

        /** @var StreamInterface $stream */
        $stream = Mockery::mock(StreamInterface::class)
           ->shouldReceive('__toString')->andReturn($html)
           ->getMock();

        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->times(4)->andReturn($stream)
            ->getMock();

        $this->assertHtmlTagCount(3, $response, 'div');
        $this->assertHtmlTagCount(1, $response, 'html');
        $this->assertHtmlTagCount(1, $response, 'span');
        $this->assertHtmlTagCount(0, $response, 'p');
    }
}
