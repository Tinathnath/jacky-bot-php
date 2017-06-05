<?php

/**
 * jacky_bot/CacheInterface.php
 * Created by: Nathan
 * Date: 15/05/2017
 */

namespace Jacky\Caching;

interface CacheInterface
{
    public function keyExists($key);
    public function get($key);
    public function set($key, $value);
    public function remove($key);
}