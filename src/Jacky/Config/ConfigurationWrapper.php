<?php
/**
 * jacky_bot/ConfigurationWrapper.php
 * Created by: Nathan
 * Date: 15/03/2017
 */

namespace Jacky\Config;

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
    private $_configuration;
    private $_expressionLanguage = null;

    public function __construct($rootNode, $configuration)
    {
        $this->_configuration = array( $rootNode => (object) $configuration);
        $this->_expressionLanguage = new ExpressionLanguage();
    }

    /**
     * Return a config key's value
     * @param $node
     * @return string
     */
    public function get($node)
    {
        try{
            return $this->_expressionLanguage->evaluate($node, $this->_configuration);
        }
        catch(Exception $e){
            throw new Exception("La variable de configuration $node n'existe pas.");
        }
    }
}