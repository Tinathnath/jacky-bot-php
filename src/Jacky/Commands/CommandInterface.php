<?php
/**
 * jacky_bot/CommandInterface.php
 * Created by: Nathan
 * Date: 02/04/2017
 */

namespace Jacky\Commands;


use Discord\Parts\Channel\Message;

interface CommandInterface
{
    /**
     * Must return the command name
     * @return mixed
     */
    public function getName();

    /**
     * Returns the description / help message
     * @return mixed
     */
    public function getHelp();

    /**
     * Contains the command code to run
     * @param Message $message
     * @param array $params
     * @return mixed
     */
    public function execute(Message $message, $params = []);
}