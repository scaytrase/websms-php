<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:22
 */

namespace ScayTrase\WebSMS\Message;

interface MessageInterface
{
    public function getRecipient();

    public function getMessage();
}
