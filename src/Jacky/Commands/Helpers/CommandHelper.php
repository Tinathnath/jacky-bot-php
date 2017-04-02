<?php

namespace Jacky\Commands\Helpers;

/**
 * jacky_bot/CommandHelper.php
 * Created by: Nathan
 * Date: 02/04/2017
 */
class CommandHelper
{
    /**
     * Removes command call from message
     * @param $message
     * @param $prefix
     * @param $commandName
     * @return string
     */
    public static function getCommandContent($message, $prefix, $commandName)
    {
        return trim(explode(sprintf('%s%s', $prefix, $commandName), $message)[1]);
    }

    /**
     * Removes all mentions from message
     * @param $message
     * @param $mentions
     * @return mixed
     */
    public static function removeMessageMentions($message, $mentions)
    {
        foreach ($mentions as $mention) {
            $mentionString = sprintf('@%s#%s', $mention['username'], $mention['discriminator']);
            $message = str_replace($mentionString, '', $message);
        }

        return $message;
    }
}