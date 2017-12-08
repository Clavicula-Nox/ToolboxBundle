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

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
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
                ->scalarNode('cache_path')
                    ->validate()
                        ->ifString()
                        ->then(function($value) {
                            if (!is_dir($value)) {

                            }
                            var_dump(is_dir($value));
                            var_dump($value);
                            die();
                            return $value;
                        })
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
