<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-14
 * Time: 00:06
 */

namespace ScayTrase\WebSMS\Tests;

use ScayTrase\WebSMS\Driver\FormDriver;
use ScayTrase\WebSMS\Driver\JsonDriver;
use ScayTrase\WebSMS\Message\MessageInterface;

abstract class AbstractWebSMSTest extends \PHPUnit_Framework_TestCase
{
    const FAKE_PHONE_0 = '+79994567890';
    const FAKE_PHONE_1 = '+79994567891';
    const FAKE_PHONE_2 = '+79994567892';

    public function getDrivers()
    {
        return array(
            'JSON Driver' => array(new JsonDriver()),
            'Form Driver' => array(new FormDriver()),
        );
    }

    /** @return MessageInterface */
    protected function getMessageMock()
    {
        $messageMock = $this->getMock('ScayTrase\WebSMS\Message\MessageInterface');
        $messageMock
            ->expects($this->any())->method('getRecipient')->willReturn(self::FAKE_PHONE_0);
        $messageMock
            ->expects($this->any())->method('getMessage')->willReturn('test message');

        return $messageMock;

    }
}
