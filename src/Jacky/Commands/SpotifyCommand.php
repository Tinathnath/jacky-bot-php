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

    const SPOTIFY_URI_BASE = 'https://embed.spotify.com/?uri=';

    public function execute(Message $message, $params = [])
    {
        $content = $this->getContent($message);
        $contentParts = explode(" ", $content);
        if(count($contentParts) < 1)
            return;

        $spotifyUri = $contentParts[0];
        $spotifyUriParts = explode(":", $spotifyUri);
        if(count($spotifyUriParts) < 2)
            return;

        if($spotifyUriParts[0] != "spotify")
            return;

        $embedUrl = sprintf('%s%s', self::SPOTIFY_URI_BASE, $spotifyUri);
        $embedObj = $this->discord->factory(Embed::class, [
            'title' => 'Spotify',
            'type' => 'rich',
            'description' => 'Probablement une musique',
            'url' => $embedUrl,
            'timestamp' => time(),
            'provider' => [
                'name' => 'spotify',
                'url' => $embedUrl
            ]
        ]);

        $message->channel->sendMessage("", false, $embedObj);
    }

    public function getName()
    {
        return 'spotify';
    }
}