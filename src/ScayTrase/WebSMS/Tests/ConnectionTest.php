<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 23:01
 */

namespace ScayTrase\WebSMS\Tests;

use ScayTrase\WebSMS\Connection\Connection;
use ScayTrase\WebSMS\Driver\DriverInterface;
use ScayTrase\WebSMS\Driver\FormDriver;
use ScayTrase\WebSMS\Driver\JsonDriver;
use ScayTrase\WebSMS\Message\Message;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function getProviders()
    {
        return array(
            'JSON Driver' => array(new JsonDriver()),
            'Form Driver' => array(new FormDriver()),
        );
    }

    /**
     * @param DriverInterface $driver
     *
     * @dataProvider getProviders
     */
    public function testConnectionRequest(DriverInterface $driver)
    {
        $connection = new Connection($driver, 'demo', 'demo', Connection::TEST_SPECIAL);
        $message    = new Message('+79994567890', 'test message');

        $this->assertTrue($connection->send($message));
    }


    /**
     * @param DriverInterface $driver
     *
     * @dataProvider getProviders
     */
    public function testBalanceChecking(DriverInterface $driver)
    {
        $connection = new Connection($driver, 'demo', 'demo', Connection::TEST_SPECIAL);
        $this->assertTrue($connection->verify());
        $this->assertGreaterThan(0, $connection->getBalance());
    }

    public function invalidCredentialsProvider()
    {
        $driversData = $this->getProviders();

        $credentialsData = array(
            'no username' => array(null, 'demo'),
            'no password' => array('demo', null),
        );

        $data = array();

        foreach ($driversData as $name => $driver) {
            foreach ($credentialsData as $pair => $credentials) {
                $data[sprintf('%s %s', $name, $pair)] = array_merge($driver, $credentials);
            }
        }

        return $data;
    }

    /**
     * @expectedException \ScayTrase\WebSMS\Exception\DriverException
     *
     * @param DriverInterface $driver
     * @param                 $username
     * @param                 $password
     *
     * @dataProvider invalidCredentialsProvider
     */
    public function testInvalidCredentialsHandling(DriverInterface $driver, $username, $password)
    {
        $connection = new Connection($driver, $username, $password, Connection::TEST_SPECIAL);
        $message    = new Message('1234567890', 'test message');

        $response = $connection->send($message);

        echo $response;
    }
}
