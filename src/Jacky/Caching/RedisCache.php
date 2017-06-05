<?php
/**
 * jacky_bot/RedisCache.php
 * Created by: Nathan
 * Date: 15/05/2017
 */

namespace Jacky\Caching;

use Predis\Client;

/**
 * Class RedisCache
 * @package Jacky\Caching
 */
class RedisCache implements CacheInterface
{
    /**
     * @var Client
     */
    protected $client = null;

    /**
     * @var RedisCache
     */
    private static $_instance;

    /**
     * RedisCache constructor.
     * @param $host
     * @param $port
     * @param $options
     */
    private function __construct($host, $port = null, $options)
    {
        $clientOptions = [];
        $clientOptions['host'] = $host;

        if($port != null)
            $clientOptions['port'] = $port;

        if(!array_key_exists('prefix', $options) || is_null($options['prefix']))
            $clientOptions['prefix'] = 'jacky:';

        $this->client = new Client(array_merge($clientOptions, $options));
    }

    /**
     * Singleton
     * @param string $host
     * @param int $port
     * @param array $options
     * @return RedisCache
     */
    public static function getInstance($host = "127.0.0.1", $port, $options = []) //Defautl redis port is 6379
    {
        if(self::$_instance == null || !self::$_instance instanceof RedisCache)
            self::$_instance = new RedisCache($host, $port, $options);

        return self::$_instance;
    }

    /**
     * Checks a key
     * @param $key
     * @return int
     */
    public function keyExists($key)
    {
        return $this->client->exists($key);
    }

    /**
     * Gets a key
     * @param $key
     * @return string
     */
    public function get($key)
    {
        return $this->client->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function set($key, $value)
    {
        return $this->client->set($key, $value);
    }

    /**
     * Sets a key with ttl
     * @param $key
     * @param $value
     * @param $ttl
     * @return mixed
     */
    public function setWithTTL($key, $value, $ttl)
    {
        return $this->client->set($key, $value, null, $ttl);
    }

    /**
     * Deletes a key
     * @param $key
     * @return int
     */
    public function remove($key)
    {
        return $this->client->del([$key]);
    }
}