<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\Classes\Services\Tools;

use ClaviculaNox\ToolboxBundle\Classes\Services\Cache\FileSystemCacheService;

/**
 * Class CacheManager
 * @package ClaviculaNox\ToolboxBundle\Classes\Services\Tools
 */
class CacheManager
{
    protected $FileSystemCacheService;
    protected $Handler;

    /**
     * CacheManager constructor.
     * @param FileSystemCacheService $FileSystemCacheService
     */
    public function __construct(FileSystemCacheService $FileSystemCacheService)
    {
        $this->FileSystemCacheService = $FileSystemCacheService;
        $this->Handler = $FileSystemCacheService;
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
