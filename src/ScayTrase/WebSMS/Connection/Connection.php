<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:10
 */

namespace ScayTrase\WebSMS\Connection;

use ScayTrase\WebSMS\Exception\DeliveryException;
use ScayTrase\WebSMS\Message\MessageInterface;

class Connection extends AbstractWebSMSConnection
{
    /**
     * @param MessageInterface $message
     *
     * @return bool
     *
     * @throws DeliveryException
     */
    public function send(MessageInterface $message)
    {
        return $this->doSendRequest($message);
    }
}
