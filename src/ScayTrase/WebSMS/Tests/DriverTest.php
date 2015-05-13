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

class DriverTest extends AbstractWebSMSTest
{
    /**
     * @param DriverInterface $driver
     *
     * @dataProvider getDrivers
     */
    public function testConnectionRequest(DriverInterface $driver)
    {
        $connection = new Connection($driver, 'demo', 'demo', Connection::TEST_SPECIAL);
        $message    = $this->getMessageMock();

        $this->assertTrue($connection->send($message));
    }


    /**
     * @param DriverInterface $driver
     *
     * @dataProvider getDrivers
     */
    public function testBalanceChecking(DriverInterface $driver)
    {
        $connection = new Connection($driver, 'demo', 'demo', Connection::TEST_SPECIAL);
        $this->assertTrue($connection->verify());
        $this->assertGreaterThan(0, $connection->getBalance());
    }

    public function invalidCredentialsProvider()
    {
        $driversData = $this->getDrivers();

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
        $connection = new Connection($driver, $username, $password, Connection::TEST_ENABLED);
        $message    = $this->getMessageMock();

        $connection->send($message);
    }
}
