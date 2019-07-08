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

    public function getMultiple(array $keys, $default = null)
    {
        foreach ($keys as $index => $key) {
            $keys[$index] = $this->prefix . $key;
        }

        return $this->cache->getMultiple($keys);
    }

    public function setMultiple(array $values, $ttl = null)
    {
        $newValues = [];
        foreach ($values as $key => $value) {
            $newValues[$this->prefix . $key] = $value;
        }

        return $this->cache->setMultiple($newValues);
    }

    public function deleteMultiple(array $keys)
    {
        foreach ($keys as $index => $key) {
            $keys[$index] = $this->prefix . $key;
        }

        return $this->cache->deleteMultiple($keys);
    }

    public function clear()
    {
        return $this->cache->clear();
    }

    public function has($key)
    {
        return $this->cache->has($this->prefix . $key);
    }
}
