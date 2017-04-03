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

class SayCommand implements CommandInterface, CommandInjectionInterface
{
    private $config = null;

    public function execute(Message $message, $params = [])
    {
        $whatToSay = CommandHelper::removeMessageMentions($this->getContent($message->content), $message->mentions);
        foreach ($message->mentions as $mention) {
            $message->channel->sendMessage(sprintf("%s %s (de la part de %s)", $mention, $whatToSay, $message->author));
        }

        $message->channel->messages->delete($message);
    }

    private function getContent($message)
    {
        return CommandHelper::getCommandContent($message, $this->config->get('command_prefix'), $this->getName());
    }

    public function setConfiguration(ConfigurationWrapper $configuration)
    {
        $this->config = $configuration;
    }

    public function getName()
    {
        return 'say';
    }
}