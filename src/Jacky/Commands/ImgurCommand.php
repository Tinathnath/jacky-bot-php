<?php
/**
 * jacky_bot/ImgurCommand.php
 * Created by: Nathan
 * Date: 05/04/2017
 */

namespace Jacky\Commands;


use Discord\Parts\Channel\Message;
use GuzzleHttp\Exception\RequestException;
use Jacky\Commands\Helpers\CommandHelper;
use Jacky\Modules\Imgur\ImgurModule;

class ImgurCommand extends Command implements CommandInterface
{
    public function execute(Message $message, $params = [])
    {
        $search = CommandHelper::removeMessageMentions($this->getContent($message->content), $message->mentions);
        $imgur = new ImgurModule($this->parameters->get('imgur_app_id'));
        $imgur->requestGallery($search,
        //success
            function($images) use (&$message, $search){
                echo 'images: ';
                $count = count($images);
                if($count == 0) {
                    $message->channel->sendMessage(sprintf("Aucun résultat pour `%s`. Essaye autre chose %s", $search, $message->author));
                    return;
                }

                $idx = rand(0, $count-1);
                $img = $images[$idx];
                $message->channel->sendMessage($img->link);
                $message->channel->sendFile($img->link, $img->id);
            },
        //error
            function(RequestException $error) use (&$message, &$search){
                $message->channel->sendMessage(sprintf('Erreur lors de la recherche de `%s`', $search));
            }
        );
    }

    public function getName()
    {
        return 'get';
    }

    public function getHelp()
    {
        return 'Recherche une image sur Imgur/Reddit: ?get <recherche>';
    }

}