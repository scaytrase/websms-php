<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:20
 */

namespace ScayTrase\WebSMS\Connection;

use ScayTrase\WebSMS\Exception\DeliveryException;
use ScayTrase\WebSMS\Message\MessageInterface;

interface ConnectionInterface
{
    /**
     * @param MessageInterface $message
     *
     * @return bool
     *
     * @throws DeliveryException
     */
    public function send(MessageInterface $message);

    /**
     * @return bool Verifies connection properties
     */
    public function verify();
}
