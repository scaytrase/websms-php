<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-12
 * Time: 22:43
 */

namespace ScayTrase\WebSMS\Driver;

use Buzz\Client\FileGetContents;
use Buzz\Message\Form\FormRequest;
use Buzz\Message\Request;
use Buzz\Message\Response;
use ScayTrase\WebSMS\Exception\DriverException;

class FormDriver implements DriverInterface
{
    const HTTP_AccessPoint_Send    = 'http://cab.websms.ru/http_in5.asp';
    const HTTP_AccessPoint_Balance = 'http://cab.websms.ru/http_credit.asp';

    const Error_Message = 'error_num';
    const Error_Code    = 'error_num';

    public function doSendRequest(array $options)
    {
        $data = $this->doRealRequest(self::HTTP_AccessPoint_Send, $options);

        if (strstr(self::Error_Code, $data) === false) {
            throw new DriverException($data);
        }

        return $data;
    }

    public function doBalanceRequest(array $options)
    {
        $data = $this->doRealRequest(self::HTTP_AccessPoint_Balance, $options);

        return $data;
    }

    private function doRealRequest($url, array $options)
    {
        $request = new FormRequest(Request::METHOD_POST);
        $request->fromUrl($url);
        $request->setFields($options);

        $response = new Response();
        $client   = new FileGetContents();

        $client->send($request, $response);

        return $response->getContent();
    }
}
