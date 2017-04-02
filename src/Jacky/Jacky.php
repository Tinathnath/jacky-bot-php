<?php
/**
 * jacky_bot/Jacky.php
 * Created by: Nathan
 * Date: 20/03/2017
 */

namespace Jacky;

use Discord\Discord;
use Discord\DiscordCommandClient;
use Discord\Parts\Channel\Message;
use Jacky\Config\ConfigurationWrapper;
use Jacky\Commands;

/**
 * Class Jacky
 * The main bot class
 * @package Jacky
 */
class Jacky
{
    /**
     * The discord client
     * @var DiscordCommandClient
     */
    protected $_discord;

    /**
     * The app parameters wrapper
     * @var ConfigurationWrapper
     */
    protected $_parameters;

    /**
     * The app config wrapper
     * @var ConfigurationWrapper
     */
    protected $_configuration;

    /**
     * Jacky commands
     * @var Commands\CommandInterface[]
     */
    protected $_commands = [];

    /**
     * Jacky constructor.
     * @param DiscordCommandClient $discord
     */
    public function __construct(DiscordCommandClient $discord)
    {
        $this->_discord = $discord;
    }

    /**
     * Init handlers and commands
     * @return $this
     */
    public function init()
    {
        $this->loadCommands();
        $this->registerCommands();
        $this->attachHandler();

        return $this;
    }

    /**
     * Attaches the message handler
     * @return $this
     */
    protected function attachHandler()
    {
        $this->_discord->on('ready', function(){
            $this->_discord->on('message', function($message, $params){
                $this->handleMessage($message);
            });
        });

        return $this;
    }

    protected function handleMessage(Message $message)
    {

    }

    #region Commands
    /**
     * Loads commands registered in config
     * @throws Exception\Config\ConfigurationNodeNotFoundException
     */
    private function loadCommands()
    {
        $registeredCommands = $this->_configuration->get('commands');
        foreach ($registeredCommands as $command) {
            $obj = new \ReflectionClass($command['class']);
            if($obj->implementsInterface('Jacky\Commands\CommandInterface'))
                $this->_commands[] = new $command['class'];
        }
    }

    /**
     * Register the commands towards Discord client
     * @throws \Exception
     */
    private function registerCommands()
    {
        foreach ($this->_commands as $command) {
            $this->_discord->registerCommand($command->getName(), function($msg, $params) use ($command) {
               return $command->execute($msg, $params);
            });
        }
    }
    #endregion

    /**
     * Start the loop
     */
    public function run()
    {
        $this->_discord->run();
    }

    #region Setters
    /**
     * @param $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->_parameters = $parameters;
        return $this;
    }

    /**
     * @param $configuration
     * @return $this
     */
    public function setConfiguration($configuration)
    {
        $this->_configuration = $configuration;
        return $this;
    }

    #endregion
}