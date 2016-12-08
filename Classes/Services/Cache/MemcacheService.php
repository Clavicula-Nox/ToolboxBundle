<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\Classes\Services\Cache;

/**
 * Class MemcacheService
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Cache
 */
class MemcacheService
{
    const DEFAULT_TTL = 600;
    const TYPE_MEMCACHE = 1;
    const TYPE_MEMCACHED = 2;

    private $handler;

    private $memcachedEnabled = false;
    private $type = 0;

    /**
     * MemcacheService constructor.
     * @param string $host
     * @param string $port
     */
    public function __construct($host, $port)
    {
        if (class_exists('\Memcache')) {
            try {
                $this->handler = new \Memcache();
                $this->handler->connect($host, $port);
                $this->memcachedEnabled = true;
                $this->type = MemcacheService::TYPE_MEMCACHE;
            } catch (\Exception $e) {
                $this->memcachedEnabled = false;
            }
        } elseif (class_exists('\Memcached')) {
            try {
                $this->handler = new \Memcached();
                $this->handler->addServer($host, $port);
                $this->memcachedEnabled = true;
                $this->type = MemcacheService::TYPE_MEMCACHED;
            } catch (\Exception $e) {
                $this->memcachedEnabled = false;
            }
        }
    }

    /**
     * @return bool
     */
    public function isInitialized()
    {
        return $this->memcachedEnabled;
    }

    /**
     * @param string $key
     * @return null|array
     */
    public function get($key)
    {
        $cache = $this->handler->get($key);
        if (!$cache) {
            return null;
        }

        $cache = $this->getDatasFromCache($cache);
        if (is_null($cache) || !$cache || $cache['created'] + $cache['ttl'] < time()) {
            return null;
        }

        return $cache['datas'];
    }

    /**
     * @param mixed $content
     * @return string
     */
    private function convertToCache($content)
    {
        return json_encode($content);
    }

    /**
     * @param string $content
     * @return array
     */
    private function getDatasFromCache($content)
    {
        return json_decode($content, true);
    }

    /**
     * @param string $key
     * @param mixed $datas
     * @param integer $ttl
     * @return array
     */
    public function set($key, $datas, $ttl = null)
    {
        if (is_null($ttl)) {
            $ttl = MemcacheService::DEFAULT_TTL;
        }

        $cache = array (
            'created' => time(),
            'ttl' => $ttl,
            'datas' => $datas
        );

        $cache = $this->convertToCache($cache);
        if ($this->type == MemcacheService::TYPE_MEMCACHE) {
            $this->handler->set($key, $cache, 0, $ttl);
        } else {
            $this->handler->set($key, $cache, $ttl);
        }
        $cache = $this->getDatasFromCache($cache);

        return $cache['datas'];
    }
}
