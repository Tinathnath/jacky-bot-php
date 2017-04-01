<?php
/**
 * jacky_bot/ConfigurationLoader.php
 * Created by: Nathan
 * Date: 30/03/2017
 */

namespace Jacky\Config;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Jacky\Exception\Config\ConfigurationParsingException;

/**
 * Class ConfigurationLoader
 * @package Jacky\Config
 */
class ConfigurationLoader implements ConfigurationLoaderInterface
{
    /**
     * ConfigurationLoader constructor.
     */
    public function __construct()
    {
    }

    /**
     * Loads and parse a YAML configuration file based on the Configuration Tree Builder
     * @param $directory
     * @param $file
     * @return ConfigurationWrapper
     * @throws ConfigurationParsingException
     */
    public function load($directory, $file)
    {
        $processedConfiguration = null;
        $locator = new FileLocator(array($directory));
        $loader = new YamlConfigLoader($locator);
        $configValues = $loader->load($locator->locate($file));

        $processor = new Processor();
        $configurationTree = new ConfigurationTree();
        try{
            $processedConfiguration = $processor->processConfiguration($configurationTree, $configValues);
            return new ConfigurationWrapper('jacky', $processedConfiguration);
        }
        catch(Exception $e){
            throw new ConfigurationParsingException(sprintf("Error parsing configuration file %s/%s", $directory, $file), null, $e);
        }
    }
}