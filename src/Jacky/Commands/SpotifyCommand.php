<?php
/**
 * jacky_bot/SpotifyCommand.php
 * Created by: Nathan
 * Date: 03/04/2017
 */

namespace Jacky\Commands;

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;


/**
 * Class SpotifyCommand
 * Posts a Spotify embed in channel
 * @package Jacky\Commands
 */
class SpotifyCommand extends Command implements CommandInterface
{

    const SPOTIFY_URI_BASE = 'https://open.spotify.com';

    public function execute(Message $message, $params = [])
    {
        $content = $this->getContent($message->content);
        $contentParts = explode(" ", $content);
        if(count($contentParts) < 1)
            return;

        $spotifyUri = $contentParts[0];
        $spotifyUriParts = explode(":", $spotifyUri);
        if(count($spotifyUriParts) < 2)
            return;

        if($spotifyUriParts[0] != "spotify")
            return;

        $embedUrl = sprintf('%s/%s/%s', self::SPOTIFY_URI_BASE, $spotifyUriParts[1], $spotifyUriParts[2]);

        $message->channel->sendMessage($embedUrl);
    }

    public function getName()
    {
        return 'spotify';
    }

    public function getHelp()
    {
        return 'Renvoie un lien direct vers une chanson/album/artiste sur Spotify à partir de son URI spotify:truc:id';
    }
}