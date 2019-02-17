<?php declare(strict_types=1);

namespace WyriHaximus\React\Cache;

use React\Cache\CacheInterface;
use React\Promise\PromiseInterface;

final class KeyPrefix implements CacheInterface
{
    /** @var string */
    private $prefix;

    /** @var CacheInterface */
    private $cache;

    /**
     * @param string         $prefix
     * @param CacheInterface $cache
     */
    public function __construct(string $prefix, CacheInterface $cache)
    {
        $this->prefix = $prefix;
        $this->cache = $cache;
    }

    /**
     * @param  string           $key
     * @param  null             $default
     * @return PromiseInterface
     */
    public function get($key, $default = null)
    {
        return $this->cache->get($this->prefix . $key, $default);
    }

    /**
     * @param  string           $key
     * @param  mixed            $value
     * @param  null             $ttl
     * @return PromiseInterface
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->cache->set($this->prefix . $key, $value, $ttl);
    }

    /**
     * @param  string           $key
     * @return PromiseInterface
     */
    public function delete($key)
    {
        return $this->cache->delete($this->prefix . $key);
    }
}
