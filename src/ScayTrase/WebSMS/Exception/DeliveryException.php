<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:25
 */

namespace ScayTrase\WebSMS\Exception;

use Exception;
use ScayTrase\WebSMS\Message\MessageInterface;

class DeliveryException extends ConnectionException
{
    /** @var  MessageInterface */
    protected $failedMessage;

    public function __construct(
        MessageInterface $failedMessage = null,
        $message = "",
        $code = 0,
        Exception $previous = null
    ) {
        $this->failedMessage = $failedMessage;

        parent::__construct($message, $code, $previous);
    }

}
