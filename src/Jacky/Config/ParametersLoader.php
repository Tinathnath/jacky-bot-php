<?php
/**
 * jacky_bot/ParametersLoader.php
 * Created by: Nathan
 * Date: 30/03/2017
 */

namespace Jacky\Config;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Jacky\Exception\Config\ConfigurationParsingException;

/**
 * Class ParametersLoader
 * @package Jacky\Config
 */
class ParametersLoader implements ConfigurationLoaderInterface
{
    /**
     * ParametersLoader constructor.
     */
    public function __construct()
    {
    }

    /**
     * Loads and parse a YAML parameter file based on the Parameter Tree Builder
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
        $parametersTree = new ParametersTree();
        try{
            $processedConfiguration = $processor->processConfiguration($parametersTree, $configValues);
            return new ConfigurationWrapper('parameters', $processedConfiguration);
        }
        catch(Exception $e){
            throw new ConfigurationParsingException(sprintf("Error parsing parameter file %s/%s", $directory, $file), null, $e);
        }
    }
}