<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-10
 * Time: 00:13
 */

namespace ScayTrase\WebSMS\Connection;

/**
 * Interface WebSmsApiParams
 *
 * @package ScayTrase\WebSMS\Connection
 * @link    http://websms.ru/content/doc/HTTP_HTTPSsendmethod_v1.8.pdf?5488
 */
interface WebSmsApiParams
{
    const PARAM_Username           = 'http_username';
    const PARAM_Password           = 'http_password';
    const PARAM_Message            = 'message';
    const PARAM_Recipients         = 'phone_list';
    const PARAM_RecipientDelimiter = ',';
    const PARAM_SenderAlias        = 'fromPhone';
    const PARAM_NoSplit            = 'nosplit';
    const PARAM_Test               = 'test';
    const PARAM_ResponseFormat     = 'format';
    const PARAM_ValidPeriod        = 'valid_period';

    const FORMAT_Text = 'text';
    const FORMAT_Xml  = 'xml';
    const FORMAT_Json = 'json';
}
