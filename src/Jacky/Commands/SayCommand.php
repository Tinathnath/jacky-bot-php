<?php
/**
 * jacky_bot/SayCommand.php
 * Created by: Nathan
 * Date: 02/04/2017
 */

namespace Jacky\Commands;


use Discord\Parts\Channel\Message;
use Jacky\Commands\Helpers\CommandHelper;
use Jacky\Config\ConfigurationWrapper;

/**
 * Class SayCommand
 * Says a message to a bunch of users
 * @package Jacky\Commands
 */
class SayCommand extends Command implements CommandInterface
{

    public function execute(Message $message, $params = [])
    {
        $delete = false;
        $whatToSay = CommandHelper::removeMessageMentions($this->getContent($message->content), $message->mentions);
        foreach ($message->mentions as $mention) {
            $message->channel->sendMessage(sprintf("%s %s (de la part de %s)", $mention, $whatToSay, $message->author));
            $delete = true;
        }

        if($delete)
            $message->channel->messages->delete($message);
    }

    public function getName()
    {
        return 'say';
    }

    public function getHelp()
    {
        return 'Fait dire à Jacky le message que vous lui demandez aux personne mentionnées: ?say coucou @user1 @user2';
    }
}