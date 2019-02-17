<?php declare(strict_types=1);

namespace WyriHaximus\Tests\React\Cache;

use ApiClients\Tools\TestUtilities\TestCase;
use React\Cache\CacheInterface;
use function React\Promise\resolve;
use WyriHaximus\React\Cache\KeyPrefix;

/**
 * @internal
 */
final class KeyPrefixTest extends TestCase
{
    public function testGet(): void
    {
        $key = 'sleutel';
        $string = '{"foo":"bar"}';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->get('prefix:' . $key, null)->shouldBeCalled()->willReturn(resolve($string));

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        self::assertSame($string, $this->await($jsonCache->get($key)));
    }

    public function testGetNullShouldBeIgnored(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->get('prefix:' . $key, null)->shouldBeCalled()->willReturn(resolve(null));

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        self::assertNull($this->await($jsonCache->get($key)));
    }

    public function testSet(): void
    {
        $key = 'sleutel';
        $string = '{"foo":"bar"}';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->set('prefix:' . $key, $string, null)->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->set($key, $string);
    }

    public function testDelete(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->delete('prefix:' . $key)->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->delete($key);
    }
}
