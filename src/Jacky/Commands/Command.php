<?php
/**
 * jacky_bot/Command.php
 * Created by: Nathan
 * Date: 03/04/2017
 */

namespace Jacky\Commands;

use Discord\Discord;
use Jacky\Commands\Helpers\CommandHelper;
use Jacky\Config\ConfigurationWrapper;

/**
 * Class Command
 * Base class for commands
 * @package Jacky\Commands
 */
abstract class Command implements CommandInjectionInterface
{
    protected $config;
    protected $discord;

    /**
     * Returns content of message
     * Removes command name
     * @param $message
     * @return string
     */
    protected function getContent($message)
    {
        return CommandHelper::getCommandContent($message, $this->config->get('command_prefix'), $this->getName());
    }

    /**
     * Injects app config in command
     * @param ConfigurationWrapper $configuration
     */
    public function setConfiguration(ConfigurationWrapper $configuration)
    {
        $this->config = $configuration;
    }

    /**
     * Inject Discord client in command
     * @param $discord
     */
    public function setDiscord(Discord $discord)
    {
        $this->discord = $discord;
    }
}