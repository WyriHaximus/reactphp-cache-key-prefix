<?php

declare(strict_types=1);

namespace WyriHaximus\React\Cache;

use React\Cache\CacheInterface;

final class KeyPrefix implements CacheInterface
{
    public function __construct(
        private readonly string $prefix,
        private readonly CacheInterface $cache
    ) {
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function get($key, $default = null)
    {
        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->get($this->prefix . $key, $default);
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function set($key, $value, $ttl = null)
    {
        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->set($this->prefix . $key, $value, $ttl);
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->delete($this->prefix . $key);
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function getMultiple(array $keys, $default = null)
    {
        foreach ($keys as $index => $key) {
            $keys[$index] = $this->prefix . $key;
        }

        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->getMultiple($keys);
    }

    /**
     * @inheritDoc
     * @phpstan-ignore-next-line
     */
    public function setMultiple(array $values, $ttl = null)
    {
        $newValues = [];
        /**
         * @psalm-suppress MixedAssignment
         */
        foreach ($values as $key => $value) {
            /**
             * @psalm-suppress MixedAssignment
             */
            $newValues[$this->prefix . $key] = $value;
        }

        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->setMultiple($newValues);
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(array $keys)
    {
        foreach ($keys as $index => $key) {
            $keys[$index] = $this->prefix . $key;
        }

        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->deleteMultiple($keys);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->clear();
    }

    /**
     * @inheritDoc
     */
    public function has($key)
    {
        /**
         * @psalm-suppress TooManyTemplateParams
         */
        return $this->cache->has($this->prefix . $key);
    }
}
