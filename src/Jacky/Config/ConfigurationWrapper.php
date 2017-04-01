<?php
/**
 * jacky_bot/ConfigurationWrapper.php
 * Created by: Nathan
 * Date: 15/03/2017
 */

namespace Jacky\Config;

use Jacky\Exception\Config\ConfigurationNodeNotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * This class wraps the config and parses the config file as a php object that is easilly accessible
 * Uses Symfony ExpressionLanguage
 * Class ConfigurationWrapper
 * @package Jacky\Config
 */
class ConfigurationWrapper
{
    /**
     * Stores the parsed configuration as a real array
     * @var array configuration
     */
    private $_configuration;

    /**
     * The Symfony ExpressionLanguage Component instance
     * @var ExpressionLanguage
     */
    private $_expressionLanguage = null;

    /**
     * ConfigurationWrapper constructor.
     * @param $rootNode
     * @param $configuration
     */
    public function __construct($rootNode, $configuration)
    {
        $this->_configuration = array( $rootNode => (object) $configuration);
        $this->_expressionLanguage = new ExpressionLanguage();
    }

    /**
     * Return a config key's value
     * @param $node
     * @return string
     * @throws ConfigurationNodeNotFoundException
     */
    public function get($node)
    {
        try{
            return $this->_expressionLanguage->evaluate($node, $this->_configuration);
        }
        catch(Exception $e){
            throw new ConfigurationNodeNotFoundException(sprintf("La variable de configuration %s n'existe pas.", $node), null, $e);
        }
    }
}