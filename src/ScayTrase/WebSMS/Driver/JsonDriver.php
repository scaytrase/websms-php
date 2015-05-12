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

class JsonDriver implements DriverInterface
{
    const HTTP_AccessPoint_Send = 'http://cab.websms.ru/json_in5.asp';
    const Error_Message = 'error';
    const Error_Code = 'err_num';

    public function doSendRequest(array $options)
    {
        $request = new FormRequest(Request::METHOD_POST);
        $request->fromUrl(static::HTTP_AccessPoint_Send);
        $request->setFields(array('json' => json_encode($options)));

        $response = new Response();
        $client   = new FileGetContents();

        $client->send($request, $response);

        $json   = $response->getContent();
        $status = json_decode($json, true);

        if ($status[static::Error_Code] !== static::STATUS_OK) {
            throw new DriverException($status[static::Error_Message], $status[static::Error_Code]);
        }

        return $status;
    }
}
