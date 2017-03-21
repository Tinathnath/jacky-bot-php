<?php
/**
 * jacky_bot/Parameters.php
 * Created by: Nathan
 * Date: 21/03/2017
 */

namespace Jacky\Config;


use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Parameters implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('parameters');
        $rootNode
            ->children()
                ->scalarNode('discord_api_token')
                    ->isRequired()
                ->end()
                ->scalarNode('imgur_api_token')
                ->end()
            ->end();

        return $treeBuilder;
    }
}