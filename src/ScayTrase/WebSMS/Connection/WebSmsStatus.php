<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-10
 * Time: 00:00
 */

namespace ScayTrase\WebSMS\Connection;

/**
 * Interface WebSMSErrorListInterface
 *
 * @package ScayTrase\WebSMS\Connection
 * @link    http://websms.ru/content/doc/HTTP_HTTPSsendmethod_v1.8.pdf?5488
 */
interface WebSmsStatus
{
    const STATUS_OK                = 0; // Request accepted
    const INVALID_CREDENTIALS      = 1; // Incorrect login or password
    const USER_BLOCKED             = 2; // Access blocked
    const INSUFFICIENT_FUNDS       = 3; // Not enough funds to perform operation
    const IP_BLOCKED               = 4; // Sender IP blocked
    const HTTP_BLOCKED             = 5; // Account has disabled HTTP delivery
    const IP_NOT_WHITELISTED       = 6; // Server IP not enabled
    const EMAIL_BLOCKED            = 7; // Account has disabled SMTP delivery
    const SMTP_SENDER_NOT_ENABLED  = 8; // This sender is not enabled to send messages for this account
    const MODERATOR_BLOCKED        = 9;
    const INCORRECT_RECIPIENT_LIST = 10; // Incorrect chars in phone list
    const EMPTY_MESSAGE            = 11; // Message body is empty
    const EMPTY_RECIPIENT_LIST     = 12; // Recipient list is empty
    const SERVICE_UNAVAILABLE      = 13; // Service is temporary unavailable
    const INVALID_DATE_FORMAT      = 14; // Invalid "send_on" date format
    const WEB_SENDING_THROTTLED    = 15; // Web sending is on 10 second cooldown
    const DEALER_OFF               = 16; // Services are unavailable for dealers
    const ERROR_MULTIACCESS        = 17; // Access action is already used
    const INCORRECT_GROUP          = 20; // Invalid "group" parameter format
    const EMPTY_PASSWORD           = 21; // Password not provided
    const EMPTY_LOGIN              = 22; // Login not provided
    const INVALID_ALIAS            = 23; // Incorrect alias
    const FLOOD                    = 24; // Recipients are brute-forced
}
