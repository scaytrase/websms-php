<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:29
 */

namespace ScayTrase\WebSMS\Connection;

use ScayTrase\WebSMS\Driver\DriverInterface;
use ScayTrase\WebSMS\Driver\FormDriver;
use ScayTrase\WebSMS\Exception\CommunicationException;
use ScayTrase\WebSMS\Exception\DeliveryException;
use ScayTrase\WebSMS\Message\MessageInterface;

abstract class AbstractWebSMSConnection implements ConnectionInterface, WebSmsApiParams
{
    const TEST_DISABLED = 0;
    const TEST_ENABLED  = 1;
    const TEST_SPECIAL  = -1;

    /** @var  string */
    protected $username;
    /** @var  string */
    protected $password;
    /** @var  int */
    protected $test = self::TEST_DISABLED;

    /** @var  float */
    protected $balance;

    /** @var DriverInterface */
    protected $driver;
    /** @var  FormDriver */
    protected $balanceDriver;
    /** @var  array */
    private $lastStatus;

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param DriverInterface $driver
     * @param                 $username
     * @param                 $password
     * @param int             $test
     */
    public function __construct(DriverInterface $driver, $username, $password, $test = self::TEST_DISABLED)
    {
        $this->driver        = $driver;
        $this->username      = $username;
        $this->password      = $password;
        $this->test          = $test;
        $this->balanceDriver = new FormDriver();
    }

    /**
     * @param MessageInterface $message
     *
     * @return bool
     * @throws DeliveryException
     */
    protected function doSendRequest(MessageInterface $message)
    {
        $status = $this->driver->doSendRequest(
            array(
                static::PARAM_Username   => $this->username,
                static::PARAM_Password   => $this->password,
                static::PARAM_Test       => $this->test,
                static::PARAM_Recipients => $message->getRecipient(),
                static::PARAM_Message    => $message->getMessage(),
            )
        );

        if ($status[DriverInterface::NORMALIZED_CODE] !== DriverInterface::STATUS_OK) {
            throw new DeliveryException(
                $message,
                $status[DriverInterface::NORMALIZED_MESSAGE],
                $status[DriverInterface::NORMALIZED_CODE]
            );
        }

        $this->lastStatus = $status;

        return true;
    }

    /**
     * @return array
     */
    public function getLastStatus()
    {
        return $this->lastStatus;
    }

    /**
     * @return bool Verifies connection properties
     * @throws CommunicationException
     */
    public function verify()
    {
        $this->balance = (float)$this->balanceDriver->doBalanceRequest(
            array(
                static::PARAM_Username       => $this->username,
                static::PARAM_Password       => $this->password,
                static::PARAM_Test           => $this->test,
                static::PARAM_ResponseFormat => static::FORMAT_Text,
            )
        );

        return $this->balance > 0;
    }
}
