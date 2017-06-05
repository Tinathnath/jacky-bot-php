<?php
/**
 * jacky_bot/Parameters.php
 * Created by: Nathan
 * Date: 21/03/2017
 */

namespace Jacky\Config;


use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Parameters
 * Object representation of the YAML parameter file
 * @package Jacky\Config
 */
class ParametersTree implements ConfigurationInterface
{
    /**
     * Creates the TreeBuilder
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('parameters');
        $rootNode
            ->children()
                ->scalarNode('discord_api_token')
                    ->isRequired()
                ->end()
                ->scalarNode('imgur_app_id')->end()
                ->scalarNode('imgur_app_secret')->end()
                ->scalarNode('redis_host')->end()
                ->scalarNode('redis_port')->end()
            ->end();

        return $treeBuilder;
    }
}