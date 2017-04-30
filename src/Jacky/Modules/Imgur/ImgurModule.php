<?php

/**
 * jacky_bot/ImgurModule.php
 * Created by: Nathan
 * Date: 05/04/2017
 */

namespace Jacky\Modules\Imgur;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Jacky\Modules\GalleryImage;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ImgurModule
 * @package Jacky\Modules\Imgur
 */
class ImgurModule
{
    const BASE_API_URL = "https://api.imgur.com/3/";

    const IMG_ENDPOINT = "gallery/r/";

    /**
     * The Guzzle client
     * @var null
     */
    protected $_client = null;

    /**
     * The Imgur app ID
     * @var null
     */
    protected $_appId;

    /**
     * ImgurModule constructor.
     * @param string $appId
     */
    public function __construct($appId)
    {
        $this->_appId = $appId;
        $this->_client = new Client([
            'base_uri' => self::BASE_API_URL
        ]);
    }

    /**
     * Search in subreddit gallery
     * @param string $search
     * @param callable $callback
     * @param callable $error
     */
    public function requestGallery($search, $callback, $error)
    {
        if(is_null($search) || $search == "")
            return;

        $uri = sprintf('%s%s', self::IMG_ENDPOINT, $search);
        $request = new Request('GET', $uri, $this->getHeaders());
        try {
            $response = $this->_client->send($request);
            $json = $response->getBody();

            $rawData = \GuzzleHttp\json_decode($json);
            $images = [];
            foreach($rawData->data as $item){
                if (!$item->is_album) {
                    $img = new GalleryImage();
                    $img->link = $item->link;
                    $img->title = $item->title;
                    $img->id = $item->id;
                    $images[] = $img;
                }
            }

            call_user_func($callback, $images);
        } catch (RequestException $e) {
            call_user_func($error, $e);
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Creates the headers array to pass to client
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => sprintf('Client-ID %s', $this->_appId)
        ];
    }
}