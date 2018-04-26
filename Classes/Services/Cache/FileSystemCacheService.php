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
 * Class FileSystemCacheService.
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

    /* @var array */
    private static $CacheArray = [
        'created' => 0,
        'ttl' => 0,
        'datas' => null,
    ];

    /**
     * FileSystemCacheService constructor.
     *
     * @param string     $cachePath
     * @param string     $cacheChmod
     * @param int        $cacheDefaultTTL
     * @param Filesystem $Filesystem
     */
    public function __construct(string $cachePath, string $cacheChmod, int $cacheDefaultTTL, Filesystem $Filesystem)
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
        } elseif (!is_writable($this->PathToCache)) {
            throw new AccessDeniedException($this->PathToCache);
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
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
     * @param mixed  $datas
     * @param int    $ttl
     */
    public function set(string $key, $datas, int $ttl = -1): void
    {
        if (-1 === $ttl) {
            $ttl = $this->DefaultTTL;
        }
        $cache = self::$CacheArray;
        $cache['created'] = time();
        $cache['ttl'] = $ttl;
        $cache['datas'] = $datas;

        $cache = $this->convertToCache($cache);
        $this->writeCacheFile($this->getCacheFilePath($key), $cache);
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getFile(string $key): string
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
    private function deleteCacheFile(string $key): void
    {
        if ($this->Filesystem->exists($this->getCacheFilePath($key))) {
            $this->Filesystem->remove($this->getCacheFilePath($key));
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getCacheFilePath(string $key): string
    {
        return $this->PathToCache.'/'.$key.'.json';
    }

    /**
     * @param string $path
     * @param string $cache
     */
    private function writeCacheFile(string $path, string $cache): void
    {
        if ($this->Filesystem->exists($path)) {
            $this->Filesystem->remove($path);
        }

        $this->Filesystem->dumpFile($path, $cache);
    }

    /**
     * @param array $content
     *
     * @return string
     */
    private function convertToCache(array $content): string
    {
        return json_encode($content);
    }

    /**
     * @param string $content
     *
     * @return array
     */
    private function getDatasFromCache(string $content): array
    {
        $cache = json_decode($content, true);
        if (!is_array($cache)) {
            $cache = self::$CacheArray;
        }

        return $cache;
    }
}
