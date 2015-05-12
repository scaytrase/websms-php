<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-12
 * Time: 22:42
 */

namespace ScayTrase\WebSMS\Driver;

use ScayTrase\WebSMS\Connection\WebSmsStatus;

interface DriverInterface extends WebSmsStatus
{
    /**
     * @param array $options
     *
     * @return array
     */
    public function doSendRequest(array $options);
}
