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

/**
 * Class CommandLock
 * @package ClaviculaNox\CNToolboxBundle\Classes\Services\Tools
 */
class CommandLock
{
    protected $FileSystemCacheService;

    private $lockPattern = 'commandLock_';

    /**
     * CommandLock constructor.
     * @param FileSystemCacheService $FileSystemCacheService
     */
    public function __construct(FileSystemCacheService $FileSystemCacheService)
    {
        $this->FileSystemCacheService = $FileSystemCacheService;
    }

    /**
     * @param string $name
     * @param array $params
     * @param int $ttl
     */
    public function lock($name, $params = array(), $ttl = 3600)
    {
        $this->FileSystemCacheService->set($this->getHash($name, $params), 'commandLock_' . $name, $ttl);
    }

    /**
     * @param string $name
     * @param array $params
     */
    public function unlock($name, $params = array())
    {
        $this->FileSystemCacheService->deleteCacheFile($this->getHash($name, $params));
    }

    /**
     * @param string $name
     * @param array $params
     * @param bool $lock
     * @param int $ttl
     * @return bool
     */
    public function checkLock($name, $params = array(), $lock = false, $ttl = 3600, $env = '')
    {
        if ($env == 'dev') {
            return true;
        }

        $hash = $this->getHash($name, $params);
        $locker = $this->FileSystemCacheService->get($hash);
        if ($lock === true && is_null($locker)) {
            $this->lock($name, $params, $ttl);

            return true;
        } elseif (is_null($locker)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $name
     * @param array $params
     * @return string
     */
    private function getHash($name, $params = array())
    {
        $lock = $this->lockPattern . $name;
        foreach ($params as $param)
        {
            $lock .= $param;
        }

        return sha1($lock);
    }
}
