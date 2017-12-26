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
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

/**
 * Class FileSystemCacheService
 */
class FileSystemCacheService
{
    /* @var string */
    private $PathToCache;

    /* @var string */
    private $CacheChmod;

    /* @var int */
    private $DefaultTTL;

    /* @var Filesystem */
    private $Filesystem;

    /**
     * FileSystemCacheService constructor.
     * @param string $cachePath
     * @param string $cacheChmod
     * @param int $cacheDefaultTTL
     * @param Filesystem $Filesystem
     */
    public function __construct($cachePath, $cacheChmod, $cacheDefaultTTL, Filesystem $Filesystem)
    {
        $this->PathToCache = $cachePath;
        $this->CacheChmod = $cacheChmod;
        $this->DefaultTTL = $cacheDefaultTTL;
        $this->Filesystem = $Filesystem;

        if (!$this->Filesystem->exists($this->PathToCache)) {
            $this->Filesystem->mkdir($this->PathToCache, $this->CacheChmod);
            if (!is_writable($this->PathToCache)) {
                throw new AccessDeniedException($this->PathToCache);
            }
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        $fileContent = $this->getFile($key);

        if ('' != $fileContent) {
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
     * @param string $key
     * @param mixed $datas
     * @param integer|null $ttl
     */
    public function set($key, $datas, $ttl = null): void
    {
        if (is_null($ttl)) {
            $ttl = $this->DefaultTTL;
        }

        $cache = array(
            'created' => time(),
            'ttl' => intval($ttl),
            'datas' => $datas
        );

        $cache = $this->convertToCache($cache);
        $this->writeCacheFile($this->getCacheFilePath($key), $cache);
    }

    /**
     * @param string $key
     * @return string
     */
    private function getFile($key): string
    {
        if ($this->Filesystem->exists($this->getCacheFilePath($key))) {
            $return = file_get_contents($this->getCacheFilePath($key));

            return !$return ? '' : $return;
        }

        return '';
    }

    /**
     * @param string $key
     */
    private function deleteCacheFile($key)
    {
        if ($this->Filesystem->exists($this->getCacheFilePath($key))) {
            $this->Filesystem->remove($this->getCacheFilePath($key));
        }
    }

    /**
     * @param string $key
     * @return string
     */
    private function getCacheFilePath($key): string
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
            $this->Filesystem->remove($path);
        }

        $this->Filesystem->dumpFile($path, $cache);
    }

    /**
     * @param array $content
     * @return string
     */
    private function convertToCache($content): string
    {
        return json_encode($content);
    }

    /**
     * @param string $content
     * @return array
     */
    private function getDatasFromCache($content): array
    {
        return json_decode($content, true);
    }
}
