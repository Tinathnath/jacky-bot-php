<?php
/**
 * jacky_bot/SetCommand.php
 * Created by: Nathan
 * Date: 16/05/2017
 */

namespace Jacky\Commands;

use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Jacky\Caching\CacheFactory;
use Jacky\Caching\RedisCache;
use Jacky\Commands\Helpers\ChanHelper;
use Jacky\Commands\Helpers\CommandHelper;

/**
 * Class SetCommand
 * @package Jacky\Commands
 */
class SetCommand extends Command implements CommandInterface
{
    public function execute(Message $message, $params = [])
    {
        $command = CommandHelper::removeMessageMentions($this->getContent($message->content), $message->mentions);
        $subCommands = explode(' ', $command);
        if(count($subCommands) < 1)
            return;

        //switch on command to do
        $response = '';
        switch($subCommands[0])
        {
            case 'chan_nsfw':
                $args = $this->parseBoolCommandArgument($subCommands[1]);
                if($message->author)
                $response = $this->setChanNSFW($message->channel, $args);
        }

        $message->channel->sendMessage($response);
    }

    public function getName()
    {
        return 'set';
    }

    public function getHelp()
    {
        return 'Permet de définir les options de Jacky.';
    }

    #region commands
    /**
     * Parse bool var
     * @param $arg
     * @return bool
     */
    protected function parseBoolCommandArgument($arg)
    {
        if (!is_string($arg))
            return (bool) $arg;

        switch (strtolower($arg)) {
            case '1':
            case 'true':
            case 'on':
            case 'yes':
            case 'y':
                return true;
            default:
                return false;
        }
    }

    /**
     * Calls the cache to set a chan as NSFW
     * @param Channel $chan
     * @param bool|true $nsfw
     * @return string
     */
    protected function setChanNSFW(Channel $chan, $nsfw = true)
    {
        try{
            $chanHelper = new ChanHelper(CacheFactory::get($this->parameters));
            $chanHelper->setChanNSFW($chan->id, $nsfw);

            return $nsfw ? 'Le chan a bien été marqué nsfw' : 'Le tag nsfw a été retiré du chan';
        }
        catch(\Exception $e){
            return 'Erreur lors de l\'opération: '.$e->getMessage();
        }
    }
    #endregion
}