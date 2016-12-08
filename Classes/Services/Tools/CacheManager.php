<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\CNToolboxBundle\Classes\Services\Tools;

use ClaviculaNox\CNToolboxBundle\Classes\Services\Cache\FileSystemCacheService;
use ClaviculaNox\CNToolboxBundle\Classes\Services\Cache\MemcacheService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CacheManager
 * @package ClaviculaNox\CNToolboxBundle\Classes\Services\Tools
 */
class CacheManager
{
    protected $FileSystemCacheService;
    protected $MemcacheService;
    protected $Container;

    protected $Handler;

    /**
     * CacheManager constructor.
     * @param FileSystemCacheService $FileSystemCacheService
     * @param MemcacheService $MemcacheService
     * @param ContainerInterface $Container
     */
    public function __construct(FileSystemCacheService $FileSystemCacheService, MemcacheService $MemcacheService, ContainerInterface $Container)
    {
        $this->FileSystemCacheService = $FileSystemCacheService;
        $this->MemcacheService = $MemcacheService;
        $this->Container = $Container;

        if ($this->MemcacheService->isInitialized()) {
            $this->Handler = $this->MemcacheService;
        } else {
            $this->Handler = $this->FileSystemCacheService;
        }
    }

    /**
     * @param string $key
     * @return array|null
     */
    public function get($key)
    {
        return $this->Handler->get($key);
    }

    /**
     * @param string $key
     * @param mixed $datas
     * @param null|int $ttl
     * @return array
     */
    public function set($key, $datas, $ttl = null)
    {
        return $this->Handler->set($key, $datas, $ttl);
    }
}
