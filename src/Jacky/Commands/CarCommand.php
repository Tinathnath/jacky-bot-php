<?php
/**
 * jacky_bot/CarCommand.php
 * Created by: Nathan
 * Date: 29/04/2017
 */

namespace Jacky\Commands;

use Discord\Parts\Channel\Message;
use GuzzleHttp\Exception\RequestException;
use Jacky\Commands\Helpers\CommandHelper;
use Jacky\Modules\Oscaro\OscaroModule;

class CarCommand extends Command implements CommandInterface
{
    public function execute(Message $message, $params = [])
    {
        $immat = CommandHelper::removeMessageMentions($this->getContent($message->content), $message->mentions);

        $oscaro = new OscaroModule();
        $oscaro->requestCar($immat,
            //success
            function($cars) use (&$message, &$immat){
                $count = count($cars);
                if($count == 0){
                    $message->channel->sendMessage(sprintf("Aucun résultat trouvé pour la plaque `%s`", $immat));
                    return;
                }

                $respMessage = sprintf("%s :\n\r", $immat);
                foreach($cars as $id => $car){
                    $respMessage.= sprintf("`%s` \r\n %s", $car->description, $car->link);

                    if($id < $count - 1)
                        $respMessage.= "\r\n \r\n";
                }
                $message->channel->sendMessage($respMessage);
            },
            //error
            function(RequestException $error) use (&$message, &$immat){
                $message->channel->sendMessage(sprintf('Erreur lors de la recherche de la plaque `%s`', $immat));
                echo $error->getMessage();
            }
        );
    }

    public function getName()
    {
        return 'car';
    }

    public function getHelp()
    {
        return 'Recherche un véhicule français d\'après son immatriculation: ?car <immatriculation>';
    }
}