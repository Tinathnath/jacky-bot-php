<?php
/**
 * jacky_bot/ConfigurationLoaderInterface.php
 * Created by: Nathan
 * Date: 30/03/2017
 */

namespace Jacky\Config;


/**
 * Interface ConfigurationLoaderInterface
 * @package Jacky\Config
 */
interface ConfigurationLoaderInterface
{
    public function load($directory, $file);
}