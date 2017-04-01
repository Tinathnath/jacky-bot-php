<?php
/**
 * jacky_bot/Configuration.php
 * Created by: Nathan
 * Date: 14/03/2017
 */

namespace Jacky\Config;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * Object representation of the YAML configuration file
 * @package Jacky\Config
 */
class ConfigurationTree implements ConfigurationInterface
{
    /**
     * Creates the TreeBuilder
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jacky');
        $rootNode
            ->children()
                ->scalarNode('default_prefix')
                    ->isRequired()
                    ->defaultValue('mention')
                ->end()
                ->scalarNode('description')
                    ->defaultValue(null)
                ->end()
                ->arrayNode('redis')
                    ->children()
                        ->scalarNode('host')
                            ->defaultValue('127.0.0.1')
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

}