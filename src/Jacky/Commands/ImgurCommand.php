<?php
/**
 * jacky_bot/ImgurCommand.php
 * Created by: Nathan
 * Date: 05/04/2017
 */

namespace Jacky\Commands;


use Discord\Parts\Channel\Message;
use GuzzleHttp\Exception\RequestException;
use Jacky\Caching\CacheFactory;
use Jacky\Commands\Helpers\ChanHelper;
use Jacky\Commands\Helpers\CommandHelper;
use Jacky\Modules\Imgur\ImgurHelper;
use Jacky\Modules\Imgur\ImgurModule;

class ImgurCommand extends Command implements CommandInterface
{
    public function execute(Message $message, $params = [])
    {
        $search = CommandHelper::removeMessageMentions($this->getContent($message->content), $message->mentions);
        $chanHelper = new ChanHelper(CacheFactory::get($this->parameters));
        $imgurHelper = new ImgurHelper(CacheFactory::get($this->parameters));
        if(!$imgurHelper->isUserAllowed($message->author))
            $message->reply(sprintf('Doucement sur les photos de ~~boobs~~ chaton, pas plus de %d recherches par minute !', $imgurHelper::QUERY_PER_MIN));

        $imgur = new ImgurModule($this->parameters->get('imgur_app_id'));
        $imgur->requestGallery($search,
        //success
            function($images) use (&$message, $search, &$chanHelper){
                $count = count($images);
                if($count == 0) {
                    $message->channel->sendMessage(sprintf("Aucun résultat pour `%s`. Essaye autre chose %s", $search, $message->author));
                    return;
                }

                $idx = rand(0, $count-1);
                $img = $images[$idx];


                if($img->isNsfw() && !$chanHelper->isChanNSFW($message->channel_id)){
                    $message->channel->sendMessage("L'image est NSFW. Executez `set chan_nsfw 1` pour autoriser ce salon.");
                }
                else {
                    $message->channel->sendFile($img->link, $img->id);
                    $message->channel->sendMessage($img->link);
                }
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