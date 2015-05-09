<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:29
 */

namespace ScayTrase\WebSMS\Connection;

use Buzz\Client\FileGetContents;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Request;
use Buzz\Message\Response;
use ScayTrase\WebSMS\Exception\CommunicationException;
use ScayTrase\WebSMS\Exception\DeliveryException;
use ScayTrase\WebSMS\Message\MessageInterface;

abstract class AbstractWebSMSConnection implements ConnectionInterface, WebSmsStatus, WebSmsApiParams, WebSmsApiResponse
{
    const HTTP_AccessPoint_Send    = 'http://cab.websms.ru/json_in5.asp';
    const HTTP_AccessPoint_Balance = 'http://cab.websms.ru/http_credit.asp';

    protected $username;
    protected $password;
    protected $test = false;

    protected $balance;

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    public function __construct($username, $password, $test = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->test     = $test;
    }

    protected function doSendRequest(MessageInterface $message)
    {
        $request = new FormRequest(Request::METHOD_POST);
        $request->fromUrl(static::HTTP_AccessPoint_Send);
        $request->setFields(
            array(
                'json' => json_encode(
                    array(
                        static::PARAM_Username   => $this->username,
                        static::PARAM_Password   => $this->password,
                        static::PARAM_Test       => $this->test ? 1 : 0,
                        static::PARAM_Recipients => $message->getRecipient(),
                        static::PARAM_Message    => $message->getMessage(),
                    )
                )
            )
        );

        $response = new Response();
        $client   = new FileGetContents();

        $client->send($request, $response);

        $json   = $response->getContent();
        $status = json_decode($json, true);

        if ($status[static::Error_Code] !== static::STATUS_OK) {
            throw new DeliveryException($message, $status[static::Error_Message]);
        }

        return true;
    }

    /**
     * @return bool Verifies connection properties
     * @throws CommunicationException
     */
    public function verify()
    {
        $request = new FormRequest(Request::METHOD_POST);
        $request->fromUrl(static::HTTP_AccessPoint_Balance);
        $request->setFields(
            array(
                static::PARAM_Username       => $this->username,
                static::PARAM_Password       => $this->password,
                static::PARAM_Test           => $this->test ? 1 : 0,
                static::PARAM_ResponseFormat => static::FORMAT_Text,
            )
        );

        $response = new Response();
        $client   = new FileGetContents();

        $client->send($request, $response);

        $balance = (float)$response->getContent();

        $this->balance = $balance;

        return $balance > 0;
    }
}
