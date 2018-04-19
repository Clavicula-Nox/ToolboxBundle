<?php

/*
 * This file is part of the ToolboxBundle.
 *
 * (c) Adrien Lochon <adrien@claviculanox.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClaviculaNox\ToolboxBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    const PATH_VALUE_EMPTY = "Toolbox cache path value is empty.";
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('toolbox');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('fs_system_cache_path')
                    ->isRequired()
                    ->validate()
                        ->ifString()
                        ->then(function ($value) {
                            if ('' == $value) {
                                throw new InvalidConfigurationException(Configuration::PATH_VALUE_EMPTY);
                            }

                            return $value;
                        })
                    ->end()
                ->end()
                ->scalarNode('fs_system_cache_path_chmod')
                ->end()
                ->integerNode('fs_system_cache_path_default_ttl')
                    ->min(0)
                ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
