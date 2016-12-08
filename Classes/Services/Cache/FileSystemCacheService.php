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

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileSystemCacheService
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Cache
 */
class FileSystemCacheService
{
    private $Filesystem;

    private $PathToCache;

    const DEFAULT_TTL = 600;
    const DEFAULT_CHMOD = 0775;

    /**
     * @param Filesystem $Filesystem
     */
    public function __construct(Filesystem $Filesystem)
    {
        $this->Filesystem = $Filesystem;
        $this->PathToCache = 'cache';

        if (!$this->Filesystem->exists($this->PathToCache)) {
            $this->Filesystem->mkdir($this->PathToCache, FileSystemCacheService::DEFAULT_CHMOD);
        }
    }

    /**
     * @param string $key
     * @return null|array
     */
    public function get($key)
    {
        $fileContent = $this->getFile($key);

        if ($fileContent) {
            $cache = $this->getDatasFromCache($fileContent);
            if (is_null($cache) || !$cache || $cache['created'] + $cache['ttl'] < time()) {
                $this->deleteCacheFile($key);
                return null;
            }

            return $cache['datas'];
        }

        return null;
    }

    /**
     * Check file existence before trying to open it to prevent warnings
     *
     * @param $key
     * @return bool|string
     */
    public function getFile($key)
    {
        if ($this->Filesystem->exists($this->getCacheFilePath($key))) {
            return file_get_contents($this->getCacheFilePath($key));
        }

        return false;
    }

    /**
     * @param $key
     */
    public function deleteCacheFile($key)
    {
        if ($this->Filesystem->exists($this->getCacheFilePath($key))) {
            $this->Filesystem->remove($this->getCacheFilePath($key));
        }
    }

    /**
     * @param string $key
     * @return string
     */
    private function getCacheFilePath($key)
    {
        return $this->PathToCache . '/' . $key . '.json';
    }

    /**
     * @param string $path
     * @param string $cache
     */
    private function writeCacheFile($path, $cache)
    {
        if ($this->Filesystem->exists($path)) {
            //Just in case
            $this->Filesystem->remove($path);
        }
        $this->Filesystem->dumpFile($path, $cache);
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
            $ttl = FileSystemCacheService::DEFAULT_TTL;
        }

        $cache = array(
            'created' => time(),
            'ttl' => $ttl,
            'datas' => $datas
        );

        $cache = $this->convertToCache($cache);
        $this->writeCacheFile($this->getCacheFilePath($key), $cache);
        $cache = $this->getDatasFromCache($cache);

        return $cache['datas'];
    }
}
