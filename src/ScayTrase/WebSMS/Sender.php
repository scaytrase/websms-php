<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 2015-05-09
 * Time: 20:10
 */

namespace ScayTrase\WebSMS;

use ScayTrase\WebSMS\Connection\Connection;

class Sender
{
    /** @var  Connection */
    private $connection;

    /**
     * Sender constructor.
     *
     * @param $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


}
