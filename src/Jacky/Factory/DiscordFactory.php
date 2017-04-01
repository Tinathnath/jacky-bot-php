<?php

/**
 * jacky_bot/DiscordFactory.php
 * Created by: Nathan
 * Date: 30/03/2017
 */

namespace Jacky\Factory;

use Discord\Discord;
use Discord\DiscordCommandClient;

/**
 * Class DiscordFactory
 * @package Jacky\Factory
 */
class DiscordFactory
{
    /**
     * The Discord API Token
     * @var null token
     */
    private $_token = null;

    /**
     * The command prefix to use
     * @var null prefix
     */
    private $_prefix = null;

    /**
     * DiscordFactory constructor.
     * Creates a DiscordFactory instance
     * @param $apiToken
     * @param null $prefix
     */
    public function __construct($apiToken, $prefix = null)
    {
        $this->_token = $apiToken;

        if($prefix != null && $prefix !== "mention"){
            $this->_prefix = $prefix;
        }
    }

    /**
     * Creates a well-configured DiscordCommandClient instance with the appropriate token and command prefix
     * You can pass any additional options DiscordCommandClient accepts (e.g. 'description')
     * @param array $options
     * @return DiscordCommandClient
     */
    public function create($options = [])
    {
        $baseOptions = [
            'token' => $this->_token
        ];
        if($this->_prefix != null)
            $baseOptions['prefix'] = $this->_prefix;

        $discordOptions = array_merge($baseOptions, $options);
        var_dump($discordOptions);
        
        return new DiscordCommandClient($discordOptions);
    }

}