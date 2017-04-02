<?php
/**
 * jacky_bot/CommandInjectionInterface.php
 * Created by: Nathan
 * Date: 02/04/2017
 */

namespace Jacky\Commands;


use Jacky\Config\ConfigurationWrapper;

/**
 * Interface CommandInjectionInterface
 * Defined for command with dependency injection
 * @package Jacky\Commands
 */
interface CommandInjectionInterface
{
    public function setConfiguration(ConfigurationWrapper $configuration);
}