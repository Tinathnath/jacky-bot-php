<?php

/**
 * jacky_bot/OscaroModule.php
 * Created by: Nathan
 * Date: 29/04/2017
 */

namespace Jacky\Modules\Oscaro;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Jacky\Modules\Oscaro\Models\Car;
use Psr\Http\Message\ResponseInterface;

/**
 * Class OscaroModule
 * @package Jacky\Modules\Oscaro
 */
class OscaroModule
{
    const API_URL = "https://www.oscaro.com/Catalog/SearchEngine/LicencePlateJQueryV2";

    /**
     * The Guzzle client
     * @var null
     */
    protected $_client = null;

    /**
     * OscaroModule constructor.
     */
    public function __construct()
    {
        $this->_client = new Client([
            'cookies' => true
        ]);
    }

    public function requestCar($immat, $callback, $error)
    {
        if(is_null($immat) || $immat == "")
            return;

        try {
            $this->_client->request('GET', 'https://www.oscaro.com', [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36'
                ]
            ]);

            $response = $this->_client->request('POST', self::API_URL, [
               'form_params' => [
                   'frenchLicencePlate' => $immat,
                   'genartId' => null
               ],
                'headers' => $this->getHeaders()
            ]);

            $json = $response->getBody();
            $rawData = \GuzzleHttp\json_decode($json, true);
            $cars = [];
            foreach($rawData['types'] as $item)
            {
                $car = new Car();
                $car->immat = $immat;
                $car->description = $item['Text'];
                $car->link = $rawData['urls'][$item['Value']];
                $cars[] = $car;
            }

            call_user_func($callback, $cars);
        }
        catch(RequestException $e){
            call_user_func($error, $e);
        }
    }

    /**
     * Creates the headers array to pass to client
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36'
        ];
    }
}