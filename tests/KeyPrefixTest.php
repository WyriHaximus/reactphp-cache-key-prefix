<?php declare(strict_types=1);

namespace WyriHaximus\Tests\React\Cache;

use React\Cache\CacheInterface;
use function React\Promise\resolve;
use WyriHaximus\AsyncTestUtilities\AsyncTestCase;
use WyriHaximus\React\Cache\KeyPrefix;

/**
 * @internal
 */
final class KeyPrefixTest extends AsyncTestCase
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

    public function testClear(): void
    {
        $cache = $this->prophesize(CacheInterface::class);
        $cache->clear()->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->clear();
    }

    public function testDelete(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->delete('prefix:' . $key)->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->delete($key);
    }

    public function testHas(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->has('prefix:' . $key)->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->has($key);
    }

    public function testGetMultiple(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->getMultiple(['prefix:' . $key])->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->getMultiple([$key]);
    }

    public function testDeleteMultiple(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->deleteMultiple(['prefix:' . $key])->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->deleteMultiple([$key]);
    }

    public function testSetMultiple(): void
    {
        $key = 'sleutel';

        $cache = $this->prophesize(CacheInterface::class);
        $cache->setMultiple(['prefix:' . $key => 'value'])->shouldBeCalled();

        $jsonCache = new KeyPrefix('prefix:', $cache->reveal());
        $jsonCache->setMultiple([$key => 'value']);
    }
}
