<?php

namespace Heystack\Core\State\Backends;

use Doctrine\Common\Cache\CacheProvider;
use Heystack\Core\State\BackendInterface;
use Heystack\Core\Traits\HasCacheServiceTrait;

/**
 * A DoctrineCache based implementation for state
 *
 * @package Heystack\Core\State\Backends
 */
class DoctrineCache implements BackendInterface
{
    use HasCacheServiceTrait;

    /**
     * The key to use for tracking keys added to DoctrineCache by this backend
     */
    const TRACKING_KEY = 'doctrinecache.keys';

    /**
     * @var array|null
     */
    private $keys;

    /**
     * @var string
     */
    private $prefix = '';

    /**
     * @param CacheProvider $cacheService
     * @param string|void $prefix
     */
    public function __construct(CacheProvider $cacheService, $prefix = null)
    {
        $this->cacheService = $cacheService;

        if (!is_null($prefix)) {
            $this->prefix = $prefix;
        }

        // Sets up keys
        $this->getKeys();
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        if (!$this->keys) {
            $this->keys = $this->getByKey(self::TRACKING_KEY);

            if (!is_array($this->keys)) {
                $this->keys = [];
            }
        }

        return $this->keys;
    }

    /**
     * @param $key
     * @param $var
     */
    public function setByKey($key, $var)
    {
        $this->cacheService->save($this->key($key), $var);

        $this->addKey($key);
    }

    /**
     * @param $key
     * @return array|string
     */
    public function getByKey($key)
    {
        return $this->cacheService->fetch($this->key($key));
    }

    /**
     * @param $key
     * @return bool
     */
    public function removeByKey($key)
    {
        return $this->cacheService->delete($this->key($key));
    }

    /**
     * @param array $exclude
     */
    public function removeAll(array $exclude = [])
    {
        if (is_array($this->keys)) {
            foreach (array_diff($this->keys, $exclude) as $key) {
                $this->removeByKey($key);
            }
        }
    }

    /**
     * @param $key
     */
    protected function addKey($key)
    {
        $this->keys[$key] = $key;

        $this->cacheService->save($this->key(self::TRACKING_KEY), $this->keys);
    }

    /**
     * @param $key
     * @return string
     */
    protected function key($key)
    {
        if (!isset($_SESSION)) {
            \Session::start();
        }
        return sprintf(
            "%s_%s%s",
            session_id(),
            $this->prefix,
            $key
        );
    }
}