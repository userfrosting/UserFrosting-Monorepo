<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Alert;

use Illuminate\Session\ArraySessionHandler;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Alert\SessionAlertStream;
use UserFrosting\I18n\Translator;
use UserFrosting\Session\Session;

class SessionAlertStreamTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected string $key = 'alerts';
    protected string $session_id = 'foo123';

    public function testConstructor(): void
    {
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);
        $stream = new SessionAlertStream($this->key, $translator, $session);

        $this->assertInstanceOf(AlertStream::class, $stream); // @phpstan-ignore-line
        $this->assertInstanceOf(SessionAlertStream::class, $stream); // @phpstan-ignore-line
    }

    /**
     * @depends testConstructor
     */
    public function testAddMessage(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $session->shouldReceive('get')->with($this->key)->once()->andReturn(false);
        $session->shouldReceive('set')->with($this->key, [$message])->once()->andReturn(null);

        // Process
        $stream = new SessionAlertStream($this->key, $translator, $session);
        $this->assertInstanceOf(SessionAlertStream::class, $stream->addMessage('success', 'foo')); // @phpstan-ignore-line
    }

    /**
     * @depends testAddMessage
     */
    public function testAddMessageWithExistingKeyNotEmpty(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $session->shouldReceive('get')->with($this->key)->once()->andReturn([$message]);
        $session->shouldReceive('set')->with($this->key, [$message, $message])->once()->andReturn(null);

        // Process
        $stream = new SessionAlertStream($this->key, $translator, $session);
        $stream->addMessage('success', 'foo');
    }

    /**
     * @depends testConstructor
     */
    public function testResetMessageStream(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);

        // Set expectations
        $session->shouldReceive('set')->with($this->key, [])->once()->andReturn(true);

        // Process
        $stream = new SessionAlertStream($this->key, $translator, $session);
        $stream->resetMessageStream();
    }

    /**
     * @depends testConstructor
     */
    public function testAddMessageTranslated(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);

        // Data
        $key = 'FOO';
        $placeholder = ['key' => 'value'];
        $result = 'Bar';

        // Set expectations
        $translator->shouldReceive('translate')->with($key, $placeholder)->andReturn($result);
        $message = [
            'type'         => 'success',
            'message'      => 'FOO',
            'placeholders' => ['key' => 'value'],
        ];
        $session->shouldReceive('get')->with($this->key)->once()->andReturn(false);
        $session->shouldReceive('set')->with($this->key, [$message])->once()->andReturn(null);
        $session->shouldReceive('get')->with($this->key)->once()->andReturn([$message]);

        // Process
        $stream = new SessionAlertStream($this->key, $translator, $session);
        $stream->addMessageTranslated('success', $key, $placeholder); // @phpstan-ignore-line

        $translator->shouldReceive('translate')->with($key, $placeholder)->andReturn($result);
        $this->assertSame($result, $stream->messages()[0]['message']);
    }

    /**
     * @depends testResetMessageStream
     */
    public function testGetAndClearMessages(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $session->shouldReceive('get')->with($this->key)->once()->andReturn([$message]);
        $session->shouldReceive('set')->with($this->key, [])->once()->andReturn(true);
        $translator->shouldReceive('translate')->with('foo', [])->andReturn('foo');

        // Process
        $stream = new SessionAlertStream($this->key, $translator, $session);
        $this->assertSame([$message], $stream->getAndClearMessages());
    }

    /**
     * @depends testAddMessage
     * @deprecated 5.1
     */
    public function testAddValidationErrors(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $session = m::mock(Session::class);
        $validator = m::mock(\UserFrosting\Fortress\ServerSideValidator::class);

        // Set expectations
        $data = [
            'name'  => ['Name is required'],
            'email' => ['Email should be a valid email address'],
        ];
        $validator->shouldReceive('errors')->once()->andReturn($data);

        $message1 = [
            'type'         => 'danger',
            'message'      => 'Name is required',
            'placeholders' => [],
        ];
        $message2 = [
            'type'         => 'danger',
            'message'      => 'Email should be a valid email address',
            'placeholders' => [],
        ];
        $session->shouldReceive('get')->with($this->key)->andReturn(false, [$message1], [$message1, $message2]); // Save 1, Save 2, Display both
        $session->shouldReceive('set')->with($this->key, [$message1])->andReturn(null); // Save 1
        $session->shouldReceive('set')->with($this->key, [$message1, $message2])->andReturn(null); // Save 2
        $translator->shouldReceive('translate')->with($message1['message'], [])->andReturn($message1['message']);
        $translator->shouldReceive('translate')->with($message2['message'], [])->andReturn($message2['message']);

        // Process
        $stream = new SessionAlertStream($this->key, $translator, $session);
        $stream->addValidationErrors($validator);
        $this->assertSame([$message1, $message2], $stream->messages());
    }

    public function testRealSessionService(): void
    {
        // Data
        $key = 'FOO';
        $placeholder = ['key' => 'value'];
        $result = 'Bar';
        $expectedResult = [
            'type'         => 'success',
            'message'      => $result,
            'placeholders' => $placeholder,
        ];

        // Setup dependencies
        $handler = new ArraySessionHandler(60);
        $session = new Session($handler);
        $session->destroy();
        $session->start();

        // Setup Translator
        $translator = m::mock(Translator::class);
        $translator->shouldReceive('translate')->with($key, $placeholder)->andReturn($result);

        $stream = new SessionAlertStream($this->key, $translator, $session);
        $this->assertEmpty($stream->messages());
        $stream->addMessage('success', $key, $placeholder);
        $this->assertCount(1, $stream->messages());
        $this->assertSame([$expectedResult], $stream->messages());
        $this->assertCount(1, $stream->messages());
        $stream->addMessage('success', $key, $placeholder);
        $this->assertCount(2, $stream->messages());
        $this->assertSame([$expectedResult, $expectedResult], $stream->getAndClearMessages());
        $this->assertCount(0, $stream->messages());
    }
}
