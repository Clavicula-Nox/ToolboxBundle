<?php

/*
* This file is part of the ToolboxBundle.
*
* (c) Adrien Lochon <adrien@claviculanox.io>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ClaviculaNox\ToolboxBundle\Tests\Services;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class FileSystemCacheServiceTest
 */
class FileSystemCacheServiceTest extends WebTestCase
{
    /* @var string*/
    private $key = 'cacheTestKey';

    /* @var array*/
    private $cache = ['keyOne' => 'valOne', 'keyTwo' => ['val2']];

    /**
     * @return KernelInterface
     */
    private function getKernel($options = []): KernelInterface
    {
        return $this->bootKernel($options);
    }

    public function testSet(): void
    {
        $this
            ->getKernel()
            ->getContainer()
            ->get("cn_toolbox.cache.filesystem")->set($this->key, $this->cache);

        $cache = $this
            ->getKernel()
            ->getContainer()
            ->get("cn_toolbox.cache.filesystem")->get($this->key);

        $this->assertTrue($this->cache === $cache);

        $this
            ->getKernel()
            ->getContainer()
            ->get("cn_toolbox.cache.filesystem")->set($this->key, $this->cache, 1);

        sleep(2);

        $cache = $this
            ->getKernel()
            ->getContainer()
            ->get("cn_toolbox.cache.filesystem")->get($this->key);

        $this->assertTrue(is_null($cache));
    }
}
