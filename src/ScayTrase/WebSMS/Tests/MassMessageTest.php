<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-14
 * Time: 00:07
 */

namespace ScayTrase\WebSMS\Tests;


use ScayTrase\WebSMS\Connection\Connection;
use ScayTrase\WebSMS\Driver\DriverInterface;
use ScayTrase\WebSMS\Message\MassMessage;

class MassMessageTest extends AbstractWebSMSTest
{
    /**
     * @param DriverInterface $driver
     *
     * @dataProvider getDrivers
     */
    public function testMessageCountForUniqueRecipients(DriverInterface $driver)
    {
        $connection = new Connection($driver, 'demo', 'demo', Connection::TEST_SPECIAL);
        $message    = new MassMessage('test message');

        $message->addRecipients(self::FAKE_PHONE_0);
        $message->addRecipients(self::FAKE_PHONE_1);

        $connection->send($message);

        $lastStatus = $connection->getLastStatus();
        $this->assertCount(2, $lastStatus['sms']);
    }

//    /**
//     * @param DriverInterface $driver
//     *
//     * @dataProvider getDrivers
//     */
//    public function testMessageCountForNonUniqueRecipients(DriverInterface $driver)
//    {
//        $connection = new Connection($driver, 'demo', 'demo', Connection::TEST_SPECIAL);
//        $message    = new MassMessage('test message');
//
//        $message->addRecipients(self::FAKE_PHONE_0);
//        $message->addRecipients(self::FAKE_PHONE_0);
//
//        $connection->send($message);
//
//        $this->assertCount(1, $connection->getLastStatus()['sms']);
//    }
}
