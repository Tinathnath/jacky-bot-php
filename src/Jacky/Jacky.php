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

class Jacky
{
    protected $discord = null;
    protected $standardCommandClient = null;
    protected $advancedCommandClient = null;

    /**
     * Jacky constructor.
     * @param Discord $discordClient
     */
    public function __construct(Discord $discordClient)
    {
        $this->discord = $discordClient;
    }

    /**
     * @param DiscordCommandClient $client
     * @return $this
     */
    public function setStandardCommandClient(DiscordCommandClient $client)
    {
        $this->standardCommandClient = $client;
        return $this;
    }

    /**
     * @param DiscordCommandClient $client
     * @return $this
     */
    public function setAdvancedCommandClient(DiscordCommandClient $client)
    {
        $this->advancedCommandClient = $client;
        return $this;
    }


    public function registerStandardCommands()
    {
        /* Hey */
        $this->standardCommandClient->registerCommand('hey', function($m, $p) { return $this->sayHello($m, $p); }, [
            'aliases' => ['salut', 'hello', 'coucou', ':wave:', 'beat', 'bonjour', 'bonsoir', 'hi', 'lu\'', 'lu', 'yo', 'yop'],
            'usage' => 'Dites bonjour à Jacky. Exemple "Salut @Jacky !"'
        ]);

        return $this;
    }

    public function registerAdvancedCommands()
    {
        return $this;
    }

    #region Commands

    /**
     * Replies to hello messages
     * @param Message $message
     * @param $params
     * @return array
     */
    public function sayHello(Message $message, $params)
    {
        $author = "{$message->author}";
        return [
            "Salut $author !",
            "M'jour vieille branche $author",
            "HEY bonjour enculé $author !",
            ":wave: $author",
            "Salut $author ! Comment vont ta femme et mes gosses ? :nerd:",
            "Bonjour biloute $author !"
        ];
    }

    #endregion
}