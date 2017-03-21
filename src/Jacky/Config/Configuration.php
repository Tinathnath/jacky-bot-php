<?php
/**
 * jacky_bot/Configuration.php
 * Created by: Nathan
 * Date: 14/03/2017
 */

namespace Jacky\Config;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jacky');
      /*  $rootNode
            ->children()
                ->scalarNode('discord_api_token')
                    ->isRequired()
                ->end()
            ->end();*/

        return $treeBuilder;
    }

}