<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:08
 */

namespace ScayTrase\WebSMS;

use ScayTrase\WebSMS\Connection\Connection;

class Factory
{
    public function createSender($login, $pass, $test = false)
    {
        $connection = new Connection($login, $pass, $test);
        $sender     = new Sender($connection);

        return $sender;
    }
}
