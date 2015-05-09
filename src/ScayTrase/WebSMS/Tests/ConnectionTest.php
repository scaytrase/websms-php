<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 23:01
 */

namespace ScayTrase\WebSMS\Tests;

use ScayTrase\WebSMS\Connection\Connection;
use ScayTrase\WebSMS\Message\Message;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function getCredentials()
    {
        $credentialsFile = __DIR__.'/fixtures/credentials.json';

        if (!is_file($credentialsFile)) {
            throw new \UnexpectedValueException(
                sprintf(
                    'please, copy "%s" to "%s" and fill in the credentials in order to perform all test',
                    __DIR__.'/fixtures/credentials.json.dist',
                    $credentialsFile
                )
            );
        }

        $credentials = json_decode(file_get_contents($credentialsFile), true);

        return $credentials;
    }

    public function testConnectionRequest()
    {
        $credentials = $this->getCredentials();

        $connection = new Connection($credentials['username'], $credentials['password'], true);
        $message    = new Message('+79994567890', 'test message');

        $this->assertTrue($connection->send($message));
    }

    public function testBalanceChecking()
    {
        $credentials = $this->getCredentials();

        $connection = new Connection($credentials['username'], $credentials['password'], true);

        $this->assertTrue($connection->verify());
        $this->assertGreaterThan(0, $connection->getBalance());
    }

    public function invalidCredentialsProvider()
    {
        return array(
            'no username' => array(null, 'test'),
            'no password' => array('test', null),
        );
    }

    /**
     * @expectedException \ScayTrase\WebSMS\Exception\DeliveryException
     *
     * @param $username
     * @param $password
     *
     * @dataProvider invalidCredentialsProvider
     */
    public function testInvalidCredentialsHandling($username, $password)
    {
        $connection = new Connection($username, $password, true);
        $message    = new Message('1234567890', 'test message');

        $response = $connection->send($message);

        echo $response;
    }
}
