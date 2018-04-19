<?php

/*
* This file is part of the ToolboxBundle.
*
* (c) Adrien Lochon <adrien@claviculanox.io>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace ClaviculaNox\ToolboxBundle\Tests\DependencyInjection;

use ClaviculaNox\ToolboxBundle\DependencyInjection\Configuration;
use ClaviculaNox\ToolboxBundle\DependencyInjection\ToolboxExtension;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ToolboxExtensionTest.
 */
class ToolboxExtensionTest extends KernelTestCase
{
    public function testInjection(): void
    {
        $builder = new ContainerBuilder();
        $params = [
            'fs_system_cache_path' => '%kernel.root_dir%/../../build/cache/toolboxbundle',
            'fs_system_cache_path_chmod' => '06644',
            'fs_system_cache_path_default_ttl' => 3600,
        ];

        $ext = new ToolboxExtension();
        $ext->load([
            'toolbox' => $params,
        ], $builder);

        foreach ($params as $key => $value) {
            $param = $builder->getParameter('toolbox.'.$key);
            $this->assertEquals($param, $value);
        }
    }

    public function testEmptyParam(): void
    {
        $builder = new ContainerBuilder();
        $params = [
            'fs_system_cache_path' => '',
            'fs_system_cache_path_chmod' => '06644',
            'fs_system_cache_path_default_ttl' => 3600,
        ];

        try {
            $ext = new ToolboxExtension();
            $ext->load([
                'toolbox' => $params,
            ], $builder);

            $this->fail('Expected Exception has not been raised.');
        } catch (InvalidConfigurationException $e) {
            $this->assertEquals($e->getMessage(), Configuration::PATH_VALUE_EMPTY);
        }
    }
}
