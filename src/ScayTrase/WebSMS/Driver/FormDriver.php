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
use ScayTrase\WebSMS\Exception\UnexpectedResponseException;

class FormDriver implements DriverInterface
{
    const HTTP_AccessPoint_Send    = 'http://cab.websms.ru/http_in5.asp';
    const HTTP_AccessPoint_Balance = 'http://cab.websms.ru/http_credit.asp';

    const Error_Message = 'error_num';
    const Error_Code    = 'error_code';

    const Section_Common  = 'Common';
    const Section_Summary = 'Summary';

    public function doSendRequest(array $options)
    {
        $data = $this->doRealRequest(self::HTTP_AccessPoint_Send, $options);

        $status = parse_ini_string($data, true);

        if (!isset($status[self::Section_Common][self::Error_Message])) {
            throw new UnexpectedResponseException('Response either does not contain common section or error message');
        }

        $normalized_status = array();
        $normalized_status = array_merge_recursive($normalized_status, $status[self::Section_Common]);
        if (isset($status[self::Section_Summary])) {
            $normalized_status = array_merge_recursive($normalized_status, $status[self::Section_Summary]);
        }

        foreach ($status as $key => $section) {
            if (is_int($key)) {
                $normalized_status['sms'][] = $section;
            }
        }

        $normalized_status[self::NORMALIZED_MESSAGE] = $status[self::Section_Common][self::Error_Message];
        $normalized_status[self::NORMALIZED_CODE]    =
            isset($status[self::Section_Common][self::Error_Code]) ?
                $status[self::Section_Common][self::Error_Code] :
                self::STATUS_OK;

        return $normalized_status;
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
