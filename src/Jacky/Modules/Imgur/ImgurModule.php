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
use Jacky\Modules\Imgur\Models\GalleryImage;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ImgurModule
 * @package Jacky\Modules\Imgur
 */
class ImgurModule
{
    const BASE_API_URL = "https://api.imgur.com/3";

    const IMG_ENDPOINT = "/gallery/r/";

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
     */
    public function __construct($appId)
    {
        $this->_appId = $appId;
        $this->_client = new Client([
            'base_uri' => self::BASE_API_URL
        ]);
    }

    public function requestGallery($search, $callback, $error)
    {
        if(is_null($search) || $search == "")
            return;

        $uri = sprintf('%s%s', self::IMG_ENDPOINT, $search);
        $request = new Request('GET', $uri, $this->getHeaders());
        $this->_client->sendAsync($request)->then(
            //success
            function(ResponseInterface $res) use ($callback){
                $rawData = \GuzzleHttp\json_decode($res, true);
                $images = [];
                foreach ($rawData as $item)
                {
                    if(!$item['is_album'])
                    {
                        $img = new GalleryImage();
                        $img->_hydrate($item);
                        $images[] = $img;
                    }
                }

                if(gettype($callback) == "function")
                    call_user_func($callback, $images);
            },
            //error
            function(RequestException $e) use ($error){
                if(gettype($error) == "function")
                    call_user_func($error, $e);
            }
        );
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