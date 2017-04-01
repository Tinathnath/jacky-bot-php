<?php
/**
 * jacky_bot/YamlConfigLoader.php
 * Created by: Nathan
 * Date: 14/03/2017
 */

namespace Jacky\Config;


use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfigLoader
 * @package Jacky\Config
 */
class YamlConfigLoader extends FileLoader
{
    /**
     * Loads a file and parses its content as YAML structure
     * @param mixed $resource
     * @param null $type
     * @return mixed
     */
    public function load($resource, $type = null)
    {
        return Yaml::parse(file_get_contents($resource));
    }

    /**
     * Used by Symfony's ConfigurationComponent to check if the file can be handled by the loader (aka the content is a YAML string)
     * @param mixed $resource
     * @param null $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo($resource, PATHINFO_EXTENSION);
    }
}