<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Alert;

use Illuminate\Cache\Repository as Cache;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Alert\CacheAlertStream;
use UserFrosting\Cache\ArrayStore;
use UserFrosting\I18n\Translator;

class CacheAlertStreamTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected string $key = 'alerts';
    protected string $tag = 'foo123';

    public function testConstructor(): void
    {
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);

        $this->assertInstanceOf(AlertStream::class, $stream); // @phpstan-ignore-line
        $this->assertInstanceOf(CacheAlertStream::class, $stream); // @phpstan-ignore-line
    }

    /**
     * @depends testConstructor
     */
    public function testAddMessage(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $tags->shouldReceive('has')->with($this->key)->once()->andReturn(false);
        $tags->shouldReceive('forever')->with($this->key, [$message])->once()->andReturn(null);
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
        $this->assertInstanceOf(CacheAlertStream::class, $stream->addMessage('success', 'foo')); // @phpstan-ignore-line
    }

    /**
     * @depends testAddMessage
     */
    public function testAddMessageWithExistingKey(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $tags->shouldReceive('has')->with($this->key)->once()->andReturn(true);
        $tags->shouldReceive('get')->with($this->key)->once()->andReturn(false);
        $tags->shouldReceive('forever')->with($this->key, [$message])->once()->andReturn(null);
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
        $stream->addMessage('success', 'foo');
    }

    /**
     * @depends testAddMessageWithExistingKey
     */
    public function testAddMessageWithExistingKeyNotEmpty(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $tags->shouldReceive('has')->with($this->key)->once()->andReturn(true);
        $tags->shouldReceive('get')->with($this->key)->once()->andReturn([$message]);
        $tags->shouldReceive('forever')->with($this->key, [$message, $message])->once()->andReturn(null);
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
        $stream->addMessage('success', 'foo');
    }

    /**
     * @depends testConstructor
     */
    public function testResetMessageStream(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);

        // Set expectations
        $tags->shouldReceive('forget')->with($this->key)->once()->andReturn(true);
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
        $stream->resetMessageStream();
    }

    /**
     * @depends testConstructor
     */
    public function testAddMessageTranslated(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);

        // Data
        $key = 'FOO';
        $placeholder = ['key' => 'value'];
        $result = 'Bar';

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => $key,
            'placeholders' => $placeholder,
        ];
        $tags->shouldReceive('has')->with($this->key)->once()->andReturn(false);
        $tags->shouldReceive('has')->with($this->key)->once()->andReturn(true);
        $tags->shouldReceive('get')->with($this->key)->once()->andReturn([$message]);
        $tags->shouldReceive('forever')->with($this->key, [$message])->once()->andReturn(null);
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
        $stream->addMessageTranslated('success', $key, $placeholder); // @phpstan-ignore-line

        $translator->shouldReceive('translate')->with($key, $placeholder)->andReturn($result);
        $this->assertSame($result, $stream->messages()[0]['message']);
    }

    /**
     * @depends testAddMessageWithExistingKey
     * @depends testResetMessageStream
     */
    public function testGetAndClearMessages(): void
    {
        // Build Mock
        $translator = m::mock(Translator::class);
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);

        // Set expectations
        $message = [
            'type'         => 'success',
            'message'      => 'foo',
            'placeholders' => [],
        ];
        $tags->shouldReceive('forget')->with($this->key)->once()->andReturn(true);
        $tags->shouldReceive('has')->with($this->key)->once()->andReturn(true);
        $tags->shouldReceive('get')->with($this->key)->once()->andReturn([$message]);
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);
        $translator->shouldReceive('translate')->with('foo', [])->andReturn('foo');

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
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
        $cache = m::mock(Cache::class);
        $tags = m::mock(\Illuminate\Cache\TaggedCache::class);
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
        $tags->shouldReceive('has')->with($this->key)->andReturn(false, true, true); // Save 1, Save 2, display both
        $tags->shouldReceive('get')->with($this->key)->andReturn([$message1], [$message1, $message2]); // Save 2, Display both
        $tags->shouldReceive('forever')->with($this->key, [$message1])->once()->andReturn(null); // Save 1
        $tags->shouldReceive('forever')->with($this->key, [$message1, $message2])->once()->andReturn(null); // Save 2
        $cache->shouldReceive('tags')->with('_s' . $this->tag)->andReturn($tags);
        $translator->shouldReceive('translate')->with($message1['message'], [])->andReturn($message1['message']);
        $translator->shouldReceive('translate')->with($message2['message'], [])->andReturn($message2['message']);

        // Process
        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
        $stream->addValidationErrors($validator);
        $this->assertSame([$message1, $message2], $stream->messages());
    }

    public function testRealCacheService(): void
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
        $cache = (new ArrayStore())->instance();

        // Setup Translator
        $translator = m::mock(Translator::class);
        $translator->shouldReceive('translate')->with($key, $placeholder)->andReturn($result);

        $stream = new CacheAlertStream($this->key, $translator, $cache, $this->tag);
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
