<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-14
 * Time: 00:02
 */

namespace ScayTrase\WebSMS\Message;

use ScayTrase\WebSMS\Connection\WebSmsApiParams;

class MassMessage implements MessageInterface
{
    /** @var array */
    private $recipients = array();
    /** @var string */
    private $message;

    /**
     * MassMessage constructor.
     *
     * @param array  $recipients
     * @param string $message
     */
    public function __construct($message, array $recipients = array())
    {
        $this->recipients = $recipients;
        $this->message    = $message;
    }

    public function addRecipients($recipient)
    {
        $this->recipients[] = $recipient;
    }

    public function getRecipient()
    {
        return implode(WebSmsApiParams::PARAM_RecipientDelimiter, $this->recipients);
    }

    public function getMessage()
    {
        return $this->message;
    }
}
