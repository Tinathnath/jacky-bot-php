<?php
/**
 * jacky_bot/ChanHelper.php
 * Created by: Nathan
 * Date: 15/05/2017
 */

namespace Jacky\Commands\Helpers;
use Jacky\Caching\CacheInterface;

/**
 * Class ChanHelper
 * @package Jacky\Commands\Helpers
 */
class ChanHelper
{
    /**
     * @var CacheInterface
     */
    protected $cache = null;

    /**
     * ChanHelper constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Checks a chan is marked NSFW
     * @param $chanId
     * @return bool
     */
    public function isChanNSFW($chanId)
    {
        $key = sprintf("chan:%s:%s", $chanId, "nsfw");

        return $this->cache->get($key) == 1;
    }

    /**
     * Sets a chan as nfsw or not
     * @param $chanId
     * @param bool|true $nsfw
     * @return mixed
     */
    public function setChanNSFW($chanId, $nsfw = true)
    {
        $key = sprintf("chan:%s:%s", $chanId, "nsfw");

        if($nsfw)
        {
            return $this->cache->set($key, 1);
        }
        else
        {
            if($this->cache->keyExists($key))
               return $this->cache->remove($key);
        }

        return false;
    }
}