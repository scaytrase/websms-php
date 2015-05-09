<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 23:04
 */

namespace ScayTrase\WebSMS\Message;

class Message implements MessageInterface
{
    public $recipient;
    public $message;

    /**
     * Message constructor.
     *
     * @param $recipient
     * @param $message
     */
    public function __construct($recipient, $message)
    {
        $this->recipient = $recipient;
        $this->message   = $message;
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}
