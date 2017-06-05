<?php
/**
 * jacky_bot/ImgurHelper.php
 * Created by: Nathan
 * Date: 05/06/2017
 */

namespace Jacky\Modules\Imgur;

use Discord\Parts\User\User;
use Jacky\Caching\CacheInterface;

/**
 * Class ImgurHelper
 * @package Jacky\Modules\Imgur
 */
class ImgurHelper
{
    const QUERY_PER_MIN = 5;
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
     * @param User $user
     * @return bool
     */
    public function isUserAllowed(User $user)
    {
        $keyRemaining = sprintf("user:%s:%s", $user->id, "remain");
        $keyTimestamp = sprintf("user:%s:%s", $user->id, "time");

        if(!$this->cache->keyExists($keyRemaining))
            $this->cache->set($keyRemaining, self::QUERY_PER_MIN);

        if(!$this->cache->keyExists($keyTimestamp))
            $this->cache->set($keyTimestamp, time() - 61);

        $allowed = true;
        $userRemaining = $this->cache->get($keyRemaining);

        //check user can query
        if($userRemaining > 0){
            $this->cache->set($keyRemaining, $userRemaining - 1);
        }
        else{
            //no credits, check if last request > 1min
            $lastQueryTime = $this->cache->get($keyTimestamp);
            $lastQueryTime = $lastQueryTime != null ? $lastQueryTime : time() - 61;

            if($lastQueryTime + 60 < time())
                $this->cache->set($keyRemaining, self::QUERY_PER_MIN);
            else
                $allowed = false;
        }

        return $allowed;
    }
}