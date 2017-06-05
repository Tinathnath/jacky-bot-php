<?php
/**
 * jacky_bot/CacheFactory.php
 * Created by: Nathan
 * Date: 05/06/2017
 */

namespace Jacky\Caching;

/**
 * Class CacheFactory
 * @package Jacky\Caching
 */
class CacheFactory
{
    const CACHE_TYPE = 'redis';

    /**
     * @param array $parameters
     * @return RedisCache
     */
    public static function get($parameters = [])
    {
        switch(self::CACHE_TYPE)
        {
            case 'redis':
                if($parameters->get('redis_port') == null)
                    return RedisCache::getInstance($parameters->get('redis_host'));
                else
                    return RedisCache::getInstance($parameters->get('redis_host'), $parameters->get('redis_port'));
            break;
        }
    }
}