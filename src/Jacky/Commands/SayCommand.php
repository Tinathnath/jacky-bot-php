<?php
/**
 * jacky_bot/SayCommand.php
 * Created by: Nathan
 * Date: 02/04/2017
 */

namespace Jacky\Commands;


use Discord\Parts\Channel\Message;

class SayCommand implements CommandInterface
{
    public function getName()
    {
        return 'say';
    }

    public function execute(Message $message, $params = [])
    {
        var_dump($message->mentions);
        $message->channel->sendMessage("$message->content");
    }

}