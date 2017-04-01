<?php
/**
 * jacky_bot/JackyStarter.php
 * Created by: Nathan
 * Date: 14/03/2017
 */

namespace Jacky;

use Discord\Discord;
use Discord\DiscordCommandClient;
use Jacky\Config\ConfigurationTree;
use Jacky\Config\ConfigurationWrapper;
use Jacky\Config\ParametersTree;
use Jacky\Config\YamlConfigLoader;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

class JackyStarter
{
    private $_apiToken;

    public function __construct()
    {

    }

    /**
     * @param mixed $apiToken
     */
    public function setApiToken($apiToken)
    {
        $this->_apiToken = $apiToken;
    }

    /**
     * Loads bot configuration file
     * @param $directory
     * @return ConfigurationWrapper
     */
    public function loadConfiguration($directory)
    {
        $mainConfigFile = 'config.yml';

        $processedConfiguration = null;
        $directories = array($directory);
        $locator = new FileLocator($directories);

        $loader = new YamlConfigLoader($locator);
        $configValues = $loader->load($locator->locate($mainConfigFile));

        $processor = new Processor();
        $configuration = new ConfigurationTree();
        try{
            $processedConfiguration = $processor->processConfiguration($configuration, $configValues);
            return new ConfigurationWrapper('jacky', $processedConfiguration);
        }
        catch(Exception $e){
            exit($e->getMessage().PHP_EOL);
        }
    }

    /**
     * Load parameter file
     * @param $directory
     * @return ConfigurationWrapper
     */
    public function loadParameters($directory)
    {
        $file = 'parameters.yml';
        $processedConfiguration = null;
        $directories = array($directory);
        $locator = new FileLocator($directories);

        $loader = new YamlConfigLoader($locator);
        $configValues = $loader->load($locator->locate($file));

        $processor = new Processor();
        $parameters = new ParametersTree();
        try{
            $processedConfiguration = $processor->processConfiguration($parameters, $configValues);
            return new ConfigurationWrapper('parameters', $processedConfiguration);
        }
        catch(Exception $e){
            exit($e->getMessage().PHP_EOL);
        }
    }

    /**
     * inits classic discord client
     * @return Discord
     */
    public function initDiscord()
    {
        return new Discord([
            'token' => $this->_apiToken
        ]);
    }

    /** inits standard commandClient with @mention prefix
     * @return DiscordCommandClient
     */
    public function initStandardCommandClient()
    {
        return new DiscordCommandClient([
            'token' => $this->_apiToken,
            'description' => "Well, I'm a bot"
        ]);
    }

    /**
     * inits advanced commandClient with '?' prefix
     * @return DiscordCommandClient
     */
    public function initAdvancedCommandClient()
    {
        return new DiscordCommandClient([
            'token' => $this->_apiToken,
            'prefix' => "?",
            'description' => "Well, I'm a bot"
        ]);
    }
}